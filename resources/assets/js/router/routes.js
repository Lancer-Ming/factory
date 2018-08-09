/*
* person 企业库
* project 项目管理
* devices 设备管理
* monitors 监控管理
* attendance 考勤管理
* statistics 报表统计
* system 系统管理
*/
export default [
    {
        path: '/demo/excel/upload/index',
        name: 'demo.excel.upload.index',
        component: () => import('../views/demo/uploadExcel')
    },
    {
        path: '/demo/excel/export/index',
        name: 'demo.excel.export.index',
        component: () => import('../views/demo/export')
    },
    {
        path: '/cxjf/index',
        name: 'cxjf.index',
        component: () => import('../views/demo/cxjf')
    },
    {
        path: '/demo/excel/selected/index',
        name: 'demo.excel.selected.index',
        component: () => import('../views/demo/selected')
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
        path: '/person/staff/index',
        name: 'person.staff.index',
        component: () => import('../views/person/staff') //1.1 建筑工人库
    },
    {
        path: '/person/manager/index',
        name: 'person.manager.index',
        component: () => import('../views/person/manager') // 1.2 管理人员库
    },
    {
        path: '/person/realname/index',
        name: 'person.realname.index',
        component: () => import('../views/person/realname') //1.3 实名制统计
    },
    {
        path: '/unit/company/index',
        name: 'unit.company.index',
        component: () => import('../views/person/Company') //1.4  企业管理
    },
    {
        path: '/unit/utype/index',
        name: 'unit.utype.index',
        component: () => import('../views/person/utype') // 1.5 企业类型管理
    },
    {
        path: '/person/department/index',
        name: 'person.department.index',
        component: () => import('../views/person/department') // 1.5 部门管理 -----企业人员库 1.1-1.5 end
    },
    {
        path: '/item/project/index',
        name: 'item.project.index',
        component: () => import('../views/project/project') // 2.1 现场管理
    },
    {
        path: '/item/roster/index',
        name: 'item.roster.index',
        component: () => import('../views/project/roster') // 2.2花名册
    },
    {
        path: '/item/config/index',
        name: 'item.config.index',
        component: () => import('../views/project/config') // 2.3 同步市级配置
    },
    {
        path: '/train/train/index',
        name: 'train.train.index',
        component: () => import('../views/project/train') // 2.4 培训管理 项目管理 2.1-2.4 end
    },
    {
        path: '/device/attendance/index',
        name: 'device.attendance.index',
        component: () => import('../views/device/attendance') // 3.1 考勤设备管理
    },
    {
        path: '/device/crane/index',
        name: 'device.crane.index',
        component: () => import('../views/device/crane') //3.2  塔机设备管理
    },
    {
        path: '/device/elevator/index',
        name: 'device.elevator.index',
        component: () => import('../views/device/elevator') //3.3 升降机设备管理
    },
    {
        path: '/device/dust/index',
        name: 'device.dust.index',
        component: () => import('../views/device/dust') //3.4 扬尘噪音设备管理
    },
    {
        path: '/device/video/index',
        name: 'device.video.index',
        component: () => import('../views/device/video')  //3.5 视频设备管理 -----设备管理 3.1-3.5 end
    },
    {
        path: '/video/current/index',
        name: 'video.current.index',
        component: () => import('../views/monitors/current') // 4.1 实时视频
    },
    {
        path: '/video/review/index',
        name: 'video.review.index',
        component: () => import('../views/monitors/review') // 4.2 视频回放
    },
    {
        path: '/video/elevator/index',
        name: 'video.elevator.index',
        component: () => import('../views/monitors/elevator') // 4.3 升降机监控
    },
    {
        path: '/video/crane/index',
        name: 'video.crane.index',
        component: () => import('../views/monitors/crane') // 4.4 塔吊监控
    },
    {
        path: '/video/green/index',
        name: 'video.green.index',
        component: () => import('../views/monitors/green')  //4.5 绿色监控 -----监控管理 4.1-4.5 end
    },
    {
        path: '/wage/wage/index',
        name: 'wage.wage.index',
        component: () => import('../views/attendance/wage') // 5.1 工资管理
    },
    {
        path: '/attendance/manage/index',
        name: 'attendance.manage.index',
        component: () => import('../views/attendance/manage') // 5.2 考勤管理
    },
    {
        path: '/attendance/calculate/index',
        name: 'attendance.calculate.index',
        component: () => import('../views/attendance/calculate') // 5.3 考勤统计
    },
    {
        path: '/attendance/crux/index',
        name: 'attendance.crux.index',
        component: () => import('../views/attendance/crux') // 5.4 关键人员出勤
    },
    {
        path: '/attendance/item/index',
        name: 'attendance.item.index',
        component: () => import('../views/attendance/item') // 5.5 项目考勤统计 -----考勤管理 5.1-5.5 end
    },
    {
        path: '/statistics/unit/all/index',
        name: 'statistics.unit.all.index',
        component: () => import('../views/statistics/unit_all') // 6.1.1 企业全部人员报表
    },
    {
        path: '/statistics/unit/team/index',
        name: 'statistics.unit.team.index',
        component: () => import('../views/statistics/unit_team')  // 6.1.2 企业班组人员报表
    },
    {
        path: '/statistics/item/all/index',
        name: 'statistics.item.all.index',
        component: () => import('../views/statistics/item_all')  // 6.2.1 项目全部人员报表
    },
    {
        path: '/statistics/item/team/index',
        name: 'statistics.item.team.index',
        component: () => import('../views/statistics/item_team')  // 6.2.2 项目班组人员报表
    },
    {
        path: '/statistics/item/enter/index',
        name: 'statistics.item.enter.index',
        component: () => import('../views/statistics/item_enter')  // 6.2.3 项目人员进场报表
    },
    {
        path: '/statistics/item/age/index',
        name: 'statistics.item.age.index',
        component: () => import('../views/statistics/item_age')  // 6.2.4 项目人员年龄结构
    },
    {
        path: '/statistics/labor/daily/index',
        name: 'statistics.labor.daily.index',
        component: () => import('../views/statistics/labor_daily')  // 6.3.1 劳务人员日考勤表
    },
    {
        path: '/statistics/labor/register/index',
        name: 'statistics.labor.register.index',
        component: () => import('../views/statistics/labor_register')  // 6.3.2 劳务人员实名登记台账
    },
    {
        path: '/statistics/labor/wege/index',
        name: 'statistics.labor.wege.index',
        component: () => import('../views/statistics/labor_wege')  // 6.3.3 劳务人员工资表
    },
    {
        path: '/statistics/labor/wageback/index',
        name: 'statistics.labor.wageback.index',
        component: () => import('../views/statistics/labor_wageback')  // 6.3.4 劳务人员工资补发表
    },
    {
        path: '/statistics/labor/enter/index',
        name: 'statistics.labor.enter.index',
        component: () => import('../views/statistics/labor_enter')  // 6.3.5 人员变更情况周报表（进场）
    },
    {
        path: '/statistics/labor/leave/index',
        name: 'statistics.labor.leave.index',
        component: () => import('../views/statistics/labor_leave')  // 6.3.6 人员变更情况周报表（出场）  6.1-6.3 end
    },
    {
        path: '/system/permission/index',
        name: 'permission',
        component: () => import('../views/system/Permission') // 7.1  菜单与权限管理
    },
    {
        path: '/system/role/index',
        name: 'role',
        component: () => import('../views/system/Role') // 7.2 用户组管理
    },
    {
        path: '/system/role/:id/edit_permission',
        name: 'system.role.edit_permission',
        component: () => import('../views/system/Edit_permission') // 7.2.1用户组编辑权限
    },
    {
        path: '/system/user/index',
        name: 'user',
        component: () => import('../views/system/User') // 7.3 用户管理
    },
    {
        path: '/system/cache/index',
        name: 'system.cache.index',
        component: () => import('../views/system/Cache') // 7.4 缓存管理
    },
    {
        path: '/system/debug/index',
        name: 'system.debug.index',
        component: () => import('../views/system/debug') // 7.5 系统日志
    },
    {
        path: '/system/info/index',
        name: 'system.info.index',
        component: () => import('../views/system/info') // 7.6 系统设置
    },
    {
        path: '/system/log/index',
        name: 'system.log.index',
        component: () => import('../views/system/log') // 7.7 操作日志
    }
]