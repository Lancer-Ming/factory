import axios from 'axios'
import { Message } from 'element-ui'
import ErrorMessage from '../components/_error_message.vue'

// http response 拦截器
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        // 403 没有权限
        if (error.response.status == 403) {
            Message({
                message: '您没有权限操作',
                type: 'warning',
            })
        }

        // 422 表单或者其他的规则不符
        if (error.response.status == 422) {
            let errors = error.response.data.errors
            const arr = Object.values(errors)
            let html = ''
            let result = []
            arr.forEach(item => {
                result.push(...item)
            })

            result.forEach(item => {
                html += `<li style="list-style: none;">${item}</li>`
            })

            Message({
                message: html,
                type: 'error',
                dangerouslyUseHTMLString: true
            })
        }
        return Promise.reject(error.response.data)
    });

export default axios