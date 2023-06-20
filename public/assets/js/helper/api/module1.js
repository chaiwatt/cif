function getTask1(route) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${route.url}/api/module1/gettask1`,
            type: 'GET',
            headers: { "X-CSRF-TOKEN": route.token },
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

function creatTask1(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${route.url}/api/fulltbp/finishonsite`,
            type: 'POST',
            headers: { "X-CSRF-TOKEN": route.token },
            data: {
                id: id
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

function editTask1(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `${route.url}/api/fulltbp/finishonsite`,
            type: 'POST',
            headers: { "X-CSRF-TOKEN": route.token },
            data: {
                id: id
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

export { getTask1, creatTask1, editTask1 }