<template>
    <div class="container-fluid p-3">
        <div class="col-md-12 float-right pb-3">
            <div class="">
                <button class="float-right btn btn-success" @click="showDiv = !showDiv">Ver trabajos</button>
            </div>
        </div>

        <div id="show">
            <div v-show="showDiv">
                <hr class="m-5" style="border: 1px solid #000 ;">
                <div class="row">
                    <div class="col">
                        <label for="">Cliente: </label>&nbsp;{{ user.name }}
                    </div>
                    <div class="col">
                        <label for="">Fecha: </label> &nbsp;
                    </div>
                </div>
                <br>
                <h3>Detalles</h3>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Dia</th>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Precio</th>
                            <th>Tratamiento</th>
                            <th>Trabajo</th>
                            <th>Costo</th>
                            <th>Saldo Pendiente</th>
                            <th>Abono</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in reservaForm.historialTrabajos" key="index">
                            <td>{{ item.cita.dia }}</td>
                            <td>{{ item.cita.hora }}</td>
                            <td>{{ item.cita.paciente.nombreCom }}</td>
                            <td>{{ item.cita.precio }}</td>
                            <td>{{ item.cita.tratamiento.nombre }}</td>
                            <td>{{ this.reservaForm.nombre }}</td>
                            <td>{{ this.reservaForm.costo }}</td>
                            <td>{{ this.saldo=(this.reservaForm.costo - this.reservaForm.abono) }}</td>
                            <td>{{ this.reservaForm.abono }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" @click="removeItem(index)"><i
                                        class="fas fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-center">
                                <button type="button" class="btn btn-primary" @click="saveReserva()"
                                    :disabled="reservaForm.historialTrabajos.length < 1">Confirmar Reserva</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <form class="row g-3 border border-dark rounded p-3 mt-4">
            <div class="col-md-8">
                <label for="inputEmail4" class="form-label">Nombre del trabajo realizado</label>
                <input type="text" v-model="reservaForm.nombre" class="form-control" id="toad">
            </div>
            <div class="col-md-4">
                <label for="descripcion">Estado del trabajo</label>
                <select v-model="reservaForm.estado" class="form-control" aria-label="select">
                    <option v-for="mark in estados" :value="mark.id">
                        {{ mark.text }}
                    </option>
                </select>
            </div>
            <div class="col-4">
                <label for="inputAddress" class="form-label">Fecha de realizacion</label>
                <input type="date" v-model="reservaForm.fecha" class="form-control" id="fecha">
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label">Costo restante</label>
                <input type="text" v-model="reservaForm.costo" class="form-control" id="losj">
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label">Pago actual del paciente</label>
                <input type="text" v-model="reservaForm.abono" class="form-control" id="losj">
            </div>
            <div class="col-md-4">
                <label for="descripcion">Doctor que realizo el trabajo</label>
                <select v-model="reservaForm.doctor_id" class="form-control" aria-label="select">
                    <option v-for="mark in doctores" :value="mark.id">
                        {{ mark.nombre }}
                    </option>
                </select>
            </div>
            <!--  <div class="col-md-4">
                <label for="descripcion">Doctores</label>
                <select v-model="reservaForm.cita_id" class="form-control" aria-label="select">
                    <option v-for="mark in citas" :value="mark.id">
                        {{ mark.paciente.correlativo   }}&nbsp;{{ mark.paciente.nombreCom }}&nbsp;{{ mark.tratamiento.nombre }}
                    </option>
                </select>
            </div> -->
            <div class="col-12 form-group pt-3">
                <label for="inputAddress2" class="form-label">Observaciones</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"  v-model="reservaForm.observacion"></textarea>
            </div>
        </form>
    </div>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="row hidden-md-up">
                    <div class="col-md-4" v-for="(item, index) in citas" key="index">
                        <div class="card" style="width: 18rem; margin: 10px 0px 10px 0px;">
                            <div class="card-body">
                                <div class="card-block">
                                    <h4 class="card-title">{{ item.paciente.correlativo }}&nbsp;{{ item.paciente.nombreCom
                                    }}&nbsp;<br>{{ item.dia }}&nbsp;{{ item.hora }}</h4>
                                    <p class="card-text">: <b class="text-warning">${{ item.tratamiento.nombre }}</b></p>
                                    <a href="#" class="btn btn-primary" @click="addToReserva(item)">Guardar trabajo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" v-modal="trabajosModal" id="trabajoModal" tabindex="-1" aria-labelledby="trabajoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="trabajoModalLabel">Detalle de trabajo</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Definiendo el cuerpo del formulario modal -->


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

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
            reservaForm: {
                id: null,
                nombre: "",
                estado: "",
                fecha: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
                observacion: "",
                costo: 0,
                saldo: 0,
                abono: 0,
                doctor: null,
                doctor_id: null,
                historialTrabajos: []
            },
            estados: [
                { text: 'activo', value: 'activo' },
                { text: 'cancelado', value: 'cancelado' },
                { text: 'Proceso', value: 'Proceso' }
            ],
            diasAlquiler: 0,
            search: '',
            doctores: [],
            indexcita: -1,
            disableButton: false,
            showDiv: false
        }
    },
    computed: {
        total() {
            var total = 0;
            this.reservaForm.forEach(element => {
                total = (element.costo - element.abono)
            })
            this.reservaForm.saldo = total;
            return total;
        },
        btnReservTitle() {
            this.showDiv == flase ? "ver reserva" : "ocultar reserva";
        }/* ,
        calcKm(){
            this.citas.tipo == s ? this.km_salida = 30 : "ocultar reserva";
        }, */
    },
    methods: {
        async fetchcitas() {
            let me = this;
            await this.axios.get('/citas-vista')
                .then(response => {
                    me.citas = response.data;
                })
        },
        async fetchdoctores() {
            let me = this;
            await this.axios.get('/doctores')
                .then(response => {
                    me.doctores = response.data;
                })
        },

        calcDias() {
            const fecha1 = new Date(this.reservaForm.observacion);
            const fecha2 = new Date(this.reservaForm.costo);
            const diferenciaEnTiempo = fecha2.getTime() - fecha1.getTime();
            const diasDiferencia = diferenciaEnTiempo / (1000 * 60 * 60 * 24);
            this.diasAlquiler = Math.round(diasDiferencia + 1);
        },
        removeItem(i) {
            this.reservaForm.historialTrabajos.splice(i, 1);
        },
        removeItemd(item, index) {
            div = document.getElementById('desc');
            div.style.display = 'none';
        },
        addToReserva(item, index) {
            let me = this;

            me.reservaForm.historialTrabajos.push({
                id: null,
                cita: item,
                diasAlquiler: me.diasAlquiler
            });
        },
        async saveReserva() {
            let me = this;
            if (me.reservaForm.observacion.length > 0 && me.reservaForm.historialTrabajos.length > 0 ) {
                var f = new Date();
                me.reservaForm.estado = "activo";
                await this.axios.post(`/trabajos`, me.reservaForm)
                    .then(response => {
                        if (response.status == 201) {
                            this.$swal.fire("succes", "Su reserva se ha reistrado con exito, pronto nos comunicaremos");
                            me.reservaForm.historialTrabajos = [];
                            me.showDiv = false;
                        }
                    })
            } else {
                this.$swal.fire("warning", " Coomplete los datos de la reserva")
            }
        }
    },



    mounted() {
        // this.$swal('Welcome to RentasCars!!!');
        this.fetchcitas();
        //this.fetchcitas();
        this.fetchdoctores();
        console.log(this.user);
    }
}
</script>
