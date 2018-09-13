import axios from '../utils/request'

export function getItemWithDevice(page, pagesize) {
    return axios({
        url: `/video/current`,
        method: 'get',
        params: {page, pagesize}
    })
}