export function implode(arr, attr) {
    let result = []
  
    arr.forEach(element => {
        result.push(element[attr])
    });
   
    return result
}