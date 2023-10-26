import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('click', '#import-employee-code', function (e) {
    e.preventDefault();
    $('#modal-import-employee-code').modal('show');
});

$(document).on('click', '#btn-import-employee-code', function (e) {
    e.preventDefault();
    var textareaContent = $('#employee-code').val(); // Get the content of the textarea
    var lines = textareaContent.split('\n'); // Split content by new lines
    var approverId = $('#approverId').val();
    var importEmployeeNoUrl = window.params.importEmployeeNoRoute
    // Clear previous output

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
        'approverId': approverId
    }

    RequestApi.postRequest(data, importEmployeeNoUrl, token).then(response => {
        window.location.reload();
    }).catch(error => { })

});

$(document).on('change', '#company_department', function () {
    var company_department = $('#company_department').val();
    var selectedText = $(this).find('option:selected').text();
    var importEmployeeNoFromDeptUrl = window.params.importEmployeeNoFromDeptRoute
    var approverId = $('#approverId').val();
    Swal.fire({
        title: 'นำเข้าพนักงาน',
        text: 'นำเข้าพนักงานจากแผนก' + selectedText,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '##6495ed',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'นำเข้า',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var data = {
                'companyDepartmentId': company_department,
                'approverId': approverId
            }

            RequestApi.postRequest(data, importEmployeeNoFromDeptUrl, token).then(response => {
                window.location.reload();
            }).catch(error => { })
        }
    });

});


$(document).on('change', '#employee_type', function () {
    var employee_type = $('#employee_type').val();
    var selectedText = $(this).find('option:selected').text();
    var importEmployeeNoFromUserTypeUrl = window.params.importEmployeeNoFromUserTypeRoute
    var approverId = $('#approverId').val();
    Swal.fire({
        title: 'นำเข้าพนักงาน',
        text: 'นำเข้าพนักงานจากประเภทพนักงาน' + selectedText,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '##6495ed',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'นำเข้า',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var data = {
                'employeeTypeId': employee_type,
                'approverId': approverId
            }

            RequestApi.postRequest(data, importEmployeeNoFromUserTypeUrl, token).then(response => {
                window.location.reload();
            }).catch(error => { })
        }
    });

});