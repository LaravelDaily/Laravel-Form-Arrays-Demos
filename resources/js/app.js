import './bootstrap';

import Alpine from 'alpinejs';
import {createApp} from 'vue';
import TeamPlayerSelection from '../vue/TeamPlayerSelection.vue';

window.Alpine = Alpine;

Alpine.start();
//
// createApp({})
//     .component('TeamPlayerSelection', TeamPlayerSelection)
//     .mount('#app');