import * as RequestApi from '../../request-api.js';

var token = window.params.token

$(document).on('click', '#leave_check', function (e) {
    e.preventDefault();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var userId = $('#user').val();
    var leaveType = $('#leaveType').val();
    var haftDayLeave = $('#haftDayLeave').val();
    var haftDayLeaveType = $('#haftDayLeaveType').val();

    var diffInDays = moment(endDate, 'DD/MM/YYYY').diff(moment(startDate, 'DD/MM/YYYY'), 'days');
    if (diffInDays < 0) {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดกำหนดวันที่ให้ถูกต้อง',
            'error'
        );
        return;
    } else if (diffInDays > 0){
        if (haftDayLeave === '1' && haftDayLeaveType == 2) {
            Swal.fire(
                'ผิดพลาด!',
                'ไม่สามารถเลือกครึ่งวันหลัง',
                'error'
            );
            return;
        } 
    }

    if (!startDate || !endDate || !userId || !leaveType) {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดกรอกข้อมูลให้ครบ',
            'error'
        );
        return;
    }

    if (haftDayLeave === '1' && !haftDayLeaveType) {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดเลือกประเภทครึ่งวันแรก / หลัง',
            'error'
        );
        return;
    }

    var data = {
        'startDate': startDate,
        'endDate': endDate,
        'userId': userId,
        'leaveType': leaveType,
        'haftDayLeave': haftDayLeave,
        'haftDayLeaveType': haftDayLeaveType
    }
    var checkLeaveUrl = window.params.checkLeaveRoute

    RequestApi.postRequest(data, checkLeaveUrl, token).then(response => {
        $('#modal_container').html(response);
        $('#modal-leave-info').modal('show');
    }).catch(error => {

    })

});


$(document).on('click', '#save_leave', function (e) {
    e.preventDefault();
    var leaveId = $('#leaveId').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var userId = $('#user').val();
    var leaveType = $('#leaveType').val();
    var haftDayLeave = $('#haftDayLeave').val();
    var haftDayLeaveType = $('#haftDayLeaveType').val();

    var data = {
        'startDate': startDate,
        'endDate': endDate,
        'userId': userId,
        'leaveType': leaveType,
        'haftDayLeave': haftDayLeave,
        'haftDayLeaveType': haftDayLeaveType,
        'leaveId': leaveId
    }

    var storeUrl = window.params.storeRoute
    RequestApi.postRequest(data, storeUrl, token).then(response => {
        $('#modal-leave-info').modal('hide');
        var url = window.params.url + '/groups/document-system/leave/document'
        window.location.href = url; // Redirect to the generated URL
    }).catch(error => {

    })

});
