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
    data: {
        headers: [],
        sidebars: [],
        isCollapse: false,      // 是否折叠
        firstMenuIndex: '',    //一级菜单索引
        editableTabs2: [
            {
            title: 'Tab 1',
            name: '1',
            content: 'Tab 1 content'
        },
            {
            title: 'Tab 2',
            name: '2',
            content: 'Tab 2 content'
        },
            {
                title: 'Tab 3',
                name: '3',
                content: 'Tab 3 content'
        },
            {
                title: 'Tab 4',
                name: '4',
                content: 'Tab 4 content'
        }

        ],
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
            this.editableTabs2 = tabs.filter(tab => tab.name !== targetName);
        },
        logout() {
            let form = document.querySelector('.logout');
            form.submit();
        }
    }
});
