import './bootstrap';

import Alpine from 'alpinejs';
import {v4 as uuidv4} from 'uuid';
// import Quill from 'quill'
// import { createApp } from 'vue';
// import clrApp from './applications/clrApp.vue';

window.Alpine = Alpine;
window.uuidv4 = uuidv4;
// window.Quill = Quill;
Alpine.start();

// const myapp = createApp(clrApp);
// myapp.mount('.clrApp');