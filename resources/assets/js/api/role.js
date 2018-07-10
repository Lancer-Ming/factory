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