import Vue from 'vue'
import Router from 'vue-router'
import User from '../components/User.vue'

Vue.use(Router)

const router = new Router({
    linkExactActiveClass: 'active',

    routes: [
        {
            path: '/system/user/index',
            name: 'user',
            component: User
        }
    ]
})

export default router