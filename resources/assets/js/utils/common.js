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

