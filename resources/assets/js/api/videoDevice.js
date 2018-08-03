import axios from '../utils/request'
import { apiUrl } from '../config/common'

export function addDeviceTolocal(data) {
    return axios({
        url: `/video_device`,
        method: 'post',
        data: data
    })
}

export function getAccessToken(data){
    let url = `${apiUrl}/api/lapp/token/get`
    return axios({
        url: 'api/access_token/get',
        method: 'post',
        data: { url, data }
    })
}

export function autoGetAccessToken(data) {
    return axios({
        url: '/user/access_token/get',
        method: 'post',
        data: data
    })
}
