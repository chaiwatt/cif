import * as RequestApi from '../../request-api.js';

var token = window.params.token

$(document).on('change', '#year', function (e) {
    e.preventDefault();
    var searchInput = $(this).val();
    var searchUrl = window.params.searchRoute

    RequestApi.postRequest(searchInput, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});
