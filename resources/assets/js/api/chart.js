import axios from "../utils/request"

export function getchart(page, sn, pagesize, time) {
    return axios({
        url: `/video/dust/chart/${sn}`,
        method: 'get',
        params: {page, pagesize, time}
    })
}