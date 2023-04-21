import {createRouter, createWebHistory} from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Order from '../views/Order.vue'
import Comment from '../views/Comment.vue'
import Category from '../views/Category/index.vue'
import Filling from '../views/Fillings/Filling.vue'
import Gallary from '../views/Gallary/Gallary.vue'
import Statistic from '../views/Statistic.vue'
import Login from '../views/Login.vue'
import NotFound from '../views/NotFound.vue'
import AppLayout from '../components/AppLayout.vue'
import store from '../store'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'app',
      redirect: {name: 'app.dashboard'},
      component: AppLayout,
      meta: {
        requireAuth: true
      },
      children: [
        {
          path: 'dashboard',
          name: 'app.dashboard',
          component: Dashboard,
        },
        {
          path: 'order',
          name: 'app.order',
          component: Order,
        },
        {
          path: 'comment',
          name: 'app.comment',
          component: Comment,
        },
        {
          path: 'filling',
          name: 'app.filling',
          component: Filling,
        },
        {
          path: 'category',
          name: 'app.category',
          component: Category,
        },
        {
          path: 'gallary',
          name: 'app.gallary',
          component: Gallary,
        },
        {
          path: 'statistic',
          name: 'app.statistic',
          component: Statistic,
        },
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/:pathMatch(.*)',
      name: 'notfound',
      component: NotFound
    }
  ]
})

router.beforeEach((to, from, next) => {
  if(to.meta.requireAuth && !store.state.user.token){
    next({name: 'login'})
  }else if(to.name === 'login' && store.state.user.token){
    next({name: 'app.dashboard'})
  }else{
    next()
  }
})
export default router