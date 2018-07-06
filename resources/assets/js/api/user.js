import axios from 'axios'

export function getUsers() {
    return axios({
        url: '/user',
        method: 'get',
    })
}

export function getRoles() {
    return axios({
        url: '/user/get_roles',
        method: 'get'
    })
}

export function editUser(id) {
    return axios({
        url: `/user/${id}`,
        method: 'post'
    })
}

export function updateUser(id, form) {
    return axios({
        url: `/user/${id}`,
        method: 'patch',
        data: form
    })
}