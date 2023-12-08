<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ listTitle }}</h3>
                        <div class="form-check form-check-inline">
                            <input class="form-check-label" type="radio" name="tipo" v-model="mostrarTrabajos">
                            <label class="form-check-label" for="inlineRadio1">Trabajos</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" v-model="mostrarAlquileres">
                            <label class="form-check-label" for="inlineRadio2">Alquiler</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo" v-model="mostrarDevoluciones">
                            <label class="form-check-label" for="inlineRadio3">Devoluciones</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>Correlativo</th>
                                <th>Fecha Reserva</th>
                                <th>Fecha Alquiler</th>
                                <th>Total</th>
                                <th>Cliente</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <tr v-for="item in alquileres" :key="item.id">
                                    <td>{{ item.correlativo }}</td>
                                    <td>{{ item.fecha_reserva }}</td>
                                    <td>{{ item.fecha_alquiler }}</td>
                                    <td>{{ item.total }}</td>
                                    <td>{{ item.user.name }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" @click="showDialog(item)">Ver detalle</button>
                                        &nbsp;
                                        <button class="btn btn-success btn-sm">Alquiler</button>
                                        &nbsp;
                                        <button class="btn btn-info btn-sm" v-if="mostrarAlquileres">Devolver Alquiler</button>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm">Anular Reserva</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="detalleModalLabel">Detalle de la reserva</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Definiendo el cuerpo del modal-->
            <div class="row">
                <div class="form-group col-12">
                    <div class="col-6">
                        <label for="" v-if="alquiler !=null">No Reserva:&nbsp;{{ alquiler.correlativo }}</label>
                    </div>
                    <div>
                        <div class="col-6">
                            <label for="" v-if="alquiler !=null">Cliente:&nbsp;{{  }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="" v-if="alquiler !=null">Fecha Reserva:&nbsp;{{ alquiler.fecha_reserva }}</label>
                        </div>
                        <div class="col-6">
                            <label for="" v-if="alquiler !=null">Fecha Alquiler:&nbsp;{{ alquiler.fecha_alquiler }}</label>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Anio</th>
                        <th>Precio Diario</th>
                        <th>Dias Alquiler</th>
                        <th>Sub Total</th>
                    </thead>
                    <tbody>
                        <tr v-if="alquiler != null" v-for="item in alquiler.detalleAlquiler" :key="item.id">
                            <td>{{ item.auto.placa }}</td>
                            <td>{{ item.auto.marca.nombre }}</td>
                            <td>{{ item.auto.marca.nombre }}</td>
                            <td class="text-center">{{ item.auto.anio  }}</td>
                            <td class="text-center">{{ item.auto.precio_alquiler}}</td>
                            <td class="text-center">{{ item.dias_alquiler}}</td>
                            <td class="text-center">{{ item.auto.precio_alquiler * item.dias_alquiler }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">Total a Cancelar</td>
                            <td class="text-center" v-if="alquiler != null">{{ alquiler.total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
        data(){
            return{
                estado:"R",
                mostrarReservas:false,
                mostrarAlquileres:false,
                mostrarDevoluciones:false,
                listTitle: "Gestion de Reservas de Autos",
                alquileres:[],
                alquiler: null,
            }
        },
        watch:{
            mostrarReservas(){
                let me = this;
                if(me.mostrarReservas){
                    me.estado = 'R';
                    me.listTitle = "Gestion de Reservas de Autos";
                }
                me.fetchAlquileres();
            },
            mostrarAlquileres(){
                let me = this;
                if(me.mostrarAlquileres){
                    me.estado = 'A';
                    me.listTitle = "Gestion de Alquileres de Autos";
                }
                me.fetchAlquileres();
            },

            mostrarDevoluciones(){
                let me = this;
                if(me.mostrarDevoluciones){
                    me.estado = 'D';
                    me.listTitle = "Listado de Devoluciones de Autos";
                }
                me.fetchAlquileres();
            }
        },


        methods:{
            async fetchAlquileres(){
                let me = this;
                await this.axios.get(`/alquileres/${me.estado}`)
                .then(response =>{
                    console.log(response.data);
                    if(Object.keys(response.data).length==0){
                        me.alquileres = [];
                    }else{
                        me.alquileres = response.data;
                    }
                }).catch(errors=>{
                    console.log(errors);
                });
            },

            showDialog(item){
                console.log(item);

                $('#detalleModal').modal('show');
                //me.editedAlquiler = me.alquileres.indexOf(alquiler);
                this.alquiler = item;
            }
        },
        mounted() {
            let me = this;
            me.fetchAlquileres();
        }
    }
</script>
