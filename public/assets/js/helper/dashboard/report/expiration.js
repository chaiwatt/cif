import * as Expiration from './api/expiration-api.js'

$(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    var searchQuery = $('#expirationMonth').val();
    var page = $(this).attr('href').split('page=')[1];
    var url = "/setting/report/expiration/search?page=" + page

    Expiration.searchExpiration(searchQuery, url).then(response => {
        $('#table_container').html(response);
    }).catch(error => {

    })
});

$(document).on('click', '#search_expiration', function (e) {
    e.preventDefault();

    var searchQuery = $('#expirationMonth').val();
    var url = window.params.searchRoute

    Expiration.searchExpiration(searchQuery, url).then(response => {
        console.log(response);
        // $('#table_container').html(response);
    }).catch(error => {

    })
    
});
