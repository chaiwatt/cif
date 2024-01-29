import * as RequestApi from '../../request-api.js';

var token = window.params.token
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});


$(document).on('click', '.approve_overtime', function (e) {
    e.preventDefault();
    var name = $(this).data('name');
    var userId = $(this).data('user_id');
    var overtimeId = $(this).data('id');
    var approverId = $(this).data('approver_id');
    var selectedCompanyDepartment = $('#companyDepartment').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var search_string = $('#search_string').val();
    
    var overtimeApprovalUrl = window.params.overtimeApprovalRoute
    Swal.fire({
        icon: 'question',
        title: 'อนุมัติล่วงเวลา?',
        text: 'ต้องสายอนุมัติล่วงเวลา ' + name + ' หรือไม่',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'อนุมัติ',
        denyButtonText: 'ไม่อนุมัติ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var data = {
                'overtimeId': overtimeId,
                'value': 1,
                'userId': userId,
                'approverId': approverId,
                'selectedCompanyDepartment': selectedCompanyDepartment,
                'startDate': startDate,
                'endDate': endDate,
                'searchString': search_string,
            }
            RequestApi.postRequest(data, overtimeApprovalUrl, token).then(response => {
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
                    Toast.fire({
                        icon: 'success',
                        title: 'อนุมัติสำเร็จ '
                    })
                    $('#table_container').html(response);
                }
            }).catch(error => {
            })
        } else if (result.isDenied) {
            var data = {
                'overtimeId': overtimeId,
                'value': 2,
                'userId': userId,
                'approverId': approverId,
                'selectedCompanyDepartment': selectedCompanyDepartment,
                'startDate': startDate,
                'endDate': endDate,
                'searchString': search_string,
            }
            RequestApi.postRequest(data, overtimeApprovalUrl, token).then(response => {
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
                    Toast.fire({
                        icon: 'success',
                        title: 'อนุมัติสำเร็จ '
                    })
                    $('#table_container').html(response);
                }
            }).catch(error => {
            })
            
        }
    })

});

$(document).on('click', '#search_overtime', function (e) {
    e.preventDefault();
    
    var companyDepartmentId = $('#companyDepartment').val();
    var month = $('#month').val();
    var year = $('#year').val();
    // var search_string = $('#search_string').val();
    var searchUrl = window.params.searchRoute

    var data = {
        'month': month,
        'year': year,
        'companyDepartmentId': companyDepartmentId,
        // 'searchString': search_string,
    }
    RequestApi.postRequest(data, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {
    })

});

