import * as RequestApi from '../../request-api.js';

var token = window.params.token
var selectedFile;

$(document).on('click', '#leave_check', function (e) {
    e.preventDefault();
    var userId = $('#user').val();
    var leaveType = $('#leaveType').val();

    var [startDate, startTime] = $('#startDate').val().split(' ');
    var [endDate, endTime] = $('#endDate').val().split(' ');

    var startDateTime = moment(startDate + ' ' + startTime, 'DD/MM/YYYY HH:mm');
    var endDateTime = moment(endDate + ' ' + endTime, 'DD/MM/YYYY HH:mm');

    if (!startDateTime.isValid() || !endDateTime.isValid()) {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดกำหนดวันที่และเวลาให้ถูกต้อง',
            'error'
        );
        return;
    }

    var diffInDays = endDateTime.diff(startDateTime, 'days');

    if (diffInDays < 0) {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดกำหนดวันที่และเวลาให้ถูกต้อง',
            'error'
        );
        return;
    }
    var data = {
        'startDate': startDate,
        'startTime': startTime,
        'endDate': endDate,
        'endTime': endTime,
        'userId': userId,
        'leaveType': leaveType,
    }
    var checkLeaveUrl = window.params.checkLeaveRoute

    RequestApi.postRequest(data, checkLeaveUrl, token).then(response => {
        // console.log(response);
        $('#modal_container').html(response);
        $('#modal-leave-info').modal('show');
    }).catch(error => {

    })

});

$(document).on('click', '#btnAddFile', function (e) {
    e.preventDefault();
    $('#file-input').trigger('click');
});
$(document).on('change', '#file-input', function (event) {
    var fileInput = event.target;
    selectedFile = fileInput.files[0];
    $('#fileName').text(selectedFile ? selectedFile.name : '');
});

$(document).on('click', '#save_leave', function (e) {
    e.preventDefault();
    var leaveId = $('#leaveId').val();
    var [startDate, startTime] = $('#startDate').val().split(' ');
    var [endDate, endTime] = $('#endDate').val().split(' ');
    var userId = $('#user').val();
    var leaveType = $('#leaveType').val();

    var formData = new FormData();
    formData.append('file', selectedFile);
    formData.append('startDate', startDate);
    formData.append('startTime', startTime);
    formData.append('endDate', endDate);
    formData.append('endTime', endTime);
    formData.append('userId', userId);
    formData.append('leaveType', leaveType);
    formData.append('leaveId', leaveId);

    var approverData = $('#approver').data('approver');

    if (approverData === null) {
        return;
    }

    // console.log(selectedFile)

    var storeUrl = window.params.storeRoute
    RequestApi.postRequestFormData(formData, storeUrl, token).then(response => {
        
        if (response.error != null) {
            console.log(response);
            Swal.fire(
                'ผิดพลาด!',
                response.error,
                'error'
            );
            return;
        }
        $('#modal-leave-info').modal('hide');
        var url = window.params.url + '/groups/document-system/leave/document'
        window.location.href = url; // Redirect to the generated URL
    }).catch(error => {

    })

});

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var url = window.params.searchRoute
    RequestApi.postRequest(searchInput, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/document-system/leave/document/search?page=" + page
    

    RequestApi.postRequest(searchInput, url, token).then(response => {
        console.log(response);
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.show-attachment', function (e) {
    e.preventDefault();
    var leaveId = $(this).data('id');
    var getAttachmentUrl = window.params.getAttachmentRoute
    
    var data = {
        'leaveId': leaveId
    }
    RequestApi.postRequest(data, getAttachmentUrl, token).then(response => {
        var imageUrl = response.attachment;
        var baseUrl = window.location.origin; 
        var fullImageUrl = baseUrl + '/storage/uploads/attachment/' + imageUrl;
        $('#modal-attachment').modal('show');
        $('#modal-attachment img').attr('src', fullImageUrl);
    }).catch(error => { })
});

