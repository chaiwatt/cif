function storeGroupToRole(selectedGroupIds, roleId, storeGroupRoute) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: storeGroupRoute,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
            },
            data: {
                group_ids: selectedGroupIds,
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

function deleteGroupInRole(deleteRoute) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: deleteRoute,
            type: 'DELETE',
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

function getGroup() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: window.params.getGroupRoute,
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

export { storeGroupToRole, deleteGroupInRole, getGroup }