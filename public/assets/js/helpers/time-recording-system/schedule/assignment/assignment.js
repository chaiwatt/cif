import * as RequestApi from '../../../request-api.js';

var token = window.params.token
const url = window.location.href;
const segments = url.split('/');
var workScheduleId = segments[segments.length - 5];
var year = segments[segments.length - 3];
var month = segments[segments.length - 1];
checkIfExpired(year, month);

$(document).on('change', '#select_all', function (e) {
    $('.user-checkbox').prop('checked', this.checked);
});

$(document).on('change', '.user-checkbox', function (e) {    
    if ($('.user-checkbox:checked').length == $('.user-checkbox').length) {
        $('#select_all').prop('checked', true);
    } else {
        $('#select_all').prop('checked', false);
    }
});

$(document).on('click', '#import_for_all', function (e) {
    $('#file-input').trigger('click');
});

function checkIfExpired(year, month) {
    // Get the current year and month using Moment.js
    var currentDate = moment();
    var currentYear = currentDate.year();
    var currentMonth = currentDate.month() + 1; // Note: Month is zero-indexed in Moment.js
    // Compare the year and month with the current year and month

    if ((parseInt(year) === parseInt(currentYear) && parseInt(month) < parseInt(currentMonth))) {
        $('#add_user_wrapper').hide();
        $('#expire_message').text('(หมดเวลา)');
    }
}
