
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import ElementUI from 'element-ui'

import axios from 'axios'

Vue.use(ElementUI)
Vue.prototype.axios = axios

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    delimiters: ['${', '}'],
    data:{
        nav: [
            {
                icon: 'address-book',
                label: '人员库',
                child: [
                    {
                      icon: '',
                      label: '建筑工人库'
                    },
                    {
                        icon: '',
                        label: '管理人员库'
                    },
                    {
                        icon: '',
                        label: '实名制统计',
                    }
                ]
            },
            {
                icon: 'building',
                label: '企业库',
                child: [
                    {
                        icon: '',
                        label: '企业库'
                    },
                    {
                        icon: '',
                        label: '部门管理'
                    }
                ]
            },
            {
                icon: 'clipboard',
                label: '项目管理',
                child: [
                    {
                        icon: '',
                        label: '现场管理'
                    },
                    {
                        icon: '',
                        label: '花名册'
                    },
                    {
                        icon: '',
                        label: '同步市级配置',
                    }
                ]
            },
            {
                icon: 'gratipay',
                label: '安全培训',
                child: [
                    {
                        icon: '',
                        label: '安全培训'
                    }
                ]
            },
            {
                icon: 'heartbeat',
                label: '设备管理',
                child: [
                    {
                        icon: '',
                        label: '考勤设备管理'
                    },
                    {
                        icon: '',
                        label: '塔机设备管理'
                    },
                    {
                        icon: '',
                        label: '升降机设备管理',
                    },
                    {
                        icon: '',
                        label: '扬尘噪音设备管理',
                    },
                    {
                        icon: '',
                        label: '视频设备管理',
                    }
                ]
            },
            {
                icon: 'play-circle',
                label: '视频监控',
                child: [
                    {
                        icon: '',
                        label: '实时视频'
                    },
                    {
                        icon: '',
                        label: '视频回放'
                    }
                ]
            },
            {
                icon: 'wpexplorer',
                label: '绿色施工'
            },
            {
                icon: 'file-archive-o',
                label: '升降机监控'
            },
            {
                icon: 'video-camera',
                label: '塔机监控'
            },
            {
                icon: 'money',
                label: '工资管理',
                child: [
                    {
                        icon: '',
                        label: '工资管理'
                    }
                ]
            },
            {
                icon: 'tasks',
                label: '考勤管理',
                child: [
                    {
                        icon: '',
                        label: '考勤管理'
                    },
                    {
                        icon: '',
                        label: '考勤统计'
                    },
                    {
                        icon: '',
                        label: '关键人员出勤',
                    },
                    {
                        icon: '',
                        label: '项目考勤统计',
                    }
                ]
            },
            {
                icon: 'file-text-o',
                label: '报表统计',
                child: [
                    {
                        icon: '',
                        label: '企业人员统计',
                        child: [
                            {
                                icon: '',
                                label: '企业人员统计'
                            }
                        ]
                    },
                    {
                        icon: '',
                        label: '项目人员统计'
                    },
                    {
                        icon: '',
                        label: '劳务人员报表',
                    }
                ]
            },
        ]

    }
});
