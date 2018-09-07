import axios from '../utils/request'

export function getUtypes() {
    return axios({
        url: '/utype/searchoption',
        method: 'get'
    })
}

export function getUnits(page,data={}, pagesize=10) {
    if (Object.keys(data).length > 0) {
        Object.assign(data, {page, pagesize});
        return axios({
            url: `/unit`,
            method: 'get',
            params: data
        })
    }
    return axios({
        url: `/unit?page=${page}&pagesize=${pagesize}`,
        method: 'get',
    })
}

export function editUnit(id) {
    return axios({
        url: `/unit/${id}/edit`,
        method: 'get'
    })
}

export function findUnit(id) {
    return axios({
        url: `/unit/${id}/find`,
        method: 'get'
    })
}

export function updateUnit(id, data) {
    return axios({
        url: `/unit/${id}`,
        method: 'put',
        data: data
    })
}

export function storeUnit(data, pagesize) {
    data.pagesize = pagesize
    return axios({
        url: `/unit`,
        method: 'post',
        data: data
    })
}

export function destroyUnit(data, page, pagesize) {
    data.page = page
    data.pagesize = pagesize
    return axios({
        url: `/unit`,
        method: 'delete',
        data: data
    })
}

export function exportSelection(id) {
    return axios({
        url: `/unit/export`,
        method: 'post',
        data: { id }
    })
}

export function importExcel(data) {
    if (typeof data.finalExcelData !== "undefined") {
        const {finalExcelData, pagesize} = data
        return axios({
            url: `/unit/import`,
            method: 'post',
            data: {finalExcelData, pagesize}
        })
    } else {
        return axios({
            url: `/unit/import`,
            method: 'post',
            data: data
        })
    }
    
}