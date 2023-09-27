import * as RequestApi from '../../../../request-api.js';

var token = window.params.token
const url = window.location.href;

$(document).on('click', '#import-employee-code', function (e) {
    e.preventDefault();
    $('#modal-import-employee-code').modal('show');
});

$(document).on('click', '#btn-import-employee-code', function (e) {
    e.preventDefault();
    var textareaContent = $('#employee-code').val(); // Get the content of the textarea
    var lines = textareaContent.split('\n'); // Split content by new lines

    var importEmployeeNoUrl = window.params.importEmployeeNoRoute
    var paydayId = $('#paydayId').val();

    if (textareaContent.trim() === '') {
        return; // If the content is empty or only whitespace, return
    }
    
    $('#output').empty();
    var employeeNos = [];
    for (var i = 0; i < lines.length; i++) {
        var trimmedLine = lines[i].trim(); // Remove leading and trailing spaces
        if (trimmedLine !== "") {
            employeeNos.push(trimmedLine);
        }
    }

    var data = {
        'employeeNos': employeeNos,
        'paydayId': paydayId
    }

    RequestApi.postRequest(data, importEmployeeNoUrl, token).then(response => {
        window.location.reload();
    }).catch(error => { })

});

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchInput = $(this).val();
    var url = window.params.searchRoute
    var paydayId = $('#paydayId').val();

    var data = {
        'searchInput': searchInput,
        'paydayId': paydayId
    }

    RequestApi.postRequest(data, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchInput = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var paydayId = $('#paydayId').val();
    var url = "/groups/salary-system/setting/payday/assignment-user/search?page=" + page

    var data = {
        'searchInput': searchInput,
        'paydayId': paydayId
    }

    RequestApi.postRequest(data, url, token).then(response => {
        $('#table_container').html(response);
    }).catch(error => { })
});

