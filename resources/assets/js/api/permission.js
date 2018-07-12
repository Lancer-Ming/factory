import axios from '../utils/request'

export function getPermissions() {
    return axios({
        url: `/permission?is_category=1`,
        method: 'get'
    })
}

export function editPermissions(id) {
    return axios({
        url: `/permission/${id}/edit`,
        method: 'get'
    })
}

export function updatePermissions(id, form) {
    return axios({
        url: `/permission/${id}`,
        method: 'patch',
        data: form
    })
}

export function addPermissions(form) {
    return axios({
        url: `/permission`,
        method: 'post',
        data: form
    })
}

export function deletePermissions(id) {
    return axios({
        url: `/permission/${id}`,
        method: 'delete',
    })
}

export function sortPermissions(data) {
    return axios({
        url: `/permission/sort`,
        method: 'put',
        data: {sort: data}
    })
}