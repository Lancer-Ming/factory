import axios from "../utils/request"

export function getstandard(page, sn, pagesize) {
    return axios({
        url: `/video/dust/standard`,
        method: 'get',
        params: {page, pagesize, sn}
    })
}