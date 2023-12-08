/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'

import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'


import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import PacienteComponent from './components/PacienteComponent.vue';
import DoctorComponent from './components/DoctorComponent.vue';
import CitaComponent from './components/CitaComponent.vue';
import TratamientoComponent from './components/TratamientoComponent.vue';
import TrabajoComponent from './components/TrabajoComponent.vue';
import AntecedenteComponent from './components/AntecedenteComponent.vue';
import RadiografiaComponent from './components/RadiografiaComponent.vue';
import EspecialidadComponent from './components/EspecialidadComponent.vue'


app.component('espec-component', EspecialidadComponent);
app.component('radio-component', RadiografiaComponent);
app.component('antecedente-component', AntecedenteComponent);
app.component('trabajos-component', TrabajoComponent);
app.component('tratamiento-component', TratamientoComponent);
app.component('example-component', ExampleComponent);
app.component('paciente-component', PacienteComponent);
app.component('doctor-component', DoctorComponent);
app.component('cita-component', CitaComponent);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */



app.config.globalProperties.axios = axios;
app.config.globalProperties.msj = 'hola';



app.use(VueSweetalert2);
app.use(VueAxios, axios)
.component('font-awesome-icon', FontAwesomeIcon)
app.mount('#app');



function forter() {
    $('#toad').on('input', function () {
        this.value = this.value.replace(/[^a-zA-ZñÑ\s\ó]+/g, '');
    });
}
forter();
cien();


function cien() {
    const input = document.getElementById('toad');
    input.addEventListener('input', e => {
        const value = parseInt(e.currentTarget.value);
        if (value > 100) {
            input.value = 0;
            alert('Por favor ingresa un número menor a 100');
        }
    });
}

function funct() {
    $('#losj').on('input', function () {
        this.value = this.value.replace(/\D+/g, '').replace(/(\d{4})(\d{4})/, '$1-$2');
    });
// Cuenta la cantidad de caracteres
// Muestra la cantidad de caracteres en algún lugar, como la consola
}
funct();


// function dias() {
//     let me = this;
//     const toast = this.$swal.mixin({
//         title: 'No puedes seleccionar fin de semana',
//         text: 'Por favor seleccione un día laboral',
//         icon: 'warning',
//         confirmButtonColor: '#3085d6',
//         confirmButtonText: 'Entendido',
//     });

//     $('#lunes').on('change', function () {
//         if ($(this).prop('checked')) {
//             toast.fire();
//             me.dia.lunes = 1;
//             console.log('Cantidad de caracteres: ' + me.dia.lunes);
//         } else {
//             me.dia.lunes = 0;
//             console.log('Cantidad de caracteres: ' + me.dia.lunes);
//         }
//     });

//     return me.dia;
// }
// dias();