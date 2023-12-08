<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <button @click="showDialog" class="btn btn-success float-end">Nuevo</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in citas" :key="item">

                                    <td>{{ item.dia }}</td>
                                    <td>{{ item.hora }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm"
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="citaModal" tabindex="-1" aria-labelledby="citaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="citaModalLabel">{{ formTitle }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->
                    <div class="row">
                        <div class="form-group col-4">
                            <label for="dia">dias disponibles</label>
                            <input id="date1" v-model="cita.dia" size="60" type="date" format="DD/MM/YYYY"
                                placeholder="DD/MM/YYYY" @click="sinfin" />
                            <span class="text-danger" v-show="citaErrors.dia">dia es requerido</span>
                        </div>
                        <div class="form-group col-4">
                            <label for="tipo">Horas disponibles</label>
                            <select v-model="cita.hora" class="form-control">
                                <option v-for="item in horas" :value="item.value">
                                    {{ item.text }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="citaErrors.hora">Seleccione una hora</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="descripcion">paciente</label>
                            <select v-model="cita.paciente_id" class="form-control">
                                <option v-for="mark in pacientes" :value="mark.id">
                                    {{ mark.nombreCom }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="citaErrors.paciente">Seleccione doctor</span>
                        </div>
                        <div class="form-group col-3">
                            <label for="descripcion">Doctores</label>
                            <select v-model="cita.doctor_id" class="form-control">
                                <option v-for="mark in doctores" :value="mark.id">
                                    {{ mark.nombre }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="citaErrors.paciente">Seleccione doctor</span>
                        </div>
                        <!-- <div class="form-group col-3">
                            <label for="descripcion">paciente</label>
                            <select class="form-control">
                                <option v-for="mark in pacientes" :value="mark.id">
                                    {{ mark.nombreCom }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="citaErrors.paciente">Seleccione doctor</span>
                        </div> -->
                        <div class="form-group col-3">
                            <label for="descripcion">tratamientos</label>
                            <select v-model="cita.tratamiento_id" class="form-control">
                                <option v-for="mark in tratamientos" :value="mark.id">
                                    {{ mark.nombreTrabajo }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="citaErrors.tratamiento_id">Seleccione doctor</span>
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
    props: ['user'],
    data() {
        return {
            citas: [],
            cita: {
                id: null,
                dia: "",
                hora: "",
                paciente_id: null,
                tratamiento_id: null,
                doctor: null,
                doctor_id: null,
                paciente: null,
                tratamiento: null

            },
            editedCita: -1,
            citaErrors: {
                dia: false,
                hora: false,
                paciente_id: false,
                tratamiento_id: false,
                doctor_id:null,
                doctor: null,
                paciente: false,
                tratamiento: false

            },
            horas: [
                { text: '7.00 am', value: '7.00am' },
                { text: '7.30 am', value: '7.30am' },
                { text: '8.00 am', value: '8.00am' },
                { text: '8.30 am', value: '8.30am' }
            ],
            doctores: [],
            pacientes: [],
            tratamientos: [],
            users: [],
            date2: new Date()
        }
    },
    computed: {


        formTitle() {
            return this.cita.id == null ? "Agregar cita" : "Actualizar cita";
        },
        btnTitle() {
            return this.cita.id == null ? "Guardar" : "Actualizar";
        },
    },
    methods: {
        /*  async fecha() {
             let me = this;
             await this.axios.fecha('/citas')
                 .then(response => {
                     me.fechaMin = response.data;
                 })
         }, */
        async sinfin() {
            let me = this;
            const toast = this.$swal.mixin({
                title: 'No puedes seleccionar fin de semana',
                text: "Porfavor seleccione un dia laboral",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'entendido',
            });
            date1.min = new Date().toISOString().split("T")[0];
            var date2 = new Date();
            var test = date2.getMonth();
            var año = date2.getFullYear();
            if (date2.getDate() <= 27) {
                var ex =test+1 == 4 ? 30 :(test+1 == 2 ? 28 :(test+1 == 6 ? 30 : (test+1 == 9 ? 30 :(test+1 == 11 ? 30 : 31))));
                console.log(test+1);
                date1.max = new Date(año, test, ex).toISOString().split("T")[0];
            }else{
                var ex =test+1 == 4 || 6 || 9 || 11 ? 30 :(test+1 == 2 ? 28 : 31);
                date1.max = new Date(año,test+1,ex).toISOString().split("T")[0];
            }   
            const picker = document.getElementById('date1');       
            picker.addEventListener('input', function (e) {
                var day = new Date(this.value).getUTCDay();
                if ([0].includes(day)) {
                    e.preventDefault();
                    this.value = '';
                    toast.fire();
                }
            });


        },
        async fetchTratamiento() {
            let me = this;
            await this.axios.get('/tratamient')
                .then(response => {
                    me.tratamientos = response.data;
                })
        },
        async traeDocs() {
            let me = this;
            await this.axios.get('/doctores')
                .then(response => {
                    me.doctores = response.data;
                })
        },
        async fetchUsers() {
            let me = this;
            await this.axios.get('/citas-versas')
                .then(response => {
                    me.users = response.data;
                })
        },
        async fetchPaciente() {
            let me = this;
            await this.axios.get('/pacientes')
                .then(response => {
                    me.pacientes = response.data;
                })
        },
        async fetchCita() {
            let me = this;
            await this.axios.get('/citas')
                .then(response => {
                    me.citas = response.data;
                })
        },
        showDialog() {
            this.cita = {
                id: null,
                dia: "",
                hora: "",
                paciente_id: null,
                tratamiento_id: null,
                paciente: null,
                doctor_id:null,
                doctor: null,
                tratamiento: null
            };
            this.citaErrors = {
                dia: false,
                hora: false,
                paciente_id: false,
                tratamiento_id: false, doctor_id:null,
                doctor: null,
                doctor_id:null,
                paciente: false,
                tratamiento: false
            };
            $('#citaModal').modal('show');
        },
        showDialogEditar(cita) {
            let me = this;
            $('#citaModal').modal('show');
            me.editedCita = me.citas.indexOf(cita);
            me.cita = Object.assign({}, cita);
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.cita = {
                    id: null,
                    dia: "",
                    hora: 0,
                    paciente_id: null,
                    tratamiento_id: null,
                    doctor_id:null,
                    paciente: null,
                    tratamiento: null
                }
            }, 300);
            $('#citaModal').modal('hide');
        },
        async saveOrUpdate() {
            let me = this;
            me.cita.dia == '' ? me.citaErrors.dia == true : me.citaErrors.dia = false;
            me.cita.hora == '' ? me.citaErrors.hora == true : me.citaErrors.hora = false;
            me.cita.paciente_id == '' ? me.citaErrors.paciente_id == true : me.citaErrors.paciente_id = false;
            me.cita.doctor_id == '' ? me.citaErrors.doctor_id == true : me.citaErrors.doctor_id = false;
            me.cita.tratamiento_id == '' ? me.citaErrors.tratamiento_id == true : me.citaErrors.tratamiento_id = false;
            if (me.cita.dia) {
                let accion = me.cita.id == null ? "add" : "upd";
                if (accion == "add") {
                    //peticion para guardar una cita
                    await this.axios.post('/citas', me.cita)
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
                    //peticion para actualizar una cita
                    await this.axios.put(`/citas/${me.cita.id}`, me.cita)
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
        async eliminar(cita) {
            //alert(cita.id);
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
                    me.editedCita = me.citas.indexOf(cita);
                    this.axios.delete(`/citas/${cita.id}`)
                        .then(response => {
                            me.verificarAccion(null, response.status, "del");
                        }).catch(errors => {
                            console.log(errors);
                        })
                }
            })
        },
        verificarAccion(cita, statusCode, accion) {
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
                    //agregamos al principio del arreglo cita, la nueva cita
                    me.citas.unshift(cita);
                    Toast.fire({
                        icon: 'success',
                        'title': 'cita registrado con exito...!'
                    });
                    break;
                case "upd":
                    Object.assign(me.citas[me.editedCita], cita);
                    Toast.fire({
                        icon: 'success',
                        'title': 'cita actualizad0 con exito...!'
                    });
                    break;
                case "del":
                    if (statusCode == 205) {
                        me.citas.splice(this.editedCita, 1);
                        Toast.fire({
                            icon: 'success',
                            'title': 'cita eliminado con exito...!'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            text: 'No puede eliminar, ya existen autos registrados con esta cita!'
                        });
                    }
                    break;
                default:
                    break;
            }
        },
    },
    mounted() {
        // this.$swal('Welcome to RentasCars!!!');
        this.traeDocs();
        this.fetchCita();
        this.fetchUsers();
        this.fetchPaciente();
        this.fetchTratamiento();
        console.log(this.user);
    }
}
</script>