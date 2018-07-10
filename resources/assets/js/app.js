/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import ElementUI from 'element-ui'

import $ from 'jquery'

import { Message } from 'element-ui'
import { MessageBox } from 'element-ui';
import axios from 'axios'
import router from './router/index'
import { implode } from "./utils/common.js";

Vue.use(ElementUI)
Vue.prototype.$ = $
Vue.prototype.axios = axios
Vue.prototype.message = Message

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

import { Local } from './utils/common'
const app = new Vue({
    el: '#app',
    router,
    delimiters: ['${', '}'],
    data:{
        headers: [],
        sidebars: [],
        isCollapse: false,      // 是否折叠
        tabsValue: '0',
        tabs: [],
        tabIndex: 2,
        activeNavIndex: 0,
        activeSideBar: '',
        recordTabsWithHeader: {}
    },
    created() {
        this.activeSideBar = new Local().get('activeSideBar')
        this.tabsValue = new Local().get('activeTabs') || '0'
        this.tabs = new Local().get('tabs') || []
        this.activeNavIndex = new Local().get('activeNavIndex') || 0
        this.recordTabsWithHeader = new Local().get('recordTabsWithHeader') || {}
    

        this.axios.get("/permissions").then(res => {
            this.headers = res.data.data;
            this.getSideBars(this.activeNavIndex)
        })
    },
    methods: {

        getSideBars(index){
         
                console.log(this.headers[index].children)
                this.sidebars = this.headers[index].children
   
            this.isCollapse = false
            this.activeNavIndex = index

            new Local().set('activeNavIndex', index)
        },
        switchBar() {
            this.isCollapse = !this.isCollapse
        },
        addTab(targetName, routerName) {
            let newTabName = routerName;
            let path = `/${routerName.split('.').join('/')}`
            let isRepeat = false
            this.tabs.forEach((item, index)=> {
                if (item.title === targetName) {
                    isRepeat = true
                }
            })
            if (!isRepeat) {
                this.tabs.push({
                    title: targetName,
                    name: newTabName,
                    path: path
                })

                new Local().set('tabs', this.tabs)
            }
            this.activeSideBar = routerName
            this.tabsValue = newTabName;
            new Local().set('activeTabs', routerName)
            new Local().set('activeSideBar', routerName)

            // 对tabs的name和header的index进行关联
            this.recordTabsWithHeader[routerName] = this.activeNavIndex
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
        },
        handleClick: function (tab, event) {

        },
        logout() {
            let form = document.querySelector('.logout');
            form.submit();
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
            
            // 使对应的header高亮并且跳转
            if (this.recordTabsWithHeader[val] === this.activeNavIndex) return   //如果还是当前的就不用获取了

            this.getSideBars(this.recordTabsWithHeader[val])
            
          
            // 并且路由跳转
            this.$router.push({ path: path})
        }
    },
});
