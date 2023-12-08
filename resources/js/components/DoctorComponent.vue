<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <button @click="showDialog" class="btn btn-success">Agregar Doctor</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Doctor</th>
                                    <th scope="col">Número de teléfono</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in doctores" :key="item">
                                    <td>{{ item.nombre }}</td>
                                    <td>{{ item.numeroTel }}</td>
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
    <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="doctorModalLabel">{{ formTitle }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->
                    <div class="row">
                        <div class="form-group col-5">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="toad" class="form-control" minlength="4" maxlength="50" size="13"
                                v-model="doctor.nombre">
                            <span class="text-danger" v-show="doctorErrors.nombre">Nombre es requerido</span>
                        </div>
                        <div class="form-group col-5">
                            <label for="nombre">Teléfono</label>
                            <input type="text" id="losj" class="form-control" maxlength="8" size="13"
                                v-model="doctor.numeroTel">
                            <span class="text-danger" v-show="doctorErrors.numeroTel">numero es requerido</span>
                        </div>
                    </div>
                    <div class="form-group col-10">

                        <div class="row">
                            <div class="col">
                                <label for="lunes:1">Lunes</label>
                                <input type="radio" id="lunes" name="lunes" :value="1" v-model="dia.lunes">
                            </div>
                            <div class="col">
                                <label for="martes:2">Martes</label>
                                <input type="radio" id="martes" name="martes" :value="2" v-model="dia.martes">
                            </div>
                            <div class="col">
                                <label for="miercoles:3">Miercoles</label>
                                <input type="radio" id="miercoles" name="miercoles" :value="3" v-model="dia.miercoles">
                            </div>

                            <div class="col">
                                <label for="jueves:4">Jueves</label>
                                <input type="radio" id="jueves" name="jueves" :value="4" v-model="dia.jueves">
                            </div>
                            <div class="col">
                                <label for="viernes:5">Viernes</label>
                                <input type="radio" id="viernes" name="viernes" :value="5" v-model="dia.viernes">
                            </div>
                            <span class="text-danger" v-show="doctorErrors.dia">Dias se requiere </span>
                        </div>

                        <button type="button" class="btn btn-dark" @click="deseleccionar()">
                            Deseleccionar
                        </button>
                        <button type="button" class="btn btn-dark mx-5" @click="pushDoctor()">
                                Agregar
                            </button>
                        
                    </div>
                    <label id="firme" for="nombre"> doctor dias: {{ dia }}</label>

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
import { Alert } from 'bootstrap';
// import { TimeColsSlatsCoords } from '../../vendor/almasaeed2010/adminlte/plugins/fullcalendar/main';


export default {
    props: ['user'],
    data() {
        return {
            doctores: [],
            dia: {
                lunes: null,
                martes: null,
                miercoles: null,
                jueves: null,
                viernes: null
            },
            doctor: {
                id: null,
                nombre: "",
                numeroTel: "",
                dia: {},
                //DATOS NECESARIOS DE RECIBIRSI NO FUNCIONA CON NULL PROBAR CON 0 PERO SOLO EN HORAS
                horaAm: {
                    siete: null,
                    sieteM: null,
                    ocho: null,
                    ochoM: null,
                    nueve: null,
                    nueveM: null,
                    diez: null,
                    diezM: null,
                    once: null,
                    onceM: null,
                    doce: null,
                    doceM: null,
                },
                horaaPm: {
                    una: null,
                    unaM: null,
                    dos: null,
                    dosM: null,
                    tres: null,
                    tresM: null,
                    cuatro: null,
                    cuatroM: null,
                    cinco: null,
                    cincoM: null
                },
                fechaRegistro: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                user: null
            },
            editeddoctor: -1,
            doctorErrors: {
                nombre: false,
                numeroTel: false,
                fechaRegistro: false,
                user: null,
                dia: {
                lunes: null,
                martes: null,
                miercoles: null,
                jueves: null,
                viernes: null
            },
            },
            Dato: []
        }
    },
    computed: {
        formTitle() {
            return this.doctor.id == null ? "Agregar doctor" : "Actualizar doctor";
        },
        btnTitle() {
            return this.doctor.id == null ? "Guardar" : "Actualizar";
        },
        valid() {
            if (this.funct) {
                this.$swal.fire({
                    title: "Tu nombre",
                    input: "text",
                    showCancelButton: true,
                    confirmButtonText: "Guardar",
                    cancelButtonText: "Cancelar",
                })

            }
        },
    },
    methods: {
       
        deseleccionar() {
            // Obtenemos todos los radiobuttons del formulario
            const radiobuttons = document.querySelectorAll("input[type='radio']");

            this.dia.lunes = null;
            this.dia.martes = null;
            this.dia.miercoles = null;
            this.dia.jueves = null;
            this.dia.viernes = null;
            this.doctor.dia = null;

            // Desmarcamos todos los radiobuttons
            for (const radiobutton of radiobuttons) {
                radiobutton.checked = false;
            }
        },
        pushDoctor(){
            console.log(this.dia);
            this.doctor.dia = this.dia;
            console.log(this.doctor.dia);
        },
        // funct() {
        //     const Toast = this.$swal.mixin({
        //         toast: true,
        //         iconColor: 'white',
        //         showConfirmButton: true,
        //         timer: 2000
        //     });
        //     $('#losj').on('input', function () {
        //         const texto = this.value;
        //         this.value = this.value.replace(/\D+/g, '').replace(/(\d{4})(\d{4})/, '$1-$2');     //.replace(/^[09][0-9]{1,7}/g, '')//.replace(/\D/g, '').replace(/^(\d{3}-)(\d{4}-)(\d{4}-)$/);\            

        //         console.log("Cantidad de caracteres: " + texto.length);

        //         return texto.length;
        //     });
            // Cuenta la cantidad de caracteres


            // Muestra la cantidad de caracteres en algún lugar, como la consola

        //},
        async fetchdoctor() {
            let me = this;
            await this.axios.get('/doctores')
                .then(response => {
                    me.doctores = response.data;
                })
        },
        showDialog() {

            this.dia= {
                lunes: null,
                martes: null,
                miercoles: null,
                jueves: null,
                viernes: null
            },
            this.doctor = {
                id: null,
                nombre: "",
                numeroTel: "",
                fechaRegistro: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                user: null,
               
            };
            this.doctorErrors = {
                nombre: "",
                numeroTel: "",
                fechaRegistro: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                user: null,
                dia:null
            };
            $('#doctorModal').modal('show');
        },
        showDialogEditar(doctor) {
            let me = this;
            $('#doctorModal').modal('show');
            me.editeddoctor = me.doctores.indexOf(doctor);
            me.doctor = Object.assign({}, doctor);
            me.dia.lunes = doctor.dia.lunes;
            me.dia.martes = doctor.dia.martes;
            me.dia.miercoles = doctor.dia.miercoles;
            me.dia.jueves = doctor.dia.jueves;
            me.dia.viernes = doctor.dia.viernes;
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.dia= {
                lunes: null,
                martes: null,
                miercoles: null,
                jueves: null,
                viernes: null
            },
                me.doctor = {
                    id: null,
                    nombre: "",
                    numeroTel: 0,
                    dia: null,
                }
            }, 300);
            $('#doctorModal').modal('hide');
        },
        async saveOrUpdate() {
            let me = this;
            me.doctor.user = this.user;
            me.doctor.nombre == '' ? me.doctorErrors.nombre == true : me.doctorErrors.nombre = false;
            me.doctor.numeroTel == '' ? me.doctorErrors.numeroTel == true : me.doctorErrors.numeroTel = false;
            me.doctor.dia == {} ? me.doctorErrors.dia == false : me.doctorErrors.dia = true;
            if (me.doctor.nombre) {
                let accion = me.doctor.id == null ? "add" : "upd";
                if (accion == "add") {
                    //peticion para guardar una doctor
                    await this.axios.post('/doctores', me.doctor)
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
                    //peticion para actualizar una doctor
                    me.pushDoctor();
                    await this.axios.put(`/doctores/${me.doctor.id}`, me.doctor)
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
        async eliminar(doctor) {
            //alert(doctor.id);
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
                    me.editeddoctor = me.doctores.indexOf(doctor);
                    this.axios.delete(`/doctores/${doctor.id}`)
                        .then(response => {
                            me.verificarAccion(null, response.status, "del");
                        }).catch(errors => {
                            console.log(errors);
                        })
                }
            })
        },
        verificarAccion(doctor, statusCode, accion) {
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
                    //agregamos al principio del arreglo doctor, la nueva doctor
                    me.doctores.unshift(doctor);
                    Toast.fire({
                        icon: 'success',
                        'title': 'doctor registrado con exito...!'
                    });
                    break;
                case "upd":
                    Object.assign(me.doctores[me.editeddoctor], doctor);
                    Toast.fire({
                        icon: 'success',
                        'title': 'doctor actualizad0 con exito...!'
                    });
                    break;
                case "del":
                    if (statusCode == 205) {
                        me.doctores.splice(this.editeddoctor, 1);
                        Toast.fire({
                            icon: 'success',
                            'title': 'doctor eliminado con exito...!'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            text: 'No puede eliminar, ya existen autos registrados con esta doctor!'
                        });
                    }
                    break;
                default:
                    break;
            }
        }
    },
    mounted() {
        this.fetchdoctor();

        //this.fetchhola();
        //this.rist()
        //console.log(JSON.stringify(this.checkedNames));
        console.log(this.user);
        //this.dias();
    }
}
</script>