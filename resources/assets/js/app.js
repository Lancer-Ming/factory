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
import { Message } from 'element-ui'
import { MessageBox } from 'element-ui'
import axios from 'axios'
import { implode } from "./utils/common.js"
//

Vue.use(ElementUI)
Vue.prototype.$ = $
Vue.prototype.axios = axios
Vue.prototype.message = Message
import { Local } from './utils/common'
new Vue({
    el: '#app',
    router,
    //components: { App },
    //template: '<App/>',
    delimiters: ['${', '}'],
    data:{
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

        getSideBars(index){
            //console.log(index)
            this.sidebars = this.headers[index].children
            this.isCollapse = false
            this.activeNavIndex = index

            new Local().set('activeNavIndex', index)
        },
        switchBar() {
            this.isCollapse = !this.isCollapse
        },
        addTab(routerName) {
            let newTabName = routerName.split('/').join('.').substr(1);
            let path = routerName
            let isRepeat = false
            this.tabs.forEach((item, index)=> {
                if (item.name === newTabName) {
                    isRepeat = true
                }
            })
            if (!isRepeat) {
                let title = ''
                this.sidebars.forEach(item => {
                    if (item.name === newTabName) {
                        title = item.title
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
            if(this.tabs.length === 0) {
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
            new Local().set('currentOpenMenuName',  this.currentOpenMenuName)
        },
        implode(arr, attr) {
            return implode(arr, attr);
        }
    },
    watch: {
        tabsValue(val) {
            const filter = this.tabs.filter(item => {
                return item.name === val
            })

            const path = filter[0].path

            // 将currentActiveTab 存到LocalStorage里
            new Local().set('activeTabs', val)
            new Local().set('activeSideBar', val)

            if (!this.isInit) {     // 如果是刷新了页面，这个就不用再次获取了。
                this.isInit = false
                this.activeSideBar = val
                this.activeNavIndex = this.recordTabsWithHeader[val]
                this.getSideBars(this.activeNavIndex)
                // 并且路由跳转
                this.$router.push({ path: path})
            } else {
                this.isInit = false
            }


        }
    },
})