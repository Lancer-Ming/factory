import axios from "../utils/request"

export function getchart(page,sn,pagesize){
    return axios({
        url: `/video/dust/chart/${sn}`,
        method: 'get',
        params: {page,pagesize}
    })
}