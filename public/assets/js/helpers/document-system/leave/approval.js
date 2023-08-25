import * as RequestApi from '../../request-api.js';

var token = window.params.token


$(document).on('click', '.approve_leave', function (e) {
    e.preventDefault();
    var name = $(this).data('name');
    var userId = $(this).data('user_id');
    var leaveId = $(this).data('id');
    var approverId = $(this).data('approver_id');
    var selectedCompanyDepartment = $('#companyDepartment').val();
    var month = $('#month').val();
    var year = $('#year').val();
    var search_string = $('#search_string').val();
    // console.log(approverId);
    

    var leaveApprovalUrl = window.params.leaveApprovalRoute
    Swal.fire({
        icon: 'question',
        title: 'อนุมัติการลา?',
        text: 'ต้องสายอนุมัติการลา ' + name + ' หรือไม่',
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
                'userId': userId,
                'approverId': approverId,
                'selectedCompanyDepartment': selectedCompanyDepartment,
                'month': month,
                'year': year,
                'searchString': search_string,
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
                'userId': userId,
                'approverId': approverId,
                'selectedCompanyDepartment': selectedCompanyDepartment,
                'month': month,
                'year': year,
                'searchString': search_string,
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

// $(document).on('keyup', 'input[name="search_query"]', function () {
//     var searchInput = $(this).val();
//     var url = window.params.liveSearchRoute
//     RequestApi.postRequest(searchInput, url, token).then(response => {
//         $('#table_container').html(response);
//     }).catch(error => { })
// });

// $(document).on('click', '.pagination a', function (e) {
//     e.preventDefault();
//     var searchInput = $('#search_query').val();
//     var page = $(this).attr('href').split('page=')[1];
//     var url = "/groups/document-system/leave/approval/search?page=" + page


//     RequestApi.postRequest(searchInput, url, token).then(response => {
//         console.log(response);
//         $('#table_container').html(response);
//     }).catch(error => { })
// });

