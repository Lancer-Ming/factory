export default [
    {
        path: '/test',
        name: 'test',
        component: () => import('../views/Test')
    },
    {
        path: '/system/user/index',
        name: 'user',
        component: () => import('../views/User')
    },
    {
        path: '/system/role/index',
        name: 'role',
        component: () => import('../views/Role')
    },
    {
        path: '/system/role/:id/edit_permission',
        name: 'system.role.edit_permission',
        component: () => import('../views/Edit_permission')
    },
    {
        path: '/system/permission/index',
        name: 'permission',
        component: () => import('../views/Permission')
    },
    {
        path: '/system/cache/index',
        name: 'system.cache.index',
        component: () => import('../views/Cache')
    },

]