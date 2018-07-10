import Vue from 'vue'
import Router from 'vue-router'
import User from '../components/User.vue'
import Role from '../components/Role.vue'
import Auth from '../components/Auth.vue'
import Permission from '../components/Permission.vue'
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
            component: Role,
            children: [{
                path: '/system/role/create',
                name: 'auth',
                component: Auth
            }]
        },
        {
            path: '/system/permission/index',
            name: 'permission',
            component: Permission
        }
    ]
})
export default router