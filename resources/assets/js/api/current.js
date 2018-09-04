import axios from '../utils/request'

export function getItemWithDevice() {
    return axios({
        url: `/video/current`,
        method: 'get'
    })
}