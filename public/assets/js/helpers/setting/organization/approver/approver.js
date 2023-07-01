import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('keyup', 'input[name="search_query"]', function () {
    var approverId = $('#approverId').val();
    var searchInput = $(this).val();
    var url = window.params.searchRoute
    var dataSet = {
        'searchInput': searchInput,
        'approverId': approverId
    }
    RequestApi.postRequest(dataSet, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {})
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var approverId = $('#approverId').val();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/setting/organization/approver/assignment/search?page=" + page

    var dataSet = {
        'searchInput': searchInput,
        'approverId': approverId
    }

    RequestApi.postRequest(dataSet, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => {})
});
