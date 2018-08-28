import axios from '../utils/request'

export function getdust(page,data={},pagesize=10){
    if (Object.keys(data).length > 0) {
        Object.assign(data, {page, pagesize});
        return axios({
            url: `/dust`,
            method: 'get',
            params: data
        })
    }
    return axios({
        url: `/dust?page=${page}&pagesize=${pagesize}`,
        method: 'get',
    })
}
export function storedust(data,pagesize){
    data.pagesize = pagesize
    return axios({
        url: `/dust`,
        method: 'post',
        data: data
    })
}

export function editdust(id){
    return axios({
        url: `/dust/${id}/edit`,
        method: 'get'
    })
}

export function updatedust(id,data,page,pagesize){
    data.pagesize = pagesize
    return axios({
        url: `/dust/${id}?page=${page}`,
        method: 'patch',
        data: data
    })
}


export function destroydust(id,page,pagesize){
    return axios({
        url: `/dust`,
        method: 'delete',
        data: { id,pagesize }
    })
}