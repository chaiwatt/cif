import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('click', '#get_authorized_user', function (e) {
    e.preventDefault();
    var getUsersUrl = window.params.getUsersRoute
    var data = {};
    RequestApi.postRequest(data, getUsersUrl, token).then(response => {
        $('#modal-user-wrapper').html(response);
        $('#modal-users').modal('show');
    }).catch(error => {
    })
});

$(document).on('click', '#save_authorized_user', function (e) {
    e.preventDefault();
    var userId = $('#user').val();
    var userName = $("#user option:selected").text();

    if (userId) {
        var newRow = '<tr>' +
            '<td>' + userName + '<input type="text" name="userId[]" value="' + userId + '" hidden></td>' +
            '<td class="text-right"><a href="" class="btn btn-sm btn-danger delete-row"><i class="fas fa-trash"></i></a></td>' +
            '</tr>';
        $('#sortableRows').append(newRow);
        $('#modal-users').modal('hide');
        // $('.select2').val('').trigger('change'); // Reset the dropdown selection
    }
});

$(document).on('click', '.delete-row', function (e) {
    e.preventDefault();
    $(this).closest('tr').remove();
});