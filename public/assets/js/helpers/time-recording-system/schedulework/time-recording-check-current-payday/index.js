import * as RequestApi from '../../../request-api.js';

var token = window.params.token
const url = window.location.href;

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var searchUrl = window.params.searchRoute
    var filter = $('.btn-group-toggle input[type="radio"]:checked').attr('id').split('_')[1];

    var data = {
        'searchInput': searchInput,
        'filter': filter,
    }
    RequestApi.postRequest(data, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var filter = $('.btn-group-toggle input[type="radio"]:checked').attr('id').split('_')[1];
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/time-recording-system/schedulework/time-recording-check-current-payday/search?page=" + page
    var data = {
        'searchInput': searchInput,
        'filter': filter,
    }
    console.log(data);
    RequestApi.postRequest(data, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$('.btn-group-toggle input[type="radio"]').on('change', function () {
    var filter = $(this).attr('id').split('_')[1];
    var searchInput = $('#search_query').val();
    var searchUrl = window.params.searchRoute
    var data = {
        'searchInput': searchInput,
        'filter': filter
    };
    console.log(data);
    var searchUrl = window.params.searchRoute;

    RequestApi.postRequest(data, searchUrl, token).then(response => {
            $('#table_container').html(response);
        })
        .catch(error => {});
});

$(document).on('click', '#user', function (e) {
    var startDate = $(this).data('startdate');
    var endDate = $(this).data('enddate');
    // var monthId = $('#month_id').val();
    // var workScheduleId = $('#work_schedule_id').val();
    var userId = $(this).data('id');
    // var year = $('#year').val();
    var viewUserUrl = window.params.viewUserRoute;
    // var timeRecordCheckUrl = window.params.timeRecordCheckRoute
    

    var data = {
        'startDate': startDate,
        'endDate': endDate,
        'userId': userId,
    }
 
    RequestApi.postRequest(data, viewUserUrl, token).then(response => {
        $('#table_modal_container').html(response);
        $('#startDate').val(startDate);
        $('#endDate').val(endDate);
        $('.input-time-format').inputmask('99:99:99');
        $('#modal-user-time-record').modal('show');
    }).catch(error => {

    })

});

$(document).on('click', '.btnSaveBtn', function (e) {
    e.preventDefault();
    var filter = $('.btn-group-toggle input[type="radio"]:checked').attr('id').split('_')[1];
    var searchInput = $('#search_query').val();

    var row = $(this).closest('tr');
    var workScheduleAssignmentUserId = row.data('id');
    var timeInInput = row.find('input[id^="time_in"]');
    var timeOutInput = row.find('input[id^="time_out"]');
    var timeInValue = timeInInput.val();
    var timeOutValue = timeOutInput.val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

    var updateUrl = window.params.updateRoute;

    var data = {
        'timeInValue': timeInValue,
        'timeOutValue': timeOutValue,
        'workScheduleAssignmentUserId': workScheduleAssignmentUserId,
        'startDate': startDate,
        'endDate': endDate,
        'filter': filter,
        'searchInput': searchInput
    }

    if (timeInValue === '' || timeOutValue === '') {
        Swal.fire(
            'ผิดพลาด!',
            'กรุณากรอกเวลาให้ครบ',
            'error'
        );
        return;
    }

    RequestApi.postRequest(data, updateUrl, token).then(response => {
        $('#table_container').html(response);
        $('#error_' + workScheduleAssignmentUserId).hide();
        // if (timeInValue === '' && timeOutValue === '') {
        //     var timeInInput = row.find('input[id^="time_in"]');
        //     var timeOutInput = row.find('input[id^="time_out"]');

        //     timeInInput.val('00:00:00');
        //     timeOutInput.val('00:00:00');
        // }
        Toast.fire({
            icon: 'success',
            title: 'แก้ไขรายการสำเร็จ เวลาเข้า ' + timeInValue + ' เวลาออก ' + timeOutValue
        })
    }).catch(error => {

    })

    // You can perform any additional actions with the retrieved values here
});

$(document).on('click', '.btnAttachment', function (e) {
    e.preventDefault();
    var workScheduleAssignmentId = $(this).data('id');
    var getImageUrl = window.params.getImageRoute;
    $('#workScheduleAssignmentUserId').val(workScheduleAssignmentId);

    var data = {
        'workScheduleAssignmentId': workScheduleAssignmentId
    }
    console.log(workScheduleAssignmentId)
    RequestApi.postRequest(data, getImageUrl, token).then(response => {
        var imageUrl = response.file;
        var baseUrl = window.location.origin; // Get the base URL of the application

        if (imageUrl) {
            var workScheduleAssignmentUserFileId = response.id;
            $('#workScheduleAssignmentUserFileId').val(workScheduleAssignmentUserFileId);
            // console.log(workScheduleAssignmentUserFileId)
            var fullImageUrl = baseUrl + '/storage/uploads/attachment/' + imageUrl;
            $('#modal-attachment').modal('show');
            $('#modal-attachment img').attr('src', fullImageUrl);
            $('#delete-image').attr('data-id', workScheduleAssignmentUserFileId);
            $('#delete-image').removeClass('d-none'); // Show the "ลบ" button
            $('#btnAddFile').addClass('d-none');
        } else {
            $('#modal-attachment').modal('show');
            $('#modal-attachment img').removeAttr('src');
        }
    }).catch(error => {

    })
});

$(document).on('click', '#btnAddFile', function (e) {
    e.preventDefault();
    $('#file-input').trigger('click');
});

$(document).on('change', '#file-input', function (event) {

    var fileInput = event.target;
    var uploadImageUrl = window.params.uploadImageRoute;
    var workScheduleAssignmentId = $('#workScheduleAssignmentUserId').val();

    var formData = new FormData();
    formData.append('file', fileInput.files[0]);
    formData.append('workScheduleAssignmentId', workScheduleAssignmentId);


    RequestApi.postRequestFormData(formData, uploadImageUrl, token).then(response => {
        var workScheduleAssignmentUserFileId = response.id;
        var imageUrl = response.file;
        var baseUrl = window.location.origin; // Get the base URL of the application
        $('#workScheduleAssignmentUserFileId').val(workScheduleAssignmentUserFileId);
        if (imageUrl) {
            var fullImageUrl = baseUrl + '/storage/uploads/attachment/' + imageUrl;
            $('#modal-attachment').modal('show');
            $('#modal-attachment img').attr('src', fullImageUrl);
            $('#delete-image').attr('data-id', workScheduleAssignmentUserFileId);
            $('#delete-image').removeClass('d-none'); // Show the "ลบ" button
            $('#btnAddFile').addClass('d-none'); // Show the "ลบ" button
        } else {
            $('#modal-attachment').modal('show');
            $('#modal-attachment img').removeAttr('src');

        }
        $('#file-input').val('');
    }).catch(error => {

    })
});

$(document).on('click', '#delete-image', function (e) {
    e.preventDefault();
    var workScheduleAssignmentUserFileId = $('#workScheduleAssignmentUserFileId').val();
    var deleteImageDelete = window.params.deleteImageRoute;

    var data = {
        'workScheduleAssignmentUserFileId': workScheduleAssignmentUserFileId
    }
    RequestApi.postRequest(data, deleteImageDelete, token).then(response => {
        $('#modal-attachment img').removeAttr('src');
        $('#delete-image').attr('data-id', '');
        $('#delete-image').addClass('d-none');
        $('#modal-attachment').modal('hide');
        $('#btnAddFile').removeClass('d-none');
    }).catch(error => {

    })
});

