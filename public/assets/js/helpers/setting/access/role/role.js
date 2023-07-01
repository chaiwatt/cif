import * as RequestApi from '../../../request-api.js';

var token = window.params.token

$(document).on('click', '#un_assignment_role_button', function () {
    var roleId = $(this).data('role');
    var getUserUrl = window.params.getUserRoute;
    var assignUserToRoleUrl = window.params.assignUserToRoleRoute;

    RequestApi.getRequest(getUserUrl).then(response => {
        var users = response;
        renderOptions(users);
        showModal();
    }).catch(error => {});

    $(document).on('click', '#bntAssignUsersToRole', function () {
        var selectedUserIds = $('.select2').val();
        var dataSet = {
            'roleId': roleId,
            'selectedUserIds': selectedUserIds
        }
        RequestApi.postRequest(dataSet, assignUserToRoleUrl, token).then(response => {
            $('#modal-users').modal('hide');
            location.reload();
        }).catch(error => {});
    });
});

function showModal() {
    $('#modal-users').modal('show');
}

function renderOptions(users) {
    var selectElement = $('.select2');
    selectElement.empty(); // Clear existing options

    users.forEach(user => {
        var option = $('<option></option>');
        option.attr('value', user.id);
        option.text(user.name + ' ' + user.lastname + ' (' + user.company_department.name + ')');
        selectElement.append(option);
    });

    // Initialize the select2 plugin
    selectElement.select2({
        placeholder: 'เลือกพนักงาน',
        allowClear: true,
        width: '100%'
    });
}
