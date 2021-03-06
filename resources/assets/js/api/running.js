import axios from '../utils/request'

export function getrunning(page, sn, pagesize, time) {
    return axios({
        url: `/video/dust/working_time/${sn}`,
        method: 'get',
        params: {page, pagesize, time}
    })
}