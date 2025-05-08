
export async function getRequest(path) {
    return await fetch(path,{
        method: 'GET',
        credentials: 'include',
        headers: {
            'Accept': 'application/json'
        },
    });
}

export async function postRequest(path, xsrfToken, data) {
    return await fetch(path, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-XSRF-TOKEN': xsrfToken
        },
        body: JSON.stringify(data)
    });
}
// export async function fetchRequest(
//     path, method, input, stringify, headers = {}
// ) {
//     const body = stringify ? JSON.stringify(input) : input;
//
//     let options = {
//         method: method,
//         headers: headers,
//         body: body,
//         credentials: 'include'
//     }
//
//     if(Object.keys(headers).length > 0) {
//         options.headers = {
//             'Accept': 'application/json',
//             ...headers
//         }
//     }
//
//     return await fetch(path, options);
// }
