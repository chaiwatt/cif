import * as Employee from './employee/employee-api.js'

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchQuery = $(this).val();
    var url = window.params.searchRoute
    
    Employee.searchUser(searchQuery, url).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })

});

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchQuery = $('#search_query').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/setting/organization/employee/search?page=" + page

    Employee.searchUser(searchQuery, url).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});

