import * as RequestApi from '../../../request-api.js';

var token = window.params.token
const url = window.location.href;
const segments = url.split('/');
var workScheduleId = segments[segments.length - 5];
var year = segments[segments.length - 3];
var month = segments[segments.length - 1];
console.log(workScheduleId + ' ' + year + ' ' + month);

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var searchUrl = window.params.searchRoute
    RequestApi.postRequest(searchInput, searchUrl, token).then(response => {
        console.log(response);
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/time-recording-system/schedulework/schedule/assignment/search?page=" + page
    RequestApi.postRequest(searchInput, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});
