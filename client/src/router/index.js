import { createRouter, createWebHistory } from 'vue-router'

import Home from "../views/home.vue";
import All from "../views/allMedia.vue";
import Nav from "../components/Nav/navbar.vue";
import Login from "../views/login.vue";
import notFound from "../views/notFound.vue";
import companies from "../views/companies.vue";
import user from "../views/user.vue";
import { useMainStore } from '@/stores';

const Router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/home',
      meta:{
        requiresAuth: true,
      },
      name: 'Default layout',
      component: Nav,
       children: [
            { path: "/home", name: "Home", component: Home },
            { path: "/all", name: "All", component: All },
            { path: "/companies",
                meta:{
                requiresEditor: true,
                }, 
              name: "Companies", component: companies 
            },
            { path: "/users",
                meta:{
                requiresEditor: true,
                }, 
              name: "Users", component: user 
            },
       ]
    },
    {
      path: '/login',
      meta:{
        guest: true,
      },
      name: 'Login',
      component: Login,
    },
    {
      path: '/404',
      meta:{
         requiresAuth: true,
      },
      name: 'NotFound',
      component: notFound,
    },
  ]
});

Router.beforeEach((to, from, next) => {
  const auth = useMainStore();

    if (to.matched.some((record) => record.meta.requiresAuth)) {
      if (!auth.isLoggedin) {
         next({
        path: "/login",
        });
      }
    }

    if (to.matched.some((record) => record.meta.requiresEditor)) {
      if (!auth.isEditor) {
         next({
        path: "/home",
        });
      }
    }

    if(to.matched.some((record) => record.meta.guest)){
    if (auth.isLoggedin) {
         next({
        path: "/",
        });
      }
    }

    next()
});



export default Router
