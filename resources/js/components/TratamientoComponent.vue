<template>
    <div class="container bg-white rounded">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row col-12 p-4">
                    <div class="col-md-6">
                        <button @click="showDialog" class="btn btn-success"><i class="bi bi-file-earmark-plus-fill"></i>
                            &nbsp; Agregar
                        </button>
                    </div>
                    <div class="input-group col-md-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        </div>
                        <input type="search" v-model="search" @input="filterData(search)" class="form-control"
                            placeholder="Buscar" aria-label="Buscar" aria-describedby="search-addon">
                    </div>
                    <!-- <div class="input-group col-md-4">
                        <input type="search" v-model="search" @input="filterData(search)" class="form-control rounded"
                            placeholder="Buscar" arial-label="search" aria-describedby="search-addon" />
                    </div> -->
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Imágen</th>
                                <th>Precio</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>
                                <th>Especialidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in tratamientos" :key="item.id">
                                <td>{{ item.nombreTrabajo }}</td>
                                <td>{{ item.descripcion }}</td>
                                <td><img :src="`/img/prevista/${item.imagen}`" :alt="`${item.imagen}`"
                                        style="width: 150px;height: 100px"></td>
                                <td>{{ item.precio }}</td>
                                <td>{{ item.fechaInicio }}</td>
                                <td>{{ item.fechaFinal }}</td>
                                <td>{{ item.especialidad.nombre }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        @click="showDialogEditar(item)">Editar</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-danger btn-sm"
                                        @click="eliminar(item)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tratamientoModal" tabindex="-1" aria-labelledby="tratamientoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="tratamientoModalLabel">{{ formTitle }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nombreTrabajo">Trabajo</label>
                            <input type="text" class="form-control" v-model="tratamiento.nombreTrabajo">
                            <span class="text-danger" v-show="tratamientoErrors.nombreTrabajo">nombreTrabajo
                                requerido</span>
                        </div>
                        <div class="form-group col-6">
                            <label for="descripcion">Descripción</label>
                            <input type="text" v-model="tratamiento.descripcion" class="form-control">
                            <span class="text-danger" v-show="tratamientoErrors.descripcion">Seleccione descripcion</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="descripcion">Especialidades</label>
                            <select v-model="tratamiento.especialidad_id" class="form-control">
                                <option v-for="mark in especialidades" :value="mark.id">
                                    {{ mark.nombre }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="tratamientoErrors.especialidad">Seleccione especialidad</span>
                        </div>
                        <div class="form-group col-6">
                            <label for="descripcion">Precio</label>
                            <input type="number" class="form-control" id="losj" v-model="tratamiento.precio" />
                            <span class="text-danger" v-show="tratamientoErrors.precio">Seleccione precio</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="descripcion">Fecha Inicio</label>
                            <input type="date" class="form-control" v-model="tratamiento.fechaInicio">
                            <!-- <span class="text-danger" v-show="tratamientoErrors.fechaInicio">fecha es requerida</span> -->
                        </div>
                        <div class="form-group col-6">
                            <label for="nombreTrabajo">Fecha Final</label>
                            <input type="date" class="form-control" v-model="tratamiento.fechaFinal">
                            <!-- <span class="text-danger" v-show="tratamientoErrors.fechaFinal">fecha es requerida</span> -->
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="formfile" class="form-label">Seleccione una imagen para el tratamiento</label>
                        <input type="file" class="form-control" accept="image/png, image/jpeg, image/gif"
                            @change="getImage">
                    </div>
                    <div class="col-6">
                        <figure>
                            <img v-if="imagePreview" :src="imagePreview" width="200" height="150" alt="" />
                        </figure>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="saveOrUpdate"> {{ btnTitle }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            fecha: "",
            tratamientos: [],
            tratamiento: {
                id: null,
                nombreTrabajo: "",
                descripcion: "",
                imagen: "",
                precio: "",
                fechaInicio: "",
                fechaFinal: "",
                especialidad: null,
                especialidad_id: null
            },
            imagePublic: null,
            imagePreview: null,
            editedtratamiento: -1,
            tratamientoErrors: {
                nombreTrabajo: false,
                descripcion: false,
                imagen: false,
                precio: false,
                fechaInicio: false,
                fechaFinal: false,
                especialidad: null,
                especialidad_id: null
            },
            filters: [],
            search: "",
            especialidades: []
        }
    },
    computed: {

        formTitle() {
            return this.tratamiento.id == null ? "Agregar tratamiento" : "Actualizar tratamiento";
        },
        btnTitle() {
            return this.tratamiento.id == null ? "Guardar" : "Actualizar";
        },
        items() {
            return this.tratamientos.filter(item => {
                return item.descripcion.toLowerCase().includes(this.search.toLowerCase());
            });
        }
        // items() {
        //     return this.tratamientos.filter(item => {
        //         return item.nombreTrabajo.toLowerCase().includes(this.search.toLowerCase());
        //     })
        // }

        // matchesSearch() {
        //     //const searchTermLowerCase = this.search.toLowerCase();
        //     const searchNombre = this.search.toLowerCase();
        //     //const especialidadMatch = item.especialidad.nombre.toLowerCase().includes(searchTermLowerCase);
        //     return this.tratamientos.filter(tratamiento => {
        //         const matchNombre = tratamiento.nombreTrabajo.toLowerCase().includes(searchNombre);
        //         //const matchEspecialidad = searchEspecialidad == '' || tratamiento.especialidad.toLowerCase().includes(searchEspecialidad);
        //         return matchNombre;
        //     });
        // }

    },
    methods: {
        async fetchtratamientos() {
            let me = this;
            await this.axios.get('/tratamient')
                .then(response => {
                    me.tratamientos = response.data;
                })
        },
        async fetchDoct() {
            let me = this;
            await this.axios.get('/especialidades')
                .then(response => {
                    me.especialidades = response.data;
                })
        },
        async fetchprecios() {
            let me = this;
            await this.axios.get('/precios')
                .then(response => {
                    me.precios = response.data;
                })
        },
        //         getFecha(){
        // this.fecha = 
        //         },
        showDialog() {
            this.tratamiento = {
                id: null,
                nombreTrabajo: "",
                descripcion: "",
                imagen: "",
                precio: "",
                fechaInicio: "",
                fechaFinal: "",
                especialidad: null,
                especialidad_id: null
            };
            imagePublic: null,
                this.imagePreview = null;
            this.tratamientoErrors = {
                nombreTrabajo: false,
                descripcion: false,
                imagen: false,
                precio: false,
                fechaInicio: false,
                fechaFinal: false,
                especialidad: null,
                especialidad_id: null
            };
            $('#tratamientoModal').modal('show');
        },
        showDialogEditar(tratamiento) {
            let me = this;
            $('#tratamientoModal').modal('show');
            me.editedtratamiento = me.tratamientos.indexOf(tratamiento);
            me.tratamiento = Object.assign({}, tratamiento);
            me.imagePreview = "/img/prevista/" + me.tratamiento.imagen;
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.tratamiento = {
                    id: null,
                    nombreTrabajo: "",
                    descripcion: "",
                    imagen: "",
                    precio: "",
                    fechaInicio: "",
                    fechaFinal: "",
                    especialidad: null,
                    especialidad_id: null
                }
                me.imagePreview = null,
                    me.imagePublic = null

            }, 300);
            $('#tratamientoModal').modal('hide');
        },

        async saveOrUpdate() {
            let me = this;
            me.tratamiento.nombreTrabajo == '' ? me.tratamientoErrors.nombreTrabajo = true : me.tratamientoErrors.nombreTrabajo = false;
            me.tratamiento.descripcion == '' ? me.tratamientoErrors.descripcion = true : me.tratamientoErrors.descripcion = false;
            me.tratamiento.imagen == null ? me.tratamientoErrors.imagen = true : me.tratamientoErrors.imagen = false;
            me.tratamiento.precio == null ? me.tratamientoErrors.precio = true : me.tratamientoErrors.precio = false;
            me.tratamiento.fechaInicio == null ? me.tratamientoErrors.fechaInicio = true : me.tratamientoErrors.fechaInicio = false;
            me.tratamiento.fechaFinal == null ? me.tratamientoErrors.fechaFinal = true : me.tratamientoErrors.fechaFinal = false;
            me.tratamiento.especialidad_id == null ? me.tratamientoErrors.especialidad = true : me.tratamientoErrors.especialidad = false;

            if (me.tratamiento.nombreTrabajo) {

                let accion = me.tratamiento.id == null ? "add" : "upd";
                let formData = new FormData();

                formData.append("nombreTrabajo", me.tratamiento.nombreTrabajo);
                formData.append("descripcion", me.tratamiento.descripcion);
                formData.append("imagen", me.tratamiento.imagen);
                formData.append("precio", me.tratamiento.precio);
                formData.append("fechaInicio", me.tratamiento.fechaInicio);
                formData.append("fechaFinal", me.tratamiento.fechaFinal);
                formData.append("especialidad_id", me.tratamiento.especialidad_id);

                if (me.imagePublic != null) {
                    formData.append("imagen", me.imagePublic);
                }
                let headers = {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                };
                if (accion == "add") {
                    //peticion para guardar una tratamiento
                    await this.axios.post('/tratamient', formData, headers)
                        .then(response => {
                            //console.log(response.data);
                            if (response.status == 201) {
                                me.verificarAccion(response.data.data, response.status, accion);
                                me.hideDialog();
                            }
                        }).catch(errors => {
                            console.log(errors);
                        })
                } else {
                    formData.append("id", me.tratamiento.id)
                    //peticion para actualizar una tratamiento
                    await this.axios.post(`/tratamient/${me.tratamiento.id}`, formData, headers)
                        .then(response => {
                            //console.log(response.data);
                            if (response.status == 202) {
                                me.verificarAccion(response.data.data, response.status, accion);
                                me.hideDialog();
                            }
                        }).catch(errors => {
                            console.log(errors);
                        })

                }
            }
        },
        async eliminar(tratamiento) {
            //alert(tratamiento.id);
            let me = this;
            this.$swal.fire({
                title: 'Seguro de eliminar este registro?',
                text: "No podrás revertir esta accion",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    me.editedtratamiento = me.tratamientos.indexOf(tratamiento);
                    this.axios.delete(`/tratamient/${tratamiento.id}`)
                        .then(response => {
                            me.verificarAccion(null, response.status, "del");
                        }).catch(errors => {
                            console.log(errors);
                        })
                }
            })
        },
        verificarAccion(tratamiento, statusCode, accion) {
            let me = this;
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 2000,
                tinerProgressBar: true
            });
            debugger;
            switch (accion) {
                case "add":
                    //agregamos al principio del arreglo tratamiento, la nueva tratamiento
                    //me.tratamiento.unshift(tratamiento);
                    me.fetchtratamientos();
                    Toast.fire({
                        icon: 'success',
                        'title': 'tratamiento registrada con exito...!'
                    });
                    break;
                case "upd":
                    /*  Object.assign(me.tratamientos[me.editedtratamiento], tratamiento); */
                    me.fetchtratamientos();
                    Toast.fire({
                        icon: 'success',
                        'title': 'tratamiento actualizada con exito...!'
                    });
                    break;
                case "del":
                    if (statusCode == 205) {
                        me.tratamientos.splice(this.editedtratamiento, 1);
                        Toast.fire({
                            icon: 'success',
                            'title': 'tratamiento eliminada con exito...!'
                        });
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            'title': 'Ocurrió un error, intente de nuevo...!'
                        });
                    }
                    break;
                default:
                    break;
            }
        },
        getImage(event) {
            let file = event.target.files[0];
            this.imagePublic = file;
            this.loadImage(file);
        },
        loadImage(file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    },
    mounted() {
        this.fetchtratamientos();
        this.fetchDoct();
    }
}
</script>