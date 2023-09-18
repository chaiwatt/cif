import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var searchUrl = window.params.searchRoute

    var data = {
        'searchInput': searchInput
    }
    RequestApi.postRequest(data, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/salary-system/salary/calculation/search?page=" + page
    var data = {
        'searchInput': searchInput
    }

    RequestApi.postRequest(data, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});