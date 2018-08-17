import axios from '../utils/request'

export function getcrane(page,data={},pagesize=10){
    if (Object.keys(data).length > 0) {
        Object.assign(data, {page, pagesize});
        return axios({
            url: `/crane`,
            method: 'get',
            params: data
        })
    }
        return axios({
            url: `/crane?page=${page}&pagesize=${pagesize}`,
            method: 'get',
        })
}
export function storecrane(data,pagesize){
    data.pagesize = pagesize
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

export function updatecrane(id,data,page,pagesize){
    data.pagesize = pagesize
    return axios({
        url: `/crane/${id}?page=${page}`,
        method: 'patch',
        data: data
    })
}

export function destroycrane(id,page,pagesize){
    return axios({
        url: `crane/${id}?page=${page}`,
        method: 'delete',
        data: { id,pagesize }
    })
}