<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="float-start">Listado de Radio Grafias</h5>
                            </div>
                            <div class="col-6">
                                <button @click="showDialog" class="btn btn-success btn-sm float-end">Nuevo</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table bordered">
                            <thead>
                                <tr>
                                    <th scope="col">radioGrafia</th>
                                    <th scope="col">fecha</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in radioGrafias" :key="item.id">
                                    <td><img :src="`/img/prevista/${item.nombre}`" :alt="`${item.nombre}`"
                                        style="width: 150px;height: 100px"></td>
                                    <td>{{ item.fecha }}</td>
                                    <td>{{ item.paciente.nombreCom }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                            @click="showDialogEditar(item)">Editar</button>
                                        &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminar(item)">Eliminar</button>
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
    <div class="modal fade" id="marcaModal" tabindex="-1" aria-labelledby="marcaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="marcaModalLabel">{{ formTitle }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->
                    <div class="row">
                        <div class="form-group col-6">
                        <label for="formfile" class="form-label">Seleccione una imagen para la Radio grafia</label>
                        <input type="file" class="form-control" accept="img/*" @change="getImage">
                    </div>
                    <div class="col-6">
                        <figure>
                            <img v-if="imagePreview" :src="imagePreview" width="200" height="150" alt="" />
                        </figure>
                    </div>
                    </div>
                    <div class="form-group col-6">
                            <label for="descripcion">Pacientes</label>
                            <select v-model="radioGrafia.paciente_id" class="form-control">
                                <option v-for="mark in pacientes" :value="mark.id">
                                    {{ mark.nombreCom }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="radioGrafiaErrors.paciente">Seleccione doctor</span>
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
            pacientes:[],
            radioGrafias: [],
            radioGrafia: {
                id: null,
                nombre: "",
                fecha: "",
                paciente: null,
                paciente_id: null
            },
            imagePublic: null,
            imagePreview: null,
            editedRadio: -1,
            radioGrafiaErrors: {
                nombre: false,
                fecha: false,
                paciente: null,
                paciente_id: null
            }
        }
    },
    computed: {
        formTitle() {
            return this.radioGrafia.id == null ? "Agregar Radio grafia" : "Actualizar Radio grafia";
        },
        btnTitle() {
            return this.radioGrafia.id == null ? "Guardar" : "Actualizar";
        }
    },
    methods: {
        async fetchPaciente() {
            let me = this;
            await this.axios.get('/pacientes')
                .then(response => {
                    me.pacientes = response.data;
                })
        },
        async fetchMarcas() {
            let me = this;
            await this.axios.get('/radios')
                .then(response => {
                    me.marcas = response.data;
                })
        },
        showDialog() {
            this.marca = {
                id: null,
                nombre: "",
                fecha:"",
                paciente:null,
                paciente_id: ""
            };
            imagePublic: null,
                this.imagePreview = null;
            this.marcaErrors = {
                nombre: false,
                fecha: false,
                paciente_id: false
            };
            $('#marcaModal').modal('show');
        },
        showDialogEditar(radioGrafia) {
            let me = this;
            $('#marcaModal').modal('show');
            me.editedRadio = me.radioGrafias.indexOf(radioGrafia);
            me.marca = Object.assign({}, radioGrafia);
            me.imagePreview = "/img/prevista/" + me.radioGrafia.nombre;
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.marca = {
                    id: null,
                    nombre: ""
                }
                me.imagePreview = null,
                    me.imagePublic = null

            }, 300);
            $('#marcaModal').modal('hide');
        },
        async saveOrUpdate() {
            let me = this;
            me.radioGrafia.nombre == '' ? me.radioGrafiaErrors.nombre == true : me.radioGrafiaErrors.nombre = false;
            me.radioGrafia.paciente_id == '' ? me.radioGrafiaErrors.paciente_id == true : me.radioGrafiaErrors.paciente_id = false;
            if (me.radioGrafia.nombre) {

                let accion = me.radioGrafia.id == null ? "add" : "upd";
                let formData = new FormData();
                formData.append("nombre", me.publicidad.nombre);
                formData.append("fecha", me.publicidad.fecha);
                formData.append("paciente_id", me.publicidad.paciente_id);

                
                if (me.imagePublic != null) {
                    formData.append("nombre", me.imagePublic);
                }
                let headers = {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                };

                if (accion == "add") {
                    //peticion para guardar una marca
                    await this.axios.post('/radios', formData, headers)
                        .then(response => {
                            console.log(response.data);
                            if (response.status == 201) {
                                me.verificarAccion(response.data.data, response.status, accion);
                                me.hideDialog();
                            }
                        }).catch(errors => {
                            console.log(errors);
                        })
                } else {
                    //peticion para actualizar una marca
                    await this.axios.put(`/radios/${me.radioGrafia.id}`, formData, headers)
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
        async eliminar(radioGrafia){
            //alert(marca.id);
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
                if(result.value){
                    me.editedRadio = me.radioGrafias.indexOf(radioGrafia);
                    this.axios.delete(`/radios/${radioGrafia.id}`)
                    .then(response => {
                        me.verificarAccion(null, response.status, "del");
                    }).catch(errors => {
                        console.log(errors);
                    })
                }
            })
        },
        verificarAccion(radioGrafia, statusCode, accion) {
            let me = this;
            const Toast = this.$swal.mixin({
                toast: true,
                position: 'top-right',
                iconColor: 'white',
                showConfirmButton: false,
                timer: 2000
            });
            switch (accion) {
                case "add":
                    //agregamos al principio del arreglo marcas, la nueva marca
                    me.radioGrafias.unshift(radioGrafia);
                    Toast.fire({
                        icon: 'success',
                        'title': 'Radiografia registrada con exito...!'
                    });
                    break;
                case "upd":
                    Object.assign(me.radioGrafias[me.editedRadio], radioGrafia);
                    Toast.fire({
                        icon: 'success',
                        'title': 'Radiografia actualizada con exito...!'
                    });
                    break;
                case "del":
                    if (statusCode == 205) {
                            me.radioGrafias.splice(this.editedRadio, 1);
                            Toast.fire({
                                icon: 'success',
                                'title': 'Marca eliminada con exito...!'
                            });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            text: 'No puede eliminar, ya existen autos registrados con esta marca!'
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
        // this.$swal('Welcome to RentasCars!!!');
        this.fetchPaciente();
        this.fetchMarcas();
    }
}
</script>