import * as RequestApi from '../../../../request-api.js';

var token = window.params.token

$(document).on('click', '#btn-search', function () {
    var searchInput = $('#search_query').val();
    var searchUrl = window.params.searchRoute
    var paydayDetailId = $('#paydayDetailId').val();
    var data = {
        'searchInput': searchInput,
        'paydayDetailId': paydayDetailId
    }

    RequestApi.postRequest(data, searchUrl, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/groups/salary-system/salary/calculation-list/summary/search?page=" + page
    var paydayDetailId = $('#paydayDetailId').val();
    var data = {
        'searchInput': searchInput,
        'paydayDetailId': paydayDetailId
    }

    RequestApi.postRequest(data, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});


