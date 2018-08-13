import axios from '../utils/request'

export function getproject(data=null){
    return axios({
        url: `/project` ,
        method: 'get',
        params: data
    })
}
export function storeproject(data){
    console.log(data,2)
    return axios({
        url: `/project` ,
        method: 'post',
        data: data
    })
}
export function editproject(id){
    return axios({
        url: `/project/${id}/edit` ,
        method: 'get'
    })
}
export function showproject(id){
    return axios({
        url: `/project/${id}` ,
        method: 'get'
    })
}
export function updateproject(id, data){
    console.log(data)
    return axios({
        url: `/project/${id}` ,
        method: 'put',
        data: data
    })
}
export function destroyproject(id, data){
    return axios({
        url: `/project/${id}` ,
        method: 'delete',
        data: {unit_ids: data}
    })
}

export function findUnit(id) {
    return axios({
        url: `/project/findUnit`,
        method: 'post',
        data: { id }
    })
}

export function unitForm(page,data={}, pagesize=10) {
    if (Object.keys(data).length > 0) {
        Object.assign(data, {page, pagesize});
        return axios({
            url: `/unit/form`,
            method: 'post',
            params: data
        })
    }

    return axios({
        url: `/unit/form`,
        method: 'post',
        params: {page, pagesize}
    })
}
