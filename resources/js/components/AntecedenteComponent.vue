<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-primary col-md-6" data-bs-toggle="modal"
                                data-bs-target="#antecendentesModal">
                                Agregar Antecedentes
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-primary col-md-6" data-bs-toggle="modal"
                                data-bs-target="#antecendentesModal">
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="container shadow mt-5 p-3">
                    <div class="row">
                        <!-- desde aqui para repetir -->
                        <div class="col-sm-6 mb-3 mb-sm-0">
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
                                        <p class="col">
                                            Antecendentes Médicos de {{ antecedentes.pacienteId }}
                                        </p>
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
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form role="form" method="post" class="shadow p-3 w-100 mx-auto rounded justify-content-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="hipertension" class="">Hipertensión Arterial</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="hipertension" value="si"
                                                v-model="antecedentes.hipertencion"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="hipertension" value="no"
                                                v-model="antecedentes.hipertencion" checked>
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
                                    <label for="hipertension" class="">Diabetes Mellitus</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="mellitus" value="si" v-model="antecedentes.mellitus">
                                            Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="mellitus" value="no" v-model="antecedentes.mellitus"
                                                checked> No
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
                                    <label for="respiratorio" class="">Problema Respiratorio</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="respiratorio" value="si"
                                                v-model="antecedentes.respiratorio"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="respiratorio" value="no"
                                                v-model="antecedentes.respiratorio" checked>
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
                                    <label for="endocronico" class="">Problema Endocrónico</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="endocronico" value="si"
                                                v-model="antecedentes.endocrinico"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="endocronico" value="no"
                                                v-model="antecedentes.endocrinico" checked>
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="hemorragico" class="">Problema Hemorragico</label>
                                    <div class="form-check">
                                        <label class="">
                                            <input type="radio" name="hemorragico" value="si"
                                                v-model="antecedentes.hemorragico"> Si
                                        </label>
                                        <label class="mx-4">
                                            <input type="radio" name="hemorragico" value="no"
                                                v-model="antecedentes.hemorragico" checked> No
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
                                    <label for="alergia" class="">Alergia a Medicamentos</label>
                                    <textarea type="text" class="form-control" id="alergia" name="alergia"
                                        placeholder="Escriba aquí" rows="3" maxlength="45" v-model="antecedentes.alergia" />
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-md-6">
                                    <label for="otrosMedicamentos" class="">Otros medicamentos</label>
                                    <textarea type="text" class="form-control" id="otrosMedicamentos"
                                        name="otrosMedicamentos" placeholder="Escriba aquí" rows="3" maxlength="45"
                                        v-model="antecedentes.otrosMedicamentos" />
                                </div>
                                <div class="col-md-6">
                                    <label for="otrosDatos">Otros Datos</label>
                                    <textarea type="text" class="form-control" id="otrosDatos" name="otrosDatos"
                                        placeholder="Escriba aquí" rows="3" maxlength="255"
                                        v-model="antecedentes.otrosDatos" />
                                </div>
                            </div>

                            <div class="col-6 text-end">
                                <button type="submit" class="btn btn-primary col-md-6">Enviar</button>
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
            listAntecedentes: [],
            antecedentes: {
                id: null,
                hipertencion: "no",
                cardiopatia: "no",
                mellitus: "no",
                renal: "no",
                hepatico: "no",
                respiratorio: "no",
                endocrinico: "no",
                hemorragico: "no",
                embarazo: "no",
                alergia: "",
                otrosMedicamentos: "",
                otrosDatos: "",
                pacienteId: "David Elas",
            },
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
            }
        }
    },
    computed: {

    },
    methods: {
        async saveOrUpdate() {
            let me = this;
            // me.doctor.user = this.user;
            me.antecedentes.hipertencion == '' ? me.antecedentesErrors.hipertencion == true : me.antecedentesErrors.hipertencion = false;
            me.antecedentes.alergia == '' ? me.antecedentesErrors.alergia == true : me.antecedentesErrors.alergia = false;
            if (me.antecedentes.hipertencion) {
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
                    me.antecedentes.unshift(antecedente);
                    Toast.fire({
                        'icon': 'success',
                        'title': 'Se ha guardado con éxito'
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
                        me.antecedentes.splice(this.editedAntecendentes, 1);
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
        }
    },
    mounted() {

    }
}
</script>