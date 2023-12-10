<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#antecendentesModal">
                                <i class="bi bi-file-earmark-plus-fill"></i> &nbsp; Agregar
                            </button>
                        </div>
                        <div class="input-group col-md-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            </div>
                            <input type="search" v-model="search" @input="filterData(search)" class="form-control"
                                placeholder="Buscar" aria-label="Buscar" aria-describedby="search-addon">
                        </div>
                        <!-- <div class="input-group flex-nowrap col-5">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="search" v-model="searchNombre" class="form-control"
                                placeholder="Buscar" aria-label="search" aria-describedby="search-addon">
                        </div> -->
                    </div>
                </div>

                <div class="container shadow mt-5 p-3">
                    <div class="row">
                        <!-- desde aqui repetir -->
                        <div class="col-sm-6 mb-3 mb-sm-0" v-for="antecedente in filteredAntecedentes">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" fill="currentColor"
                                            class="bi bi-card-list col-2" viewBox="0 0 16 16">
                                            <path
                                                d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                            <path
                                                d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                                        </svg>
                                        <p class="col pt-3">
                                            <b>Paciente:</b> {{ antecedente.paciente.nombreCom }} <br>
                                        </p>
                                        <div class="col pt-3">
                                            <button type="button" class="btn btn-info rounded-pill"
                                                @click="eliminar(antecedente)">
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- aqui -->
                    </div>
                </div>
            </div>
            <div class="card-footer text-body-secondary">
                Antecedentes
            </div>
        </div>

    </div>
    <div class="modal fade" id="antecendentesModal" tabindex="-1" aria-labelledby="antecendentesModal" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="antecendentesModalLabel">Antecedentes Médicos</h1>
                    <!-- <h1 class="modal-title fs-5" id="antecendentesModalLabel">{{ antecedentes.paciente_id }}</h1> -->
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form role="form" method="post" class="shadow p-3 w-100 mx-auto rounded justify-content-center">
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="hipertension" class="">Hipertensión Arterial</label>
                                    <select class="form-control w-50" v-model="antecedentes.paciente_id" aria-label="">
                                        <option id="pacientenull" value="null" selected disabled>Escoger Paciente</option>
                                        <option v-for="paciente in pacientes" :value="paciente.id">
                                            {{ paciente.nombreCom }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <label for="hipertension" class="">Hipertensión Arterial</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="hipertension" value="si"
                                                v-model="antecedentes.hipertencionArterial"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="hipertension" value="no"
                                                v-model="antecedentes.hipertencionArterial" checked>
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="cardiopatia" class="">Cardiopatía</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="cardiopatia" value="si"
                                                v-model="antecedentes.cardiopatia"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="cardiopatia" value="no"
                                                v-model="antecedentes.cardiopatia" checked> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="diabetesMellitu" class="">Diabetes Mellitus</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="diabetesMellitu" value="si"
                                                v-model="antecedentes.diabetesMellitu">
                                            Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="diabetesMellitu" value="no"
                                                v-model="antecedentes.diabetesMellitu" checked> No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="renal" class="">Problema Renal</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="renal" value="si" v-model="antecedentes.renal"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="renal" value="no" v-model="antecedentes.renal"
                                                checked> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="problemaRespiratorio" class="">Problema Respiratorio</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="problemaRespiratorio" value="si"
                                                v-model="antecedentes.problemaRespiratorio"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="problemaRespiratorio" value="no"
                                                v-model="antecedentes.problemaRespiratorio" checked>
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="hepatico" class="">Problema Hepático</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="hepatico" value="si" v-model="antecedentes.hepatico">
                                            Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="hepatico" value="no" v-model="antecedentes.hepatico"
                                                checked> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="problemaEndocronico" class="">Problema Endocrónico</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="problemaEndocronico" value="si"
                                                v-model="antecedentes.problemaEndocronico"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="problemaEndocronico" value="no"
                                                v-model="antecedentes.problemaEndocronico" checked>
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="problemaHemorragico" class="">Problema Hemorragico</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="problemaHemorragico" value="si"
                                                v-model="antecedentes.problemaHemorragico"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="problemaHemorragico" value="no"
                                                v-model="antecedentes.problemaHemorragico" checked> No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label for="embarazo" class="">Embarazo</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="embarazo" value="si" v-model="antecedentes.embarazo">
                                            Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="embarazo" value="no" v-model="antecedentes.embarazo"
                                                checked> No
                                        </label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="alergiaMedicamentos" class="">Alergia a Medicamentos</label>
                                    <textarea type="text" class="form-control" id="alergia" name="alergia"
                                        placeholder="Escriba aquí" rows="3" maxlength="45"
                                        v-model="antecedentes.alergiaMedicamentos" />
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label for="otrosMedicamentosQueToma" class="">Otros medicamentos</label>
                                    <textarea type="text" class="form-control" id="otrosMedicamentosQueToma"
                                        name="otrosMedicamentosQueToma" placeholder="Escriba aquí" rows="3" maxlength="45"
                                        v-model="antecedentes.otrosMedicamentosQueToma" />
                                </div>
                                <div class="col-md-6">
                                    <label for="otrosDatos">Otros Datos</label>
                                    <textarea type="text" class="form-control" id="otrosDatos" name="otrosDatos"
                                        placeholder="Escriba aquí" rows="3" maxlength="255"
                                        v-model="antecedentes.otrosDatos" />
                                </div>
                            </div>

                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-primary col-md-6" @click="saveOrUpdate">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
            filteredAntecedentes: [], // Cambia de propiedad computada a propiedad regular
            listAntecedentes: [],
            antecedentes: {
                id: null,
                hipertencionArterial: "no",
                cardiopatia: "no",
                diabetesMellitu: "no",
                problemaRenal: "no",
                problemaRespiratorio: "no",
                problemaHepatico: "no",
                problemaEndocronico: "no",
                problemaHemorragico: "no",
                alergiaMedicamentos: "",
                embarazo: "no",
                otrosMedicamentosQueToma: "",
                otrosDatos: "",
                paciente_id: null,
            },
            pacientes: [],
            editedAntecendentes: -1,
            antecedentesErrors: {
                hipertencion: false,
                cardiopatia: false,
                mellitus: false,
                renal: false,
                hepatico: false,
                respiratorio: false,
                endocrinico: false,
                hemorragico: false,
                embarazo: false,
                alergia: false,
                otrosMedicamentos: false,
                otrosDatos: false,
                pacienteId: null,
            },
            searchNombre: '',
        }
    },
    computed: {

        filteredAntecedentes() {
            // Filtrar los antecedentes basados en el nombre del paciente
            return this.listAntecedentes.filter(antecedente =>
                antecedente.paciente.nombreCom.toLowerCase().includes(this.searchNombre.toLowerCase())
            );
        },

    },
    methods: {
        async fetchpaciente() {
            let me = this;
            await this.axios.get('/pacientes')
                .then(response => {
                    me.pacientes = response.data;
                })
        },
        async fetchAntecedentes() {
            let me = this;
            await this.axios.get('/antece')
                .then(response => {
                    me.listAntecedentes = response.data;
                })
        },
        async saveOrUpdate() {
            let me = this;
            // me.doctor.user = this.user;
            me.antecedentes.hipertencionArterial == '' ? me.antecedentesErrors.hipertencion == true : me.antecedentesErrors.hipertencion = false;
            me.antecedentes.alergia == '' ? me.antecedentesErrors.alergia == true : me.antecedentesErrors.alergia = false;
            if (me.antecedentes.hipertencionArterial) {
                let accion = me.antecedentes.id == null ? "add" : "upd";
                if (accion == "add") {
                    await this.axios.post('/antece', me.antecedentes)
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
                    await this.axios.put(`/doctores/${me.doctor.id}`, me.doctor)
                        .then(response => {
                            console.log(response.data);
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
        async eliminar(antecedenteDelete) {
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
                    me.editedAntecendentes = me.listAntecedentes.indexOf(antecedenteDelete);
                    this.axios.delete(`/antece/${antecedenteDelete.id}`)
                        .then(response => {
                            me.verificarAccion(null, response.status, "del");
                            // console.log(response);
                        }).catch(errors => {
                            console.log(errors);
                        })
                }
            })
        },
        verificarAccion(antecedente, statusCode, accion) {
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
                    me.listAntecedentes.unshift(antecedente);
                    Toast.fire({
                        icon: 'success',
                        title: 'Se ha guardado con éxito'
                    });
                    break;
                case "upd":
                    Object.assign(me.antecedentes[me.editedAntecendentes], antecedente);
                    Toast.fire({
                        'icon': 'success',
                        'title': 'Se ha actualizado con éxito'
                    });
                    break;
                case "del":
                    if (statusCode == 205) {

                        me.listAntecedentes.splice(this.editedAntecendentes, 1);
                        Toast.fire({
                            'icon': 'success',
                            'title': 'Se ha eliminado con éxito!'
                        });
                    } else {
                        Toast.fire({
                            'icon': 'error',
                            'text': '!Error al eliminar!'
                        });
                    }
                    break;
                default:
                    break;
            }
        },
        hideDialog() {
            let me = this;
            setTimeout(() => {
                me.antecedentes = {
                    hipertencionArterial: null,
                    cardiopatia: null,
                    diabetesMellitu: null,
                    problemaRenal: null,
                    problemaRespiratorio: null,
                    problemaHepatico: null,
                    problemaEndocronico: null,
                    problemaHemorragico: null,
                    alergiaMedicamentos: null,
                    embarazo: null,
                    otrosMedicamentosQueToma: null,
                    otrosDatos: null,
                    paciente_id: null,
                }
            }, 300);
            $('#antecendentesModal').modal('hide');
        },
    },
    async mounted() {
        await this.fetchpaciente();
        await this.fetchAntecedentes();
        this.filteredAntecedentes = this.listAntecedentes; // Muestra todos los antecedentes al inicio
    }

}
</script>