export default [
    {
        path: '/system/user/index',
        name: 'user',
        component: () => import('../router/components/User')
    },
    {
        path: '/system/role/index',
        name: 'role',
        component: role,
        children:[
            {
                path: '/system/role/edit_permission',
                name: 'system.role.edit_permission',
                component: () => import('../router/components/edit_permission')
            }
        ]
    },
    {
        path: '/system/permission/index',
        name: 'permission',
        component: () => import('../router/components/Permission')
    }

]