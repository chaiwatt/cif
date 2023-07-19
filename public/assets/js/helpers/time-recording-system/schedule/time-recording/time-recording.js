import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('click', '#search_work_schedule', function (e) {
    e.preventDefault();
    var selectedYear = $('#year').val();
    var selectedMonth = $('#month').val();
    var searchUrl = window.params.searchRoute;

    console.log(selectedMonth)
    var dataSet = {
        'selectedYear': selectedYear,
        'selectedMonth': selectedMonth
    }

    RequestApi.postRequest(dataSet, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })


});