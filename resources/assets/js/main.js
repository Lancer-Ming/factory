require('./bootstrap')

window.Vue = require('vue')
//import Vue from 'vue'

Vue.config.productionTip = false

import App from './App'
//import Hello from './components/Hello.vue';
import router from './router'
//import './directives'
import ElementUI from 'element-ui'
//
import $ from 'jquery'
//
import {Message} from 'element-ui'
import {MessageBox} from 'element-ui'
import axios from 'axios'


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


import './directives/'

new Vue({
    render: h => h(App),
}).$mount('#layout-app')



