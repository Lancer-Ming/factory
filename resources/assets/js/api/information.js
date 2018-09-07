import axios from "../utils/request"

export function getinformation(page, sn, pagesize, time) {
    return axios({
        url: `/video/dust/warn/${sn}`,
        method: 'get',
        params: {page, pagesize, time}
    })
}



