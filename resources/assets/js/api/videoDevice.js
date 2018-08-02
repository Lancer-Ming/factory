import axios from '../utils/request'
import { apiUrl } from '../config/common'

export function addDevice(data){
  return axios({
      url: `${apiUrl}/api/lapp/device/add`,
      method: 'post',
      data: data
  })

}


export function addDeviceTolocal(data) {
    return axios({
        url: `/video_device`,
        method: 'post',
        data: data
    })
}

export function getAccessToken(data){
    let url = 'https://open.ys7.com/api/lapp/token/get'
    return axios({
        url: 'access_token/get',
        method: 'post',
        data: { url, data }
    })

}
