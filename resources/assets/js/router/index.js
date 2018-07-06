import Vue from 'vue'
import Router from 'vue-router'
import User from '../components/User.vue'
import Role from '../components/Role.vue'
Vue.use(Router)

const router = new Router({
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/system/user/index',
            name: 'user',
            component: User
        },
        {
            path: '/system/role/index',
            name: 'role',
            component: Role
        },
        {
            path: '/system/role/index',
            name: 'role',
            component: Role
        }
    ]
})
export default router