import axios from '../utils/request'

export function getRoles(page=1){
    return axios({
        url: `/role?page=${page}`,
        method: 'get',
    })
}
export function storeRole(id){
    return axios({
        url: `/role/${id}`,
        method: 'post',
    })
}

export function destroyRole(id,page){
    return axios({
        url: `/role/${id}`,
        methods: 'delete',
        data: {id}
    })
}
export function updateRole(id, form) {
    return axios({
        url: `/role/${id}`,
        method: 'patch',
        data: form
    })
    console.log(123)
}