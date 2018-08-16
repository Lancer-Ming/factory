import axios from '../utils/request'

export function getcrane(data=null){
    return axios({
        url: `/crane`,
        method: 'post',
        data: data
    })
}
export function storecrane(data){
    return axios({
        url: `/crane`,
        method: 'post',
        data: data
    })
}

export function editcrane(id){
    return axios({
        url: `/crane/${id}/edit`,
        method: 'get'
    })
}

export function updatecrane(id,data){
    return axios({
        url: `/crane/${id}`,
        method: 'patch',
        data: data
    })
}

export function destroycrane(id){
    return axios({
        url: `crane/${id}`,
        method: 'delete',
        data: { id }
    })
}