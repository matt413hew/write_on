import { createRouter, createWebHistory } from 'vue-router'

import Home from "../views/home.vue";
import All from "../views/allMedia.vue";
import Nav from "../components/Nav/navbar.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/home',
      name: 'Default layout',
      component: Nav,
       children: [
            { path: "/home", name: "Home", component: Home },
            { path: "/all", name: "All", component: All },
       ]
    }
  ]
})

export default router
