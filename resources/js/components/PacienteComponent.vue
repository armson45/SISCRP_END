<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <button @click="showDialog" class="btn btn-success">Agregar Paciente</button>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Paciente</th>
                                    <th scope="col">Número de teléfono</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="item in pacientes" :key="item">
                                    <td>{{ item.codigo }}</td>
                                    <td>{{ item.nombreCom }}</td>
                                    <td>{{ item.numTel }}</td>
                                    <td>{{ edadA = parseInt(this.edad) - parseFloat(item.fechaNacimiento) }}</td>
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
    <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="pacienteModalLabel">{{ formTitle }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->
                    <div class="row">
                        <div class="form-group col-3">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" id="toad" class="form-control" v-model="paciente.nombreCom">
                            <span class="text-danger" v-show="pacienteErrors.nombreCom">Nombre es requerido</span>
                        </div>
                        <div class="form-group col-3">
                            <label for="nombre">Numero de telefono</label>
                            <input type="text" id="losj" class="form-control" maxlength="8" size="13" v-model="paciente.numTel">
                            <span class="text-danger" v-show="pacienteErrors.numTel">numero es requerido</span>
                        </div>
                        <div class="form-group col-3">
                            <label for="nombre">Fecha de nacimiento</label>
                            <input id="date1" type="date" min="obtenerFechas" class="form-control" v-model="paciente.fechaNacimiento">
                            <span class="text-danger" v-show="pacienteErrors.fechaNacimiento">numero es requerido</span>
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
import { faElementor } from '@fortawesome/free-brands-svg-icons';

export default {
    props: ['user'],
    data() {
        return {
            newfecha:"",
            pacientes: [],
            paciente: {
                id: null,
                correlativo: "",
                nombreCom: "",
                numTel: "",
                fechaNacimiento: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                fechaRegistro: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                user: null
            },
            edadA: 0,
            editedPaciente: -1,
            fecha: 0,
            pacienteErrors: {
                correlativo: false,
                nombreCom: false,
                numTel: false,
                fechaNacimiento: false,
                fechaRegistro: false,
                user: null
            }
        }
    },
    computed: {
        obtenerFechas() {
            const picker = document.getElementById('date1');
            let fecha = new Date();
            let fechas = [];
            for (let i = 1; i <= 3; i++) {
                fechas.push(fecha.getFullYear() - i);
            }
            var y = fechas[1];
            var m = 12;
            var d = 31;
            var newfecha = `${y}-${m}-${d}`;
            console.log(newfecha);
            picker.setAttribute('max',newfecha);
            return newfecha;
        },


        edad() {

            let date = new Date();

            let day = date.getDate();
            let month = date.getMonth() + 1;
            let year = date.getFullYear();
            let fechar = `${year}/0${month}/0${day}`;



            this.fecha = fechar;

            return this.fecha;
        },
        /*         total(pacientes) {
                    var edad = 0;
                    pacientes.forEach(element => {
                        edad = (element.fechaNacimiento - this.fetchedad)
                    })
                    this.edadA = edad;
                    return edad;
                }, */
        formTitle() {
            return this.paciente.id == null ? "Agregar paciente" : "Actualizar paciente";
        },
        btnTitle() {
            return this.paciente.id == null ? "Guardar" : "Actualizar";
        }
        
    },
    methods: {
        async fetchpaciente() {
            let me = this;
            await this.axios.get('/pacientes')
                .then(response => {
                    me.pacientes = response.data;
                })
        },
        showDialog() {
            this.paciente = {
                id: null,
                correlativo: "",
                nombreCom: "",
                numTel: "",
                fechaNacimiento: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                fechaRegistro: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                user: null
            };
            this.pacienteErrors = {
                correlativo: false,
                nombreCom: false,
                numTel: false,
                fechaNacimiento: false,
                fechaRegistro: false,
                user: null
            };
            $('#pacienteModal').modal('show');
        },
        showDialogEditar(paciente) {
            let me = this;
            $('#pacienteModal').modal('show');
            me.editedPaciente = me.pacientes.indexOf(paciente);
            me.paciente = Object.assign({}, paciente);
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.paciente = {
                    id: null,
                    nombreCom: "",
                    numTel: 0,
                }
            }, 300);
            $('#pacienteModal').modal('hide');
        },
        async saveOrUpdate() {
            let me = this;
            me.paciente.user = this.user;
            me.paciente.correlativo == '' ? me.pacienteErrors.correlativo == true : me.pacienteErrors.correlativo = false;
            me.paciente.nombreCom == '' ? me.pacienteErrors.nombreCom == true : me.pacienteErrors.nombreCom = false;
            me.paciente.numTel == '' ? me.pacienteErrors.numTel == true : me.pacienteErrors.numTel = false;
            me.paciente.fechaNacimiento == '' ? me.pacienteErrors.fechaNacimiento == true : me.pacienteErrors.fechaNacimiento = false;
            if (me.paciente.nombreCom) {
                let accion = me.paciente.id == null ? "add" : "upd";
                if (accion == "add") {
                    //peticion para guardar una paciente
                    await this.axios.post('/pacientes', me.paciente)
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
                    //peticion para actualizar una paciente
                    await this.axios.put(`/pacientes/${me.paciente.id}`, me.paciente)
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
        async eliminar(paciente) {
            //alert(paciente.id);
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
                    me.editedPaciente = me.pacientes.indexOf(paciente);
                    this.axios.delete(`/pacientes/${paciente.id}`)
                        .then(response => {
                            me.verificarAccion(null, response.status, "del");
                        }).catch(errors => {
                            console.log(errors);
                        })
                }
            })
        },
        verificarAccion(paciente, statusCode, accion) {
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
                    //agregamos al principio del arreglo paciente, la nueva paciente
                    me.pacientes.unshift(paciente);
                    Toast.fire({
                        icon: 'success',
                        'title': 'paciente registrado con exito...!'
                    });
                    break;
                case "upd":
                    Object.assign(me.pacientes[me.editedPaciente], paciente);
                    Toast.fire({
                        icon: 'success',
                        'title': 'paciente actualizad0 con exito...!'
                    });
                    break;
                case "del":
                    if (statusCode == 205) {
                        me.pacientes.splice(this.editedPaciente, 1);
                        Toast.fire({
                            icon: 'success',
                            'title': 'paciente eliminado con exito...!'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            text: 'No puede eliminar, ya existen autos registrados con esta paciente!'
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
        this.fetchpaciente();
        console.log(this.user);
        console.log(this.obtenerFechas);
    }
}
</script>