import axios from '../utils/request'

export function removeCache() {
    return axios({
        url: '/cache/delete',
        method: 'delete'
    })
}