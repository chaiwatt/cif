function getUsers() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: window.params.getUserRoute,
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

function storeUserToRole(userIds, roleId) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: window.params.assignUserToRoleRoute,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
            },
            data: {
                user_ids: userIds,
                role_id: roleId
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

export { getUsers, storeUserToRole }