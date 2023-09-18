import * as RequestApi from '../../../../request-api.js';

var token = window.params.token

$(document).on('click', '#import-employee-code', function (e) {
    e.preventDefault();
    $('#modal-import-employee-code').modal('show');
});

$(document).on('click', '#btn-import-employee-code', function (e) {
    e.preventDefault();
    var textareaContent = $('#employee-code').val(); // Get the content of the textarea
    var lines = textareaContent.split('\n'); // Split content by new lines
    var assessmentGroupId = $('#assessmentGroupId').val();
    var importUserGroupUrl = window.params.importUserGroupRoute

    if (textareaContent.trim() === '') {
        return; // If the content is empty or only whitespace, return
    }


    var employeeNos = [];
    for (var i = 0; i < lines.length; i++) {
        var trimmedLine = lines[i].trim(); // Remove leading and trailing spaces
        if (trimmedLine !== "") {
            employeeNos.push(trimmedLine);
        }
    }

    var data = {
        'employeeNos': employeeNos,
        'assessmentGroupId': assessmentGroupId
    }

    RequestApi.postRequest(data, importUserGroupUrl, token).then(response => {
        window.location.reload();
    }).catch(error => { })

});