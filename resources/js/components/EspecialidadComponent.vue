<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class=" text-right">
                                <button @click="showDialog" class="btn btn-success"><i class="bi bi-file-earmark-plus-fill"></i> &nbsp; Agregar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered">
                            <thead class="">
                                <tr>
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in especialidades" :key="item.id">
                                    <td>{{ item.nombre }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info rounded-pill"
                                            @click="showDialogEditar(item)"> <i class="bi bi-pencil-fill"></i> &nbsp; <b>Editar</b></button>
                                        &nbsp;
                                        <button type="button" class="btn btn-danger rounded-pill" @click="eliminar(item)"> <i class="bi bi-trash-fill"> &nbsp;</i><b>Eliminar</b></button>
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
    <div class="modal fade" id="especialidadModal" tabindex="-1" aria-labelledby="especialidadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="especialidadModalLabel">{{ formTitle }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="nombre">Especialidad</label>
                            <input type="text" class="form-control" v-model="especialidad.nombre">
                            <span class="text-danger" v-show="especialidadErrors.nombre">Nombre es requerido</span>
                        </div>
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
            especialidades: [],
            especialidad: {
                id: null,
                nombre: ""
            },
            editedespecialidad: -1,
            especialidadErrors: {
                nombre: false
            }
        }
    },
    computed: {
        formTitle() {
            return this.especialidad.id == null ? "Agregar especialidad" : "Actualizar especialidad";
        },
        btnTitle() {
            return this.especialidad.id == null ? "Guardar" : "Actualizar";
        }
    },
    methods: {
        async fetchespecialidades() {
            let me = this;
            await this.axios.get('/especialidades')
                .then(response => {
                    me.especialidades = response.data;
                })
        },
        showDialog() {
            this.especialidad = {
                id: null,
                nombre: ""
            };
            this.especialidadErrors = {
                nombre: false
            };
            $('#especialidadModal').modal('show');
        },
        showDialogEditar(especialidad) {
            let me = this;
            $('#especialidadModal').modal('show');
            me.editedespecialidad = me.especialidades.indexOf(especialidad);
            me.especialidad = Object.assign({}, especialidad);
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.especialidad = {
                    id: null,
                    nombre: ""
                }
            }, 300);
            $('#especialidadModal').modal('hide');
        },
        async saveOrUpdate() {
            let me = this;
            me.especialidad.nombre == '' ? me.especialidadErrors.nombre == true : me.especialidadErrors.nombre = false;
            if (me.especialidad.nombre) {
                let accion = me.especialidad.id == null ? "add" : "upd";
                if (accion == "add") {
                    //peticion para guardar una especialidad
                    await this.axios.post('/especialidades', me.especialidad)
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
                    //peticion para actualizar una especialidad
                    await this.axios.put(`/especialidades/${me.especialidad.id}`, me.especialidad)
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
        async eliminar(especialidad){
            //alert(especialidad.id);
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
                    me.editedespecialidad = me.especialidades.indexOf(especialidad);
                    this.axios.delete(`/especialidades/${especialidad.id}`)
                    .then(response => {
                        me.verificarAccion(null, response.status, "del");
                    }).catch(errors => {
                        console.log(errors);
                    })
                }
            })
        },
        verificarAccion(especialidad, statusCode, accion) {
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
                    //agregamos al principio del arreglo especialidades, la nueva especialidad
                    me.especialidades.unshift(especialidad);
                    Toast.fire({
                        'icon': "success",
                        'title': "Especialidad registrada con éxito!"
                    });
                    break;
                case "upd":
                    Object.assign(me.especialidades[me.editedespecialidad], especialidad);
                    Toast.fire({
                        icon: 'success',
                        'title': 'especialidad actualizada con exito...!'
                    });
                    break;
                case "del":
                    if (statusCode == 205) {
                            me.especialidades.splice(this.editedespecialidad, 1);
                            Toast.fire({
                                icon: 'success',
                                'title': 'especialidad eliminada con exito...!'
                            });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            text: 'No puede eliminar, ya existen autos registrados con esta especialidad!'
                        });
                    }
                    break;
                default:
                    break;
            }
        }
    },
    mounted() {
        // this.$swal('Welcome to RentasCars!!!');
        this.fetchespecialidades();
    }
}
</script>