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
        firstMenuIndex: '',    //一级菜单索引
        editableTabsValue2: '0',
        editableTabs2: [],
        tabIndex: 2,
        activeNavIndex: 0,
        activeSideBar: ''
    },
    created() {
        this.activeSideBar = new Local().get('activeSideBar')
        this.editableTabsValue2 = new Local().get('activeTabs') || '0'
        this.editableTabs2 = new Local().get('tabs') || []
        this.activeNavIndex = new Local().get('activeNavIndex') || 0
        this.axios.get("/permissions").then(res => {
            this.headers = res.data.data;
            this.getSideBars(this.activeNavIndex)
        })
    },
    methods: {

        getSideBars(index){
            this.$nextTick(() => {
                this.sidebars = this.headers[index].children
            })
            this.isCollapse = false
            this.firstMenuIndex = index
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
            this.editableTabs2.forEach((item, index)=> {
                if (item.title === targetName) {
                    isRepeat = true
                }
            })
            if (!isRepeat) {
                this.editableTabs2.push({
                    title: targetName,
                    name: newTabName,
                    path: path
                })

                new Local().set('tabs', this.editableTabs2)
            }
            this.activeSideBar = routerName
            this.editableTabsValue2 = newTabName;
            new Local().set('activeTabs', routerName)
            new Local().set('activeSideBar', routerName)

        },
        removeTab(targetName) {
            let tabs = this.editableTabs2;
            let activeName = this.editableTabsValue2;
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

            this.editableTabsValue2 = activeName;
            this.editableTabs2 = tabs.filter(tab => tab.name !== targetName);
        },
        handleClick: function (tab, event) {

        },
        logout() {
            let form = document.querySelector('.logout');
            form.submit();
        }
    },
    watch: {
        editableTabsValue2(val) {
            const filter = this.editableTabs2.filter(item => {
                return item.name === val
            })
            console.log(val)
            const path = filter[0].path

            new Local().set('activeTabs', val)
            this.activeSideBar = val
            this.$router.push({ path: path})
        }
    },
});

// $(document).ready(function(){
// //     $(".input-new-tag").click(function(){
// //
//     })
// })
