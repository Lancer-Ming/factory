import axios from "../utils/request"

export function getworkData(page,sn,pagesize){
    return axios({
        url: `/video/dust/working_data/${sn}`,
        method: 'get',
        params:{ page,pagesize }
    })
}



