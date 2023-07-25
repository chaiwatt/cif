import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('click', '#show_modal', function (e) {
    $('#modal-date-range').modal('show');
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
    }).catch(error => {

    })

    // You can perform any additional actions with the retrieved values here
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


