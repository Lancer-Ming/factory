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
        component: () => import('../views/demo/UploadExcel')
    },
    {
        path: '/demo/excel/export/index',
        name: 'demo.excel.export.index',
        component: () => import('../views/demo/Export')
    },
    {
        path: '/cxjf/index',
        name: 'cxjf.index',
        component: () => import('../views/demo/Cxjf')
    },
    {
        path: '/demo/excel/selected/index',
        name: 'demo.excel.selected.index',
        component: () => import('../views/demo/Selected')
    },
    {
        path: '*',
        component: () => import('../views/errorPage/404')
        //redirect: '/'
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
        path: '/',
        name: 'Home',
        component: () => import('../views/Home'),
        meta: { title: '我的桌面' }
    },
    {
        path: '/person/staff/index',
        name: 'person.staff.index',
        component: () => import('../views/person/Staff'), //1.1 建筑工人库
        meta: { title: '建筑工人库' }
    },
    {
        path: '/person/manager/index',
        name: 'person.manager.index',
        component: () => import('../views/person/Manager') // 1.2 管理人员库
    },
    {
        path: '/person/realname/index',
        name: 'person.realname.index',
        component: () => import('../views/person/Realname') //1.3 实名制统计
    },
    {
        path: '/unit/company/index',
        name: 'unit.company.index',
        component: () => import('../views/person/Company') //1.4  企业管理
    },
    {
        path: '/unit/utype/index',
        name: 'unit.utype.index',
        component: () => import('../views/person/Utype') // 1.5 企业类型管理
    },
    {
        path: '/person/department/index',
        name: 'person.department.index',
        component: () => import('../views/person/Department') // 1.5 部门管理 -----企业人员库 1.1-1.5 end
    },
    {
        path: '/item/project/index',
        name: 'item.project.index',
        component: () => import('../views/project/Project') // 2.1 现场管理
    },
    {
        path: '/item/roster/index',
        name: 'item.roster.index',
        component: () => import('../views/project/Roster') // 2.2花名册
    },
    {
        path: '/item/config/index',
        name: 'item.config.index',
        component: () => import('../views/project/Config') // 2.3 同步市级配置
    },
    {
        path: '/train/train/index',
        name: 'train.train.index',
        component: () => import('../views/project/Train') // 2.4 培训管理 项目管理 2.1-2.4 end
    },
    {
        path: '/device/attendance/index',
        name: 'device.attendance.index',
        component: () => import('../views/device/Attendance') // 3.1 考勤设备管理
    },
    {
        path: '/device/crane/index',
        name: 'device.crane.index',
        component: () => import('../views/device/Crane') //3.2  塔机设备管理
    },
    {
        path: '/device/elevator/index',
        name: 'device.elevator.index',
        component: () => import('../views/device/Elevator') //3.3 升降机设备管理
    },
    {
        path: '/device/dust/index',
        name: 'device.dust.index',
        component: () => import('../views/device/Dust') //3.4 扬尘噪音设备管理
    },
    {
        path: '/device/video/index',
        name: 'device.video.index',
        component: () => import('../views/device/Video')  //3.5 视频设备管理 -----设备管理 3.1-3.5 end
    },
    {
        path: '/video/current/index',
        name: 'video.current.index',
        component: () => import('../views/monitors/Current') // 4.1 实时视频
    },
    {
        path: '/video/review/index',
        name: 'video.review.index',
        component: () => import('../views/monitors/Review') // 4.2 视频回放
    },
    {
        path: '/video/elevator/index',
        name: 'video.elevator.index',
        component: () => import('../views/monitors/Elevator') // 4.3 升降机监控
    },
    {
        path: '/video/crane/index',
        name: 'video.crane.index',
        component: () => import('../views/monitors/Crane') // 4.4 塔吊监控
    },
    {
        path: '/video/dust/index',
        name: 'video.dust.index',
        component: () => import('../views/monitors/Dust'),  //4.5 绿色监控 -----监控管理 4.1-4.5 end
    },
    {
        path: '/video/dust/workingdata',
        name: 'video.dust.workingdata',
        component: () => import('../views/monitors/subDust/WorkingData')
    },
    {
        path: '/video/dust/Information',
        name: 'video.dust.Information',
        component: () => import('../views/monitors/subDust/Information')
    },
    {
        path: '/video/dust/Running',
        name: 'video.dust.Running',
        component: () => import('../views/monitors/subDust/Running')
    },
    {
            path: '/video/dust/Chart',
        name: 'video.dust.Chart',
        component: () => import('../views/monitors/subDust/Chart')
    },
    {
        path: '/video/dust/Standard',
        name: 'video.dust.Standard',
        component: () => import('../views/monitors/subDust/Standard')
    },
    {
        path: '/wage/wage/index',
        name: 'wage.wage.index',
        component: () => import('../views/attendance/Wage') // 5.1 工资管理
    },
    {
        path: '/attendance/manage/index',
        name: 'attendance.manage.index',
        component: () => import('../views/attendance/Manage') // 5.2 考勤管理
    },
    {
        path: '/attendance/calculate/index',
        name: 'attendance.calculate.index',
        component: () => import('../views/attendance/Calculate') // 5.3 考勤统计
    },
    {
        path: '/attendance/crux/index',
        name: 'attendance.crux.index',
        component: () => import('../views/attendance/Crux') // 5.4 关键人员出勤
    },
    {
        path: '/attendance/item/index',
        name: 'attendance.item.index',
        component: () => import('../views/attendance/Item') // 5.5 项目考勤统计 -----考勤管理 5.1-5.5 end
    },
    {
        path: '/statistics/unit/all/index',
        name: 'statistics.unit.all.index',
        component: () => import('../views/statistics/Unit_all') // 6.1.1 企业全部人员报表
    },
    {
        path: '/statistics/unit/team/index',
        name: 'statistics.unit.team.index',
        component: () => import('../views/statistics/Unit_team')  // 6.1.2 企业班组人员报表
    },
    {
        path: '/statistics/item/all/index',
        name: 'statistics.item.all.index',
        component: () => import('../views/statistics/Item_all')  // 6.2.1 项目全部人员报表
    },
    {
        path: '/statistics/item/team/index',
        name: 'statistics.item.team.index',
        component: () => import('../views/statistics/Item_team')  // 6.2.2 项目班组人员报表
    },
    {
        path: '/statistics/item/enter/index',
        name: 'statistics.item.enter.index',
        component: () => import('../views/statistics/Item_enter')  // 6.2.3 项目人员进场报表
    },
    {
        path: '/statistics/item/age/index',
        name: 'statistics.item.age.index',
        component: () => import('../views/statistics/Item_age')  // 6.2.4 项目人员年龄结构
    },
    {
        path: '/statistics/labor/daily/index',
        name: 'statistics.labor.daily.index',
        component: () => import('../views/statistics/Labor_daily')  // 6.3.1 劳务人员日考勤表
    },
    {
        path: '/statistics/labor/register/index',
        name: 'statistics.labor.register.index',
        component: () => import('../views/statistics/Labor_register')  // 6.3.2 劳务人员实名登记台账
    },
    {
        path: '/statistics/labor/wege/index',
        name: 'statistics.labor.wege.index',
        component: () => import('../views/statistics/Labor_wege')  // 6.3.3 劳务人员工资表
    },
    {
        path: '/statistics/labor/wageback/index',
        name: 'statistics.labor.wageback.index',
        component: () => import('../views/statistics/Labor_wageback')  // 6.3.4 劳务人员工资补发表
    },
    {
        path: '/statistics/labor/enter/index',
        name: 'statistics.labor.enter.index',
        component: () => import('../views/statistics/Labor_enter')  // 6.3.5 人员变更情况周报表（进场）
    },
    {
        path: '/statistics/labor/leave/index',
        name: 'statistics.labor.leave.index',
        component: () => import('../views/statistics/Labor_leave')  // 6.3.6 人员变更情况周报表（出场）  6.1-6.3 end
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
        component: () => import('../views/system/Debug') // 7.5 系统日志
    },
    {
        path: '/system/info/index',
        name: 'system.info.index',
        component: () => import('../views/system/Info') // 7.6 系统设置
    },
    {
        path: '/system/log/index',
        name: 'system.log.index',
        component: () => import('../views/system/Log') // 7.7 操作日志
    }
]