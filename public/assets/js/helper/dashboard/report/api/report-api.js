function searchUser(searchQuery,url) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
            },
            data: {
                searchInput: searchQuery
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

function getReportField(url) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
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

function updateReportField(updateReportFields, url) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
            },
            data: {
                updateReportFields: updateReportFields
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


export { searchUser, getReportField, updateReportField }