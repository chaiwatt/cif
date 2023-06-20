function getModuleJson(groupId, roleId, getModuleJsonRoute) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: getModuleJsonRoute,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
            },
            data: {
                group_id: groupId,
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

function updateModuleJson(groupId, roleId, updateModuleJsonRoute, jsonData) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: updateModuleJsonRoute,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.params.token
            },
            data: {
                group_id: groupId,
                role_id: roleId,
                json_data: jsonData,
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

export { getModuleJson, updateModuleJson }