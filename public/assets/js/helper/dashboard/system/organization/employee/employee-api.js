function searchUser(searchQuery) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: window.params.searchRoute,
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

export { searchUser }