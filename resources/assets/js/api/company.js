import axios from '../utils/request'

export function getUtypes() {
    return axios({
        url: '/utype/searchoption',
        method: 'get'
    })
}

export function getUnits(page) {
    return axios({
        url: `/company?page=${page}`,
        method: 'get'
    })
}