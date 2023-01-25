import './bootstrap';

import Alpine from 'alpinejs';
import {v4 as uuidv4} from 'uuid';
// import Quill from 'quill'

import { createApp } from 'vue';
import ChartBar from './applications/ChartBar.vue';

window.Alpine = Alpine;
window.uuidv4 = uuidv4;
// window.Quill = Quill;
Alpine.start();

const ChartApp = createApp(ChartBar);
ChartApp.mount('#projectChartBlade');