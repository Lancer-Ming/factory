import axios from '../utils/request'

export function getUtypes() {
    return axios({
        url: '/utype/searchoption',
        method: 'get'
    })
}

export function getUnits(page,data=null, pagesize) {
    if (data) {
        return axios({
            url: `/unit`,
            method: 'get',
            params: data
        })
    }
    return axios({
        url: `/unit?page=${page}&pagesize=${pagesize}`,
        method: 'get',
    })
}

export function editUnit(id) {
    return axios({
        url: `/unit/${id}/edit`,
        method: 'get'
    })
}