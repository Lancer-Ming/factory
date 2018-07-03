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
        }
    }
});
