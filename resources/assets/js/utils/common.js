/**
 * 取出数组里很多对象的某个字段
 * @param arr
 * @param attr
 * @returns {Array}
 */
export function implode(arr, attr) {
    let result = []
  
    arr.forEach(element => {
        result.push(element[attr])
    });
   
    return result
}

/**
 * 对localStorage的封装
 */
export function Local() {
    this.set = (key, value='') => {
        localStorage.setItem(key, JSON.stringify(value))
    }
    this.get = (key) => {
        return JSON.parse(localStorage.getItem(key))
    }
    this.remove = (key) => {
        localStorage.removeItem(key)
    }
    this.clear = () => {
        localStorage.clear()
    }
}


// export const findChildRecursion = function(obj) {
//     let ids = []
    
//     function findChildRecursion (obj) {
    
//         if (obj.children.length === 0) {
//             return
//         } else {
//             obj.children.forEach(item => {
//                 ids.push(item.id)
//                 findChildRecursion(item)
//             })
//         }
        
//         return ids
    
//     }

//     return findChildRecursion(obj)

// }

/**
 * 找菜单对应下面的children
 */
export class FindChildren {
    constructor(ids) {
        this.ids = ids
    }

    childRecursion (obj) {
        if (typeof obj.children !== 'undefined') {
            if (obj.children.length === 0) {
                return
            } else {
                obj.children.forEach(item => {
                    this.ids.push(item.id)
                    this.childRecursion(item)
                })
            }
            
            return this.ids
        } else {
            return
        }
        
    
    }
}

/**
 * 找所有的父级
 */
export class UnfoldAll{
    constructor(){
        this.parents = []
        this.parentsId = []
    }

    parentRecursion (arr){
            if(arr.length === 0){
                return
            }
            else{
               arr.forEach(item =>{
                   this.parents[item.id] = item.parent_id
                   if(typeof item.children !== 'undefined'){
                        this.parentRecursion(item.children)
                   }
                   else{
                       return
                   }
               })
            }
            return this.parents
    }

    findParent(id,parents){
        if(parents[id] === 0){
            return
        }
        else{
            this.parentsId.push(parents[id])
            this.findParent(parents[id], parents)
        }
        return this.parentsId
    }
}

/**
 * 将省市区代号解析为地址
 * @param {*} addresses 
 * @param {*} province_code 
 * @param {*} city_code 
 * @param {*} county_code 
 */
export function decodeAddress(addresses, province_code, city_code, county_code) {
    let result = []
    addresses.forEach(item => {
        if (item.value === province_code) {
            result.push(item.label)
            item.children.forEach(citem => {
                if (citem.value === city_code) {
                    result.push(citem.label)
                    citem.children.forEach(ccitem => {
                        if (ccitem.value === county_code) {
                            result.push(ccitem.label)
                        }
                    })
                }
            })
        }
    })

    return result
}

export function encodeAddress(addresses, province, city, county) {
    let result = []
    addresses.forEach(item => {
        if (item.label === province) {
            result.push(item.value)
            item.children.forEach(citem => {
                if (citem.label === city) {
                    result.push(citem.value)
                    citem.children.forEach(ccitem => {
                        if (ccitem.label === county) {
                            result.push(ccitem.value)
                        }
                    })
                }
            })
        }
    })

    return result
}

/**
 * 将对象数组，转化为一个二维数组，用于excel的导出
 * @param {*} filterVal 
 * @param {*} jsonData 
 */
export function formatJson(filterVal, jsonData) {
    return jsonData.map(v => filterVal.map(j => {
        return v[j]
    }))
  }