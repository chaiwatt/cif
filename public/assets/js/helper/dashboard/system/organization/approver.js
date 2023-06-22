import * as EmployeeAssignment from './employee-assignment/employee-assignment-api.js'

$(document).on('keyup', 'input[name="search_query"]', function () {
    var approverId = $('#approverId').val();
    var searchQuery = $(this).val();
    var url = window.params.searchRoute
    EmployeeAssignment.searchUser(searchQuery, url, approverId).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var approverId = $('#approverId').val();
    var searchQuery = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/setting/organization/approver/assignment/search?page=" + page
    EmployeeAssignment.searchUser(searchQuery, url, approverId).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});

