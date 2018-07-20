import axios from "../utils/request"

export function buildType(){
    return axios ({
        url: "/json/BuildType.json",
        method: 'get'
    })
}
export function invest(){
    return axios ({
        url: "/json/Invest.json",
        method: 'get'
    })
}
export function itemcategory(){
    return axios ({
        url: "/json/ItemCategory.json",
        method: 'get'
    })
}
export function structuraltype(){
    return axios ({
        url: "/json/StructuralType.json",
        method: 'get'
    })
}
export function citys(){
    return axios({
        url: "/json/citys.json",
        method: 'get'
    })
}