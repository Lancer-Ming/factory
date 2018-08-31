import axios from '../utils/request'

export function getrunning(page,sn,pagesize){
    return axios({
        url: `/video/dust/working_time/${sn}`,
        method: 'get',
        params: {page,pagesize}
    })
}