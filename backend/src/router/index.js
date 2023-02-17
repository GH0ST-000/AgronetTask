import {createRouter, createWebHistory} from "vue-router";
import AppLayout from '../components/AppLayout.vue'
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Companies from "../views/Companies/Companies.vue";
import NotFound from "../views/NotFound.vue";
import Employee from "../views/Employee/Employee.vue";
import store from "../store";

const routes = [
  {
    path: '/app',
    name: 'app',
    component: AppLayout,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: 'dashboard',
        name: 'app.dashboard',
        component: Dashboard
      },
      {
        path: 'companies',
        name: 'app.companies',
        component: Companies
      },
      {
        path: 'employee',
        name: 'app.employee',
        component: Employee
      }
    ]
  },
  {
    path: '/',
    name: 'login',
    component: Login,
    meta: {
      requiresGuest: true
    }
  },

  {
    path: '/:pathMatch(.*)',
    name: 'notfound',
    component: NotFound,
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({name: 'login'})
  } else if (to.meta.requiresGuest && store.state.user.token) {
    next({name: 'app.dashboard'})
  } else {
    next();
  }

})

export default router;
