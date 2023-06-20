import * as Role from './role/role-api.js'

$(document).on('click', '#un_assignment_role_button', function () {
    var roleId = $(this).data('role');
    Role.getUsers().then(response => {
        var users = response;
        renderOptions(users);
        showModal();
        // renderGroups(response);
    }).catch(error => {

    });

    $(document).on('click', '#bntAssignUsersToRole', function () {
        var selectedUserIds = $('.select2').val();
        Role.storeUserToRole(selectedUserIds, roleId).then(response => {
            $('#modal-users').modal('hide');
            // Reload the window
            location.reload();
        }).catch(error => {

        });
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
        option.text(user.name + ' ' + user.lastname);
        selectElement.append(option);
    });

    // Initialize the select2 plugin
    selectElement.select2({
        placeholder: 'เลือกพนักงาน',
        allowClear: true,
        width: '100%'
    });
}
