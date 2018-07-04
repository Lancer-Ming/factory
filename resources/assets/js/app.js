/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import ElementUI from 'element-ui'
import axios from 'axios'
import router from './router/index'

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
    router,
    delimiters: ['${', '}'],
    data: {
        headers: [],
        sidebars: [],
        isCollapse: false,      // 是否折叠
        firstMenuIndex: '',    //一级菜单索引
        tabs: [],
        tabIndex: 2
    },
    created() {
        this.axios.get("/permissions").then(res => {
            // console.log(res)
            this.headers = res.data.info.data;
        })
    },
    methods: {
        getSideBars(index){
            this.sidebars = this.headers[index].children
            this.isCollapse = false
            this.firstMenuIndex = index
        },
        switchBar() {
            this.isCollapse = !this.isCollapse
        },
        addTab(targetName) {
            let newTabName = ++this.tabIndex + '';
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
                    content: 'New Tab content'
                })

                this.tabsValue = newTabName;
            }

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
        logout() {
            let form = document.querySelector('.logout');
            form.submit();
        }
    }
});
