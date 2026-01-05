import { createRouter, createWebHistory } from 'vue-router'
import Home from './views/Home.vue'
import Property from './views/Property.vue'

export default createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: Home,
    },
    {
      path: '/property/:id',
      component: Property,
    }
  ],
})
