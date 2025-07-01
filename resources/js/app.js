import { createApp } from 'vue'
import App from './Componentes/App.vue'
import axios from 'axios'

window.axios = axios;

createApp(App).mount('#app')
