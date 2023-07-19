import * as RequestApi from '../../../request-api.js';

var token = window.params.token
const url = window.location.href;
const segments = url.split('/');
var workScheduleId = segments[segments.length - 5];
var year = segments[segments.length - 3];
var month = segments[segments.length - 1];

checkIfExpired(year, month); // Example function call

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
    var url = "/groups/time-recording-system/schedulework/schedule/assignment/user/search?page=" + page

    RequestApi.postRequest(searchInput, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});


$(document).on('change', '#userGroup', function (e) {
    var selectedUserGroupId = $(this).val(); // Get the selected value
    var importUserGroupRoute = window.params.importUserGroupRoute
    if (selectedUserGroupId === '') {
        return; // Return or exit the function
    }
    var dataSet = {
        userGroupId: selectedUserGroupId,
        workScheduleId: workScheduleId,
        month: month,
        year : year
    }

    var selectedText = $(this).find('option:selected').text();
    Swal.fire({
        title: 'นำเข้าพนักงาน',
        text: 'นำเข้าพนักงานจากกลุ่ม' + selectedText,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '##6495ed',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'นำเข้า',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: importUserGroupRoute,
                type: 'POST',
                headers: {
                    "X-CSRF-TOKEN": token
                },
                data: dataSet,
                success: function (response) {
                    window.location.reload();
                },
                error: function (xhr) {

                }
            });
        }
    });

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
