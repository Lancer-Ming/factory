export default [
    {
        path: '/test',
        name: 'test',
        component: () => import('../views/Test')
    },
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home')
    },
    {
        path: '*',
        redirect: '/'
    },
    {
        path: '/401',
        name:'error-401',
        component: () => import('../views/errorPage/401')
    },
    {
        path: '/404',
        name:'error-404',
        component: () => import('../views/errorPage/404')
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
    {
        path: '/unit/company/index',
        name: 'unit.company.index',
        component: () => import('../views/Company')
    },
    {
        path: '/item/project/index',
        name: 'item.project.index',
        component: () => import('../views/Project')
    }
]