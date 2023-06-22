function searchUser(searchQuery, url, approverId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
            },
            data: {
                searchInput: searchQuery,
                approverId: approverId
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

export { searchUser }