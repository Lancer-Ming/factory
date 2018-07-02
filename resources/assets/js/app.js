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
        isCollapse: false,
    },
    created() {
        this.axios.get("/permissions").then(res => {
            this.headers = res.data;
        })
        this.getSideBars(1)
    },
    methods: {
        getSideBars(id) {
            this.axios.get(`/permissions/${id}/getsidebars`).then(res => {
                if (res.data.response_status === 'success') {
                    this.sidebars = res.data.info.data;
                }
            })
        }
    }
});
