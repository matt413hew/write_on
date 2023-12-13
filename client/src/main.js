import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import './index.css'
import router from './router'
import body from './components/Page/body.vue'
import head from './components/Page/head.vue'
import page from './components/Page/page.vue'
import navitem from './components/Nav/navItem.vue'
import button from './components/Button/Button.vue'
import addarticle from './components/Article/AddArticle.vue'
import editarticle from './components/Article/Editor.vue'
import { Icon } from '@iconify/vue';
import 'floating-vue/dist/style.css'
import FloatingVue from 'floating-vue'
import dayjs from 'dayjs'
import { axios } from "./axios.js";
import { useMainStore } from './stores/mainStore'
import notify from './scripts/notify'


const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(FloatingVue)
app.provide('dayjs', dayjs);
app.component('Tbtn',button)
app.component('NavItem',navitem)
app.component('PageBody',body)
app.component('PageHead',head)
app.component('Page',page)
app.component('Icon',Icon)
app.component('AddArticle',addarticle)
app.component('EditArticle',editarticle)
app.config.globalProperties.$dayjs = dayjs;
app.config.globalProperties.$api = axios;
app.config.globalProperties.$main = useMainStore();
app.config.globalProperties.$notify = notify;
app.mount('#app')
