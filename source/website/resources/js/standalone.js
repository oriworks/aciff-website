import { createApp } from 'vue';
import ComponentA from './components/ComponentA.vue'
import Portal from './components/Portal.vue'
import RequestForm from './components/RequestForm.vue'
import Modal from './components/Modal.vue'

createApp({})
    .component('ComponentA', ComponentA)
    .component('Portal', Portal)
    .component('RequestForm', RequestForm)
    .component('Modal', Modal)
    .mount("#app");

