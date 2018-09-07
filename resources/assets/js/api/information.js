import axios from "../utils/request"

export function getinformation(page, sn, pagesize, data) {
    let {time,warning_status,warning_type} = data
    return axios({
        url: `/video/dust/warn/${sn}`,
        method: 'get',
        params: {page, pagesize, time,warning_status,warning_type}
    })
}



