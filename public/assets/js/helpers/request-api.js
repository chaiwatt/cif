function postRequest(dataSet, url, token) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {
                data: dataSet
            },
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

function postRequestFormData(formData, url, token) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

function getRequest(url) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

function deleteRequest(url, token) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token
            },
            
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

export { postRequest, getRequest, deleteRequest, postRequestFormData }