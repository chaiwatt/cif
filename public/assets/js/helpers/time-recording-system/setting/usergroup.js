import * as RequestApi from '../../request-api.js';

var token = window.params.token
const url = window.location.href;

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

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var url = window.params.searchRoute
    
    RequestApi.postRequest(searchInput, url, token).then(response => {
        console.log(response);
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/time-recording-system/setting/employee-group/assignment/search?page=" + page

    RequestApi.postRequest(searchInput, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});
