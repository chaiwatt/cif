import * as RequestApi from '../../../request-api.js';

var token = window.params.token
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var searchUrl = window.params.searchRoute

    var data = {
        'searchInput': searchInput
    }
    RequestApi.postRequest(data, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/salary-system/salary/calculation-bonus-list/assignment/search?page=" + page
    var data = {
        'searchInput': searchInput
    }

    RequestApi.postRequest(data, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '#import-employee-code', function (e) {
    e.preventDefault();
    $('#modal-import-employee-code').modal('show');
});

$(document).on('click', '#btn-import-employee-code', function (e) {
    e.preventDefault();
    var textareaContent = $('#employee-code').val(); // Get the content of the textarea
    var lines = textareaContent.split('\n'); // Split content by new lines
    var bonusId = $('#bonusId').val();
    var importUrl = window.params.importRoute
    // Clear previous output

    if (textareaContent.trim() === '') {
        return; // If the content is empty or only whitespace, return
    }
    
    var employeeNos = [];
    for (var i = 0; i < lines.length; i++) {
        var trimmedLine = lines[i].trim();
        if (trimmedLine !== "") {
            if (trimmedLine.includes('-')) {
                var parts = trimmedLine.split('-');
                var employeeNo = parts[0].trim();
                var afterHyphen = parts[1].trim();

                afterHyphen = afterHyphen.replace(/[^\d.]/g, '');

                if (/^\d+(\.\d+)?$/.test(afterHyphen)) {
                    employeeNos.push(employeeNo + '-' + afterHyphen);
                } else {
                    Swal.fire(
                        'ผิดพลาด!',
                        'รูปแบบข้อมูลไม่ถูกต้องสำหรับ ' + lines[i].trim(),
                        'error'
                    );
                    return; // Return if any line is incorrectly formatted
                }
            } else {
                Swal.fire(
                    'ผิดพลาด!',
                    'รูปแบบข้อมูลไม่ถูกต้องสำหรับ ' + lines[i].trim(),
                    'error'
                );
                return; // Return if any line is incorrectly formatted
            }
        }
    }

    var data = {
        'employeeNos': employeeNos,
        'bonusId': bonusId
    }

    RequestApi.postRequest(data, importUrl, token).then(response => {
        $('#table_container').html(response);
        $('#modal-import-employee-code').modal('hide');
    }).catch(error => { })

});

$(document).on('change', '.bonus', function (e) {
    e.preventDefault();
    var bonusUserId = $(this).data('id');
    var cost = $(this).val();
    var updateBonusUrl = window.params.updateBonusRoute

     var data = {
        'bonusUserId': bonusUserId,
        'cost': cost,
        
    }

    RequestApi.postRequest(data, updateBonusUrl, token).then(response => {
        $('#table_container').html(response);
        Toast.fire({
            icon: 'success',
            title: 'แก้ไขโบนัสสำเร็จ '
        })
    }).catch(error => { })

});

$(document).on('click', '.delete', function (e) {
    e.preventDefault();
    var bonusUserId = $(this).data('id');
    var deleteUrl = window.params.deleteRoute

     var data = {
        'bonusUserId': bonusUserId,     
    }

    RequestApi.postRequest(data, deleteUrl, token).then(response => {
        $('#table_container').html(response);
        Toast.fire({
            icon: 'success',
            title: 'ลบโบนัสสำเร็จ '
        })
    }).catch(error => { })

});