import Vue from 'vue'
import Router from 'vue-router'
import User from '../components/User.vue'
import Role from '../components/Role.vue'
import Auth from '../components/Auth.vue'
import Permission from '../components/Permission.vue'
import edit_permission from '../components/edit_permission.vue'

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
            children: [
                {
                    path: '/system/role/create',
                    name: 'auth',
                    component: Auth
                },
                {
                    path: '/system/role/edit_permission',
                    name: 'system.role.edit_permission',
                    component: edit_permission
                }
            ]
        },
        {
            path: '/system/permission/index',
            name: 'permission',
            component: Permission
        }
    ]
})
export default router