import axios from '../utils/request'

export function getPermissions() {
    return axios({
        url: `/permission?is_category=1`,
        method: 'get'
    })
}