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
import { Icon } from '@iconify/vue';
import 'floating-vue/dist/style.css'
import FloatingVue from 'floating-vue'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(FloatingVue)
app.component('NavItem',navitem)
app.component('PageBody',body)
app.component('PageHead',head)
app.component('Page',page)
app.component('Icon',Icon)
app.mount('#app')
