export default [
    {
        path: '/system/user/index',
        name: 'user',
        component: () => import('../router/components/User')
    },
    {
        path: '/system/role/index',
        name: 'role',
        component: role
    },
    {
        path: '/system/permission/index',
        name: 'permission',
        component: () => import('../router/components/Permission')
    }

]