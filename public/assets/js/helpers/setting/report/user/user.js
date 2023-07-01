import * as Report from './api.js'

$(document).on('click', '#export_employee', function (e) {
    e.preventDefault();

    var selectedDepartments = [];
    var selectedEmployeeTypes = [];
    var searchString = $('#search_string').val()
    $('#companyDepartment option:selected').each(function () {
        selectedDepartments.push($(this).val());
    });
    $('#employeeType option:selected').each(function () {
        selectedEmployeeTypes.push($(this).val());
    });

    var data = {
        selectedDepartments: selectedDepartments,
        selectedEmployeeTypes: selectedEmployeeTypes,
        searchString: searchString,
    }

    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.params.token
        },
        url: window.params.exportRoute,
        data: data,
        success: function (result, status, xhr) {
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'employees.xlsx');
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        }
    });
});

$(document).on('click', '#setting_report_field', function (e) {
    e.preventDefault();
    var url = window.params.getReportFieldRoute
    Report.getReportField(url).then(response => {
        $('#search_field_table_container').html(response);
        $('#modal-report-field').modal('show');
    }).catch(error => {

    })
});

$(document).on('click', '#bntUpdateReportField', function (e) {
    e.preventDefault();
    // Get all the checked checkboxes
    var checkedValues = [];
    $('input[name="users[]"]:checked').each(function () {
        checkedValues.push($(this).val());
    });

    var url = window.params.updateReportFieldRoute
    // You can send the values to the server or process them as needed
    Report.updateReportField(checkedValues, url).then(response => {
        $('#modal-report-field').modal('hide');
    }).catch(error => {

    })
});

$(document).on('click', '#search_employee', function (e) {
    e.preventDefault();
    // Get all the checked checkboxes
    var selectedCompanyDepartment = $('#companyDepartment').val();
    var selectedEmployeeType = $('#employeeType').val();
    var searchString = $('#search_string').val();
    var url = window.params.reportSearchRoute
    var data = {
        selectedCompanyDepartment: selectedCompanyDepartment,
        selectedEmployeeType: selectedEmployeeType,
        searchString: searchString,
    }
    // console.log(data);
    Report.reportSearch(data, url).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var selectedCompanyDepartment = $('#companyDepartment').val();
    var selectedEmployeeType = $('#employeeType').val();
    var searchString = $('#search_string').val();
    var url = window.params.reportSearchRoute
    var data = {
        selectedCompanyDepartment: selectedCompanyDepartment,
        selectedEmployeeType: selectedEmployeeType,
        searchString: searchString,
    }
    var page = $(this).attr('href').split('page=')[1];
    var url = "/setting/report/user/report-search?page=" + page
    Report.reportSearch(data, url).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});







