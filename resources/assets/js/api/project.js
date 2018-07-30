import axios from '../utils/request'

export function getproject(){
    return axios({
        url: `/project` ,
        method: 'get'
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
export function updateproject(id,data){
    return axios({
        url: `/project/${id}` ,
        method: 'put',
        data: data
    })
}
export function destroyproject(data){
    return axios({
        url: `/project` ,
        method: 'delete',
        data: data
    })
}