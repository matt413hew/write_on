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
import updatearticle from './components/Article/EditArticle.vue'
import editarticle from './components/Article/Editor.vue'
import { Icon } from '@iconify/vue';
import 'floating-vue/dist/style.css'
import FloatingVue from 'floating-vue'
import dayjs from 'dayjs'
import { axios,api } from "./axios.js";
import { useMainStore } from './stores'
import notify from './scripts/notify'
import { pinia } from './stores'
import Router from './router'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import useZoro from './composables/useZoro'
import { TailwindPagination } from 'laravel-vue-pagination';



const app = createApp(App)

app.use(pinia)
app.use(router)
app.use(FloatingVue)
app.provide('dayjs', dayjs);
app.component('VueDatePicker', VueDatePicker);
app.component('Paginate', TailwindPagination);
app.component('Tbtn',button)
app.component('NavItem',navitem)
app.component('PageBody',body)
app.component('PageHead',head)
app.component('Page',page)
app.component('Icon',Icon)
app.component('AddArticle',addarticle)
app.component('EditArticle',editarticle)
app.component('UpdateArticle',updatearticle)
app.config.globalProperties.$dayjs = dayjs;
app.config.globalProperties.$main = useMainStore();
app.config.globalProperties.$notify = notify;
app.config.globalProperties.$api = api;
app.config.globalProperties.$router = Router;
app.config.globalProperties.$zoro = useZoro();
app.mount('#app')
