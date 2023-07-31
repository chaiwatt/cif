import * as RequestApi from '../../../request-api.js';

var token = window.params.token

var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(document).on('click', '#show_modal', function (e) {
    $('#modal-date-range').modal('show');
    // var todayDate = moment().format('DD/MM/YYYY');
    // var startDateVal = $('#startDate').val().trim();
    // var endDateVal = $('#endDate').val().trim();
    // if (startDateVal === '') {
    //     $('#startDate').val(todayDate);
    // }

    // if (endDateVal === '') {
    //     $('#endDate').val(todayDate);
    // }
});

$(document).on('click', '#check-time-record', function (e) {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var monthId = $('#month_id').val();
    var workScheduleId = $('#work_schedule_id').val();
    var year = $('#year').val();
    var timeRecordCheckUrl = window.params.timeRecordCheckRoute
    if (startDate.trim() === '' || endDate.trim() === '') {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดกำหนดช่วงเวลา',
            'error'
        );
        return;
    }
    if (!isEndDateAfterStartDate(startDate, endDate)) {
        Swal.fire(
            'ผิดพลาด!',
            'โปรดกำหนดช่วงเวลาให้ถูกต้อง',
            'error'
        );
        return;
    }

    var data = {
        'startDate': startDate,
        'endDate': endDate,
        'monthId': monthId,
        'workScheduleId': workScheduleId,
        'year': year,
    }

    RequestApi.postRequest(data, timeRecordCheckUrl, token).then(response => {
        $('#table_container').html(response);
        $('#modal-date-range').modal('hide');
    }).catch(error => {

    })
});

$(document).on('click', '#user', function (e) {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var monthId = $('#month_id').val();
    var workScheduleId = $('#work_schedule_id').val();
    var userId = $(this).data('id');
    var year = $('#year').val();
    var viewUserUrl = window.params.viewUserRoute;
    // var timeRecordCheckUrl = window.params.timeRecordCheckRoute
    // console.log(viewUserUrl);

    var data = {
        'startDate': startDate,
        'endDate': endDate,
        'monthId': monthId,
        'workScheduleId': workScheduleId,
        'year': year,
        'userId': userId,
    }
    RequestApi.postRequest(data, viewUserUrl, token).then(response => {
        $('#table_modal_container').html(response);
        
        $('#modal-user-time-record').modal('show');
    }).catch(error => {

    })

});

$(document).on('click', '.btnSaveBtn', function (e) {
    // Prevent the default click behavior (if necessary)
    e.preventDefault();

    // Get the corresponding row of the clicked button
    var row = $(this).closest('tr');

    // Get the ID of the row from the "data-id" attribute
    var workScheduleAssignmentUserId = row.data('id');

    // Find the input elements for time_in and time_out within the row
    var timeInInput = row.find('input[id^="time_in"]');
    var timeOutInput = row.find('input[id^="time_out"]');

    // Get the values of time_in and time_out
    var timeInValue = timeInInput.val();
    var timeOutValue = timeOutInput.val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var monthId = $('#month_id').val();
    var workScheduleId = $('#work_schedule_id').val();
    var year = $('#year').val();

    var updateUrl = window.params.updateRoute;


    var data = {
        'timeInValue': timeInValue,
        'timeOutValue': timeOutValue,
        'workScheduleAssignmentUserId': workScheduleAssignmentUserId,
        'startDate': startDate,
        'endDate': endDate,
        'monthId': monthId,
        'workScheduleId': workScheduleId,
        'year': year,
    }

    RequestApi.postRequest(data, updateUrl, token).then(response => {
        $('#table_container').html(response);
        $('#error_' + workScheduleAssignmentUserId).hide();
        Toast.fire({
            icon: 'success',
            title: 'แก้ไขรายการสำเร็จ เวลาเข้า ' + timeInValue + ' เวลาออก ' + timeOutValue
        })
    }).catch(error => {

    })

    // You can perform any additional actions with the retrieved values here
});


$(document).on('click', '#add_note', function (e) {
    $('#modal-add-note').modal('show');
});

// Attach an event listener for the checkbox change
$(document).on('change', '#auto_text', function (e) {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var dateRangeMessage = '';
    if (startDate != '' && endDate != '')
    {
        dateRangeMessage = ' (' + startDate + ' - ' + endDate  + ')'
    }
    if ($('#auto_text').prop('checked')) {
        // Set the message in the textarea
        $('#note').val('ตรวจแล้ว' + dateRangeMessage);
    } else {
        // If checkbox is unchecked, clear the textarea
        $('#note').val('');
    }
});

$(document).on('click', '#save_note', function (e) {
    var monthId = $('#month_id').val();
    var workScheduleId = $('#work_schedule_id').val();
    var year = $('#year').val();
    var note = $('#note').val();
    var saveNoteUrl = window.params.saveNoteRoute;

    var data = {
        'note': note,
        'monthId': monthId,
        'workScheduleId': workScheduleId,
        'year': year,
    }
    RequestApi.postRequest(data, saveNoteUrl, token).then(response => {
        $('#modal-add-note').modal('hide');
    }).catch(error => {

    })

});

function isEndDateAfterStartDate(startDate, endDate) {
    var parsedStartDate = moment(startDate, 'DD/MM/YYYY', true); // Parse start date
    var parsedEndDate = moment(endDate, 'DD/MM/YYYY', true); // Parse end date

    if (!parsedStartDate.isValid() || !parsedEndDate.isValid()) {
        // Handle the case when either start date or end date is not a valid date
        return false;
    }

    if (parsedEndDate.isBefore(parsedStartDate)) {
        // Handle the case when endDate is before startDate
        return false;
    }

    return true;
}


