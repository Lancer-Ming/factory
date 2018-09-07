import axios from "../utils/request"

export function getstandard(page, param, pagesize) {
    let {sn, name, item_name} = param
    return axios({
        url: `/video/dust/standard`,
        method: 'get',
        params: {page, pagesize, sn, name, item_name}
    })
}