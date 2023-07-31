import * as RequestApi from '../../request-api.js';

var token = window.params.token


$(document).on('click', '.approve_leave', function (e) {
    e.preventDefault();
    var name = $(this).data('name');
    var userId = $(this).data('user_id');
    var leaveId = $(this).data('id');

    var leaveApprovalUrl = window.params.leaveApprovalRoute
    Swal.fire({
        icon: 'question',
        title: 'อนุมัติหการลา?',
        text: 'ต้องการอนุมัติการลา ' + name + ' หรือไม่',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'อนุมัติ',
        denyButtonText: 'ไม่อนุมัติ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var data = {
                'leaveId': leaveId,
                'value': 1,
                'userId': userId
            }
            RequestApi.postRequest(data, leaveApprovalUrl, token).then(response => {
                var errorFound = response['error'];
                if (errorFound) {
                    // Handle the error here, e.g., display an alert with the error message
                    Swal.fire(
                        'ผิดพลาด!',
                        'คุณไม่ได้รับอนุญาติให้ทำรายการ',
                        'error'
                    );
                } else {
                    // If no error, update the #table_container element with the response
                    $('#table_container').html(response);
                }
            }).catch(error => {
            })
        } else if (result.isDenied) {
            var data = {
                'leaveId': leaveId,
                'value': 2,
                'userId': userId
            }
            RequestApi.postRequest(data, leaveApprovalUrl, token).then(response => {
                var errorFound = response['error'];
                if (errorFound) {
                    // Handle the error here, e.g., display an alert with the error message
                    Swal.fire(
                        'ผิดพลาด!',
                        'คุณไม่ได้รับอนุญาติให้ทำรายการ',
                        'error'
                    );
                } else {
                    // If no error, update the #table_container element with the response
                    $('#table_container').html(response);
                }
            }).catch(error => {
            })
            
        }
    })

});

$(document).on('click', '#search_leave', function (e) {
    e.preventDefault();
    
    var selectedCompanyDepartment = $('#companyDepartment').val();
    var month = $('#month').val();
    var year = $('#year').val();
    var search_string = $('#search_string').val();
    var searchUrl = window.params.searchRoute

    var data = {
        'selectedCompanyDepartment': selectedCompanyDepartment,
        'month': month,
        'year': year,
        'searchString': search_string,
    }
    RequestApi.postRequest(data, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {
    })

});
