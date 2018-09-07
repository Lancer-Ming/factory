import axios from '../utils/request'

export function getcontrol(page,data={},pagesize=10){
    if (Object.keys(data).length > 0) {
        Object.assign(data, {page, pagesize});
        return axios({
            url: `/video/dust`,
            method: 'get',
            params: data
        })
    }
    return axios({
        url: `/video/dust?page=${page}&pagesize=${pagesize}`,
        method: 'get',
    })
}