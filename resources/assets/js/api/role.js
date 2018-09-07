import axios from '../utils/request'

export function getRoles(page=1){
    return axios({
        url: `/role?page=${page}`,
        method: 'get',
    })
}
export function storeRole(name){
    return axios({
        url: `/role`,
        method: 'post',
        data: { name }
    })
}

export function destroyRole(id,page=1){
    return axios({
        url: `/role`,
        method: 'delete',
        data: {id, page}
    })
}
export function updateRole(id, name) {
    return axios({
        url: `/role/${id}`,
        method: 'patch',
        data: { name }
    })
}
export function getPermission(role_id){
    return axios({
        url:`/role/${role_id}/permission`,
        method: 'get'
    })
}
export function updatePermission(role_id,permission_id){
    return axios({
        url:`/role/${role_id}/permission`,
        method: 'put',
        data: { permission_id }
    })
}