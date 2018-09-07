require('./bootstrap')

//window.Vue = require('vue')
import Vue from 'vue'

Vue.config.productionTip = false
//import App from './App.vue'
import router from './router'
//import './directives'
import ElementUI from 'element-ui'
//
import $ from 'jquery'
//
import {Message} from 'element-ui'
import {MessageBox} from 'element-ui'
import axios from 'axios'
import {implode} from "./utils/common.js"

import "babel-polyfill" //低版本浏览器不支持es6转码

//
//import i18n from './lang'
Vue.use(ElementUI)
Vue.prototype.$ = $
Vue.prototype.axios = axios
Vue.prototype.message = Message

// echarts
import echarts from 'echarts'

Vue.prototype.$echarts = echarts

//
import Breadcrumb from './components/Breadcrumb'

import {Local} from './utils/common'
import './directives/'

new Vue({
    el: '#layout-app',
    router,
    //i18n,
    components: {Breadcrumb},
    //template: '<App/>',
    delimiters: ['${', '}'],
    data: {
        headers: [],    // 导航头
        sidebars: [],   // 侧边栏
        isCollapse: false,      // 是否折叠
        tabsValue: '0', // 标签值
        tabs: [],       // 标签数组对象
        activeNavIndex: 0,  // active 导航
        activeSideBar: '',  // active 侧边栏
        recordTabsWithHeader: {},   // 表示记录标签和头的关系
        isInit: false,   // 是否刷新初始化
        currentOpenMenuName: []
    },
    created() {
        this.initLocal()
        this.switchActivedUrl()
        this.axios.get("/permission").then(res => {
            this.headers = res.data.data;
            if (this.activeSideBar) {
                this.activeNavIndex = this.recordTabsWithHeader[this.activeSideBar]
            }

            this.getSideBars(this.activeNavIndex)

        })

        this.isInit = true
    },
    methods: {

        getSideBars(index) {
            console.log(index)
            //当为首页时
            if (index == 0) {
                this.$router.push({path: '/'})
                this.homePageAddTab('/', '智慧工地首页')
                this.activeSideBar = ''
            } else {
                this.sidebars = this.headers[index].children
                this.isCollapse = false
            }
            this.activeNavIndex = index
            new Local().set('activeNavIndex', index)
        },
        switchBar() {
            this.isCollapse = !this.isCollapse
        },
        homePageAddTab(path, title) {
            let name = 'index'
            let isRepeat = false
            let tabs = this.$root.$data.tabs
            tabs.forEach((item, index) => {
                if (item.name === name) {
                    isRepeat = true
                }
            })

            // 如果是tabs里没有
            if (!isRepeat) {
                tabs.push({
                    title,
                    name,
                    path: path
                })

                new Local().set('tabs', tabs)
            }

            new Local().set('activeTabs', name)

            this.tabsValue = name


        },
        addTab(routerName) {
            //console.log(routerName)
            let newTabName = routerName.split('/').join('.').substr(1);
            let path = routerName
            let isRepeat = false
            this.tabs.forEach((item, index) => {
                if (item.name === newTabName) {
                    isRepeat = true
                }
            })
            if (!isRepeat) {
                let title = ''
                this.sidebars.forEach(item => {
                    if (item.children.length > 0) {
                        item.children.forEach(val => {
                            val.name === newTabName ? title = item.label : ''
                        })
                    }
                    if (item.name === newTabName) {
                        title = item.label
                    }
                })

                this.tabs.push({
                    title,
                    name: newTabName,
                    path: path
                })

                new Local().set('tabs', this.tabs)
            }
            this.activeSideBar = newTabName
            // 设置为高亮
            this.tabsValue = newTabName
            new Local().set('activeTabs', newTabName)
            new Local().set('activeSideBar', newTabName)

            // 对tabs的name和header的index进行关联
            this.recordTabsWithHeader[newTabName] = this.activeNavIndex
            new Local().set('recordTabsWithHeader', this.recordTabsWithHeader)

        },
        removeTab(targetName) {
            let tabs = this.tabs;
            let activeName = this.tabsValue;
            if (activeName === targetName) {
                tabs.forEach((tab, index) => {
                    if (tab.name === targetName) {
                        let nextTab = tabs[index + 1] || tabs[index - 1];
                        if (nextTab) {
                            activeName = nextTab.name;
                        }
                    }
                });
            }

            this.tabsValue = activeName;
            this.tabs = tabs.filter(tab => tab.name !== targetName);
            // 给localStorage里更改tabs
            new Local().set('tabs', this.tabs)
            // 如果tabs全部关闭了
            if (this.tabs.length === 0) {
                // 清空localStorage
                new Local().clear()
                // 清空一写data
                this.activeNavIndex = null,
                    this.recordTabsWithHeader = {}
                this.activeSideBar = ''
                this.tabsValue = ""
                // 跳转主页
                this.$router.push({path: '/'})
            }
        },
        handleClick: function (tab, event) {

        },
        logout() {
            let form = document.querySelector('.logout');
            localStorage.clear()
            form.submit();
        },
        initLocal() {
            this.activeSideBar = new Local().get('activeSideBar')
            this.tabsValue = new Local().get('activeTabs') || '0'
            this.tabs = new Local().get('tabs') || []
            this.activeNavIndex = new Local().get('activeNavIndex') || 0
            this.recordTabsWithHeader = new Local().get('recordTabsWithHeader') || {}
            this.currentOpenMenuName = new Local().get('currentOpenMenuName') || []
        },
        openSubMenu(index) {
            this.currentOpenMenuName[0] = index
            new Local().set('currentOpenMenuName', this.currentOpenMenuName)
        },
        implode(arr, attr) {
            return implode(arr, attr);
        },
        pageRefresh() {
            location.reload();
        },
        pageFullscreen() {
            $(".header-nav").toggle();
            $(".aside-wrapper").toggle();
        },
        pageClose() {
            if (confirm("确认要删除？")) {
                //window.event.returnValue = false;
                // 清空localStorage
                new Local().clear();
                location.reload();
            }
            return false;
        },
        switchActivedUrl() {
            if (this.activeSideBar) {
                let activeSideBar = '/' + this.activeSideBar.split('.').join('/')
                router.push({path: activeSideBar})
            }


        }
    },
    watch: {
        tabsValue(val) {
            const filter = this.tabs.filter(item => {
                return item.name === val
            })[0]

            const path = filter.path
            const query = filter.query

            // 将currentActiveTab 存到LocalStorage里
            new Local().set('activeTabs', val)

            // 如果点击的不是侧边栏
            if (filter.is_sub) {
                this.$router.push({path, query})
                this.isInit = false
                return
            }
            new Local().set('activeSideBar', val)

            // 如果是首页
            if(val === 'index') {
                this.$router.push({path: path})
                this.getSideBars(0)
                return
            }

            if (!this.isInit) {     // 如果是刷新了页面，这个就不用再次获取了。
                this.isInit = false
                this.activeSideBar = val
                this.activeNavIndex = this.recordTabsWithHeader[val]
                this.getSideBars(this.activeNavIndex)
                // 并且路由跳转
                this.$router.push({path: path})
            } else {
                this.isInit = false
            }


        }
    },
})
