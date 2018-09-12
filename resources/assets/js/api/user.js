import axios from '../utils/request'

export function getUsers(page=1) {
    return axios({
        url: `/user?page=${page}`,
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
    console.log(123)
}

export function addUser(form) {
    return axios({
        url: '/user',
        method: 'post',
        data: form
    })
}

export function destroyUser(id, page) {
    return axios({
        url: `/user?page=${page}`,
        method: 'delete',
        data: {id}
    })
}

export function updataItem(userId,itemId){
    return axios({
        url: `/user/${userId}/item`,
        method: 'post',
        data: {itemId}
    })
}
export function getItem(userId){
    return axios({
        url: `/user/${userId}/item`,
        method: 'get',
    })
}