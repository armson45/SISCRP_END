<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="float-start">
                                    Gestion De Radiografias
                                </h5>
                            </div>
                            <div class="col-3">
                                <button
                                    @click="showDialog"
                                    class="btn btn-success btn-sm float-end"
                                >
                                    Nuevo
                                </button>
                            </div>
                            <!--<div class="col-3">
                                <a href="/reportes/autos/pdf" target="_blank" class="btn btn-primary btn-sm">Generar PDF</a>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="input-group rounded">
                                <input
                                    type="search"
                                    v-model="search"
                                    @input="filterData(search)"
                                    class="form-control rounded"
                                    placeholder="Buscar"
                                    aria-label="Search"
                                    aria-describedby="search-addon"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Radiografia</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in radiografias" :key="item.id">
                                    <td>
                                        <img
                                            :src="`/img/prevista/${item.nombre}`"
                                            :alt="'${item.nombre}'"
                                            style="width: 150px; height: 100px"
                                        />
                                    </td>
                                    <td>{{ item.fecha }}</td>
                                    <td>{{ item.paciente?.nombreCom }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm"
                                            @click="showDialogEditar(item)"
                                        >
                                            Editar
                                        </button>
                                        &nbsp;
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm"
                                            @click="eliminar(item)"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div
        class="modal fade"
        id="radiografiaModal"
        tabindex="-1"
        aria-labelledby="marcaModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="marcaModalLabel">
                        {{ formTitle }}
                    </h3>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="formfile" class="form-label"
                                >Seleccione una imagen para la Radio
                                grafia</label
                            >
                            <input
                                type="file"
                                class="form-control"
                                accept="image/*"
                                @change="getImage"
                            />
                        </div>
                        <div class="col-6">
                            <figure>
                                <img
                                    v-if="imagePreview"
                                    :src="imagePreview"
                                    width="200"
                                    height="150"
                                    alt=""
                                />
                            </figure>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="fecha">Fecha de la Radiografía</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="radiografia.fecha"
                        />
                        <span
                            class="text-danger"
                            v-show="radiografiaErrors.fecha"
                            >Seleccione una fecha</span
                        >
                    </div>

                    <div class="form-group col-6">
                        <label for="descripcion">Pacientes</label>
                        <select
                            v-model="radiografia.paciente_id"
                            class="form-control"
                        >
                            <option
                                v-for="paciente in pacientes"
                                :value="paciente.id"
                            >
                                {{ paciente.nombreCom }}
                            </option>
                        </select>
                        <span
                            class="text-danger"
                            v-show="radiografiaErrors.paciente"
                            >Seleccione un paciente</span
                        >
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cerrar
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="saveOrUpdate"
                    >
                        {{ btnTitle }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            radiografias: [],
            //Este es un objeto
            radiografia: {
                id: null,
                nombre: "",
                fecha: "",
                paciente_id: null,
                paciente: null,
            },
            imageRadiografia: null,
            imagePreview: null,
            editedRadiografia: -1,
            radiografiaErrors: {
                nombre: false,
                fecha: false,
                paciente: false,
            },
            filters: [],
            search: "",
            //Creando el arreglo de paciente
            pacientes: [],
        };
    },

    //Estas son propiedades computed
    computed: {
        formTitle() {
            return this.radiografia.id == null
                ? "Agregar Radiografia"
                : "Actualizar Radiografia";
        },
        btnTitle() {
            return this.radiografia.id == null ? "Guardar" : "Actualizar";
        },
    },

    //Estos son metodos
    methods: {
        async fetchRadiografias() {
            let me = this;
            await this.axios.get("/radios").then((response) => {
                //console.log(response.data);
                me.radiografias = response.data;
            });
        },
        async fetchPacientes() {
            let me = this;
            await this.axios.get("/pacientes").then((response) => {
                me.pacientes = response.data;
            });
        },

        //Este metodo showDialog es para mostrar el elemento cuyo id sea marcaModal es solo para mostrar el modal
        showDialog() {
            this.radiografia = {
                id: null,
                nombre: "",
                fecha: "",
                paciente_id: null,
                paciente: null,
            };
            imageRadiografia: null, (this.imagenPreview = null);
            this.autoErrors = {
                nombre: false,
                fecha: false,
                paciente: false,
            };
            $("#radiografiaModal").modal("show");
        },

        //Este metodo showDialogEditar es para editar
        showDialogEditar(radiografia) {
            let me = this;
            $("#radiografiaModal").modal("show");
            me.editedRadiografia = me.radiografias.indexOf(radiografia);
            me.radiografia = Object.assign({}, radiografia);
            me.imagePreview = "/img/prevista/" + me.radiografia.nombre;
        },

        //Metodo para cerrar la ventana cada vez que guardo una nueva marca
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.radiografia = {
                    id: null,
                    nombre: "",
                    fecha: "",
                    paciente: null,
                };
            }, 300);
            $("#radiografiaModal").modal("hide");
        },
        formatDate(date) {
            const year = date.getFullYear();
            const month = ("0" + (date.getMonth() + 1)).slice(-2);
            const day = ("0" + date.getDate()).slice(-2);
            return `${year}-${month}-${day}`;
        },

        async saveOrUpdate() {
            let me = this;

            me.radiografia.nombre == ""
                ? (me.radiografiaErrors.nombre = true)
                : (me.radiografiaErrors.nombre = false);

            me.radiografia.fecha == ""
                ? (me.radiografiaErrors.fecha = true)
                : (me.radiografiaErrors.fecha = false);

            me.radiografia.paciente_id == ""
                ? (me.radiografiaErrors.paciente = true)
                : (me.radiografiaErrors.paciente = false);

            if (!me.radiografiaErrors.fecha && !me.radiografiaErrors.paciente) {
                let accion = me.radiografia.id == null ? "add" : "upd";
                let formData = new FormData();

                // Solo verifica errores relacionados con el nombre si hay un archivo seleccionado
                if (me.imageRadiografia != null) {
                    me.radiografia.nombre == ""
                        ? (me.radiografiaErrors.nombre = true)
                        : (me.radiografiaErrors.nombre = false);

                    formData.append("nombre", me.imageRadiografia);
                }

                // Formatear la fecha antes de enviarla
                let formattedFecha = me.formatDate(
                    new Date(me.radiografia.fecha)
                );
                formData.append("fecha", formattedFecha);
                formData.append("paciente_id", me.radiografia.paciente_id);

                let headers = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                if (accion == "add") {
                    //Peticion para guardar una marca

                    await this.axios
                        .post(`/radios`, formData, headers)
                        .then((response) => {
                            //Console.log(response.data);
                            if (response.status == 201) {
                                me.verificarAccion(
                                    response.data.data,
                                    response.status,
                                    accion
                                );
                                me.hideDialog();
                            }
                        })
                        .catch((errors) => {
                            console.log(errors);
                        });
                } else {
                    //Peticion para actualizar una marca
                    await this.axios
                        .put(
                            `/radios/${this.radiografia.id}`,
                            formData,
                            headers
                        )

                        .then((response) => {
                            if (response.status == 202) {
                                me.verificarAccion(
                                    response.data.data,
                                    response.status,
                                    accion
                                );
                                me.hideDialog();
                            }
                        })
                        .catch((errors) => {
                            console.error(
                                "Error al realizar la solicitud:",
                                errors
                            );
                            console.log(errors);
                        });
                }
            }
        },

        async eliminar(radiografia) {
            let me = this;
            this.$swal
                .fire({
                    title: "Seguro/a de eliminar este registro?",
                    text: "No podras revertir la accion",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                })
                .then((result) => {
                    if (result.value) {
                        me.editedRadiografia =
                            me.radiografias.indexOf(radiografia);
                        this.axios
                            .delete(`/radios/${radiografia.id}`)
                            .then((response) => {
                                me.verificarAccion(
                                    null,
                                    response.status,
                                    "del"
                                );
                            })
                            .catch((errors) => {
                                console.log(errors);
                            });
                    }
                });
        },

        verificarAccion(radiografia, statusCode, accion) {
            let me = this;
            const Toast = this.$swal.mixin({
                toast: true,
                position: "top-right",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
            switch (accion) {
                case "add":
                    //Asignamos el nuevo objeto al array autos
                    //me.autos.unshift(auto);
                    me.fetchRadiografias();
                    Toast.fire({
                        icon: "success",
                        title: "Radiografia Registrada con Exito",
                    });
                    break;
                case "upd":
                    Object.assign(
                        me.radiografias[me.editedRadiografia],
                        radiografia
                    );
                    Toast.fire({
                        icon: "success",
                        title: "Radiografia Actualizado con Exito",
                    });
                    break;

                case "del":
                    if (statusCode == 205) {
                        try {
                            me.radiografia.splice(me.editedRadiografia, 1);
                            //Se lanza mensaje final
                            Toast.fire({
                                icon: "success",
                                title: "Radiografia Eliminada...!!!",
                            });
                        } catch (error) {
                            console.log(error);
                        }
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: "Ocurrio un error, intente de nuevo",
                        });
                    }
                    break;
            }
        },
        getImage(event) {
            let file = event.target.files[0];
            this.imageRadiografia = file;
            this.loadImage(file);
        },
        loadImage(file) {
            let reader = new FileReader();
            reader.onload = (e) => (this.imagePreview = e.target.result);
            reader.readAsDataURL(file);
        },
    },

    mounted() {
        //this.$swal('Hello Vue world!!!');
        this.fetchRadiografias();
        this.fetchPacientes();
    },
};
</script>
