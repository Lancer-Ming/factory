import Vue from 'vue'
import Router from 'vue-router'
import User from '../components/User.vue'
import Role from '../components/Role.vue'
import Permission from '../components/Permission.vue'
import EditPermission from '../components/Edit_permission.vue'

Vue.use(Router)

const router = new Router({
    saveScrollPosition: true,
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
        },
        {
            path: '/system/role/:id/edit_permission',
            name: 'system.role.edit_permission',
            component: EditPermission
        },
        {
            path: '/system/permission/index',
            name: 'permission',
            component: Permission
        },
    ]
})
export default router