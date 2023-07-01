import * as RequestApi from '../../../../request-api.js';

var token = window.params.token

$(document).on('click', 'a[data-confirm]', function (event) {
    event.preventDefault();

    var confirmationMessage = $(this).data('confirm');
    var groupId = $(this).data('id');
    var roleId = $(this).data('role');

    var deleteRoute = $(this).data('delete-route').replace('__roleId__', roleId).replace('__groupId__', groupId);

    Swal.fire({
        title: 'ลบกลุ่มทำงาน',
        text: confirmationMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'ยืนยันลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            RequestApi.deleteRequest(deleteRoute, token).then(response => {
                var message = response.message;
                Swal.fire({
                    title: 'ลบแล้ว',
                    text: message,
                    icon: 'success'
                }).then((result) => {
                    window.location.reload();
                });
            }).catch(error => {
                if (xhr.status === 422) {
                    var response = JSON.parse(xhr.responseText);
                    var errorMessage = response.error;
                    Swal.fire({
                        title: 'ข้อผิดพลาด',
                        text: errorMessage,
                        icon: 'error'
                    });
                } else {
                    Swal.fire({
                        title: 'ข้อผิดพลาด',
                        text: 'เกิดข้อผิดพลาดขณะลบกลุ่มทำงาน',
                        icon: 'error'
                    });
                }
            })
        }
    });
});

$(document).on('click', '#un_assignment_group_button', function (event) {    
    event.preventDefault(); // Prevent the default link behavior
    var getGroupUrl = window.params.getGroupRoute
    RequestApi.getRequest(getGroupUrl).then(response => {
        renderGroups(response);
        showModal();
    }).catch(error => {

    });

});

$(document).on('click', '#bntSaveGroup', function (event) {
    var checkboxes = document.querySelectorAll('#group_modal_table input[type="checkbox"]:checked');
    selectedGroupIds = Array.from(checkboxes).map(function (checkbox) {
        return checkbox.value;
    });
    var roleId = document.getElementById('role_id').dataset.id;
    var storeGroupUrl = window.params.storeGroupRoute;
    var dataSet = {
        'roleId': roleId,
        'selectedGroupIds': selectedGroupIds
    }
    RequestApi.postRequest(dataSet, storeGroupUrl, token).then(response => {
        $('#modal-group').modal('hide');
        // Reload the window
        location.reload();
    });
});

var selectedGroupIds = []; // Define an empty array to store selected group IDs

// Function to render the groups in the table
function renderGroups(groups) {
    // Render the groups in the table
    var tableBody = document.getElementById('group_modal_table').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = ''; // Clear existing table body content

    // Loop through the groups and create table rows
    groups.forEach(function (group) {
        var row = document.createElement('tr');
        var checkboxCell = document.createElement('td');
        var groupNameCell = document.createElement('td');

        // Create the checkbox container div
        var checkboxContainer = document.createElement('div');
        checkboxContainer.classList.add('icheck-primary', 'd-inline');

        // Create the checkbox element
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = 'checkboxgroup' + group.id; // Generate unique ID for each checkbox
        checkbox.value = group.id; // Set the value of the checkbox to the group ID

        // Check if the group ID is already in the selectedGroupIds array
        if (selectedGroupIds.includes(group.id)) {
            checkbox.checked = true;
        }

        // Create the label element for the checkbox
        var label = document.createElement('label');
        label.setAttribute('for', 'checkboxgroup' + group.id);

        // Append the checkbox and label to the checkbox container
        checkboxContainer.appendChild(checkbox);
        checkboxContainer.appendChild(label);

        // Append the checkbox container to the checkbox cell
        checkboxCell.appendChild(checkboxContainer);

        // Set the group name in the table cell
        groupNameCell.textContent = group.name;

        // Append cells to the row
        row.appendChild(checkboxCell);
        row.appendChild(groupNameCell);

        // Append the row to the table body
        tableBody.appendChild(row);
    });
}

// Function to show the modal
function showModal() {
    $('#modal-group').modal('show');
}

