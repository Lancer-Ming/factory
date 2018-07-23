import axios from '../utils/request'

export function getUtypes() {
    return axios({
        url: '/utype/searchoption',
        method: 'get'
    })
}

export function getUnits(page,data=null) {
    if (data) {
        return axios({
            url: `/company`,
            method: 'get',
            params: data
        })
    }
    return axios({
        url: `/company?page=${page}`,
        method: 'get',
    })
}