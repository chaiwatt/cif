import * as RequestApi from '../../../request-api.js';

var token = window.params.token

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
    var url = "/groups/salary-system/salary/income-deduct-assignment/search?page=" + page
    var data = {
        'searchInput': searchInput
    }

    RequestApi.postRequest(data, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});


$(document).on('click', '#btn-show-modal-income-deduct-assignment', function (e) {
    e.preventDefault();
    $('#employee-code').val('');
    $('#modal-income-deduct-assignment').modal('show');

});

$(document).on('click', '#btn-import-employee-code', function (e) {
    e.preventDefault();
    var textareaContent = $('#employee-code').val(); // Get the content of the textarea
    var lines = textareaContent.split('\n'); // Split content by new lines
    var incomeDeductId = $('#incomeDeduct').val();
    var storeUrl = window.params.storeRoute
    // Clear previous output

    if (!incomeDeductId) {
        return; // or alert('Please select a valid option');
    }

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

                // Remove non-numeric characters from the part after hyphen
                afterHyphen = afterHyphen.replace(/[^\d.]/g, '');

                // Check if the modified part after hyphen is a valid number
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
        'incomeDeductId': incomeDeductId
    }

    RequestApi.postRequest(data, storeUrl, token).then(response => {
        $('#table_container').html(response);
        $('#modal-income-deduct-assignment').modal('hide');
    }).catch(error => {})

});

$(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'ลบรายการ',
        text: 'ต้องการลบรายการหรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ยืนยันลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var deleteUrl = window.params.deleteRoute;
            var userId = $(this).data('id')
            var data = {
                'userId': userId,
            }
            RequestApi.postRequest(data, deleteUrl, token).then(response => {
                $('#table_container').html(response);
            }).catch(error => { })
        }
    });

});
