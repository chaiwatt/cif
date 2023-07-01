import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var searchUrl = window.params.searchRoute

    RequestApi.postRequest(searchInput, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })

});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/setting/report/log/search?page=" + page

    RequestApi.postRequest(searchInput, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});

