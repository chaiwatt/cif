import * as Employee from './employee/employee-api.js'

$(document).on('keyup', 'input[name="search_query"]', function () {
    var searchQuery = $(this).val();
    var baseUrl = '/setting/organization/employee/'
    var deleteRoute = window.params.url + baseUrl + '__id__'
    
    Employee.searchUser(searchQuery).then(response => {
        var users = response.users;
        var tableBody = document.querySelector('#employee_tbody');
        var message = 'พนักงาน'
        tableBody.innerHTML = '';

        // Loop through the users array
        for (var i = 0; i < users.length; i++) {
            var user = users[i];
            var row = document.createElement('tr');

            var cells = [
                document.createElement('td'),
                document.createElement('td'),
                document.createElement('td'),
                document.createElement('td'),
                document.createElement('td')
            ];

            cells[0].textContent = user.employee_no;
            cells[1].textContent = user.prefix.name + user.name + ' ' + user.lastname;
            cells[2].textContent = user.company_department.name;
            cells[3].textContent = user.user_position.name;

            // Add the "text-right" class to the last cell
            cells[4].className = 'text-right';

            var editLink = document.createElement('a');
            editLink.className = 'btn btn-info btn-sm mr-1';
            editLink.href = baseUrl + user.id;
            editLink.innerHTML = '<i class="fas fa-pencil-alt"></i>';

            var deleteLink = document.createElement('a');
            deleteLink.className = 'btn btn-danger btn-sm';
            deleteLink.setAttribute('data-confirm', 'ลบ' + message + ' "' + user.name + ' ' + user.lastname + '" หรือไม่?');
            deleteLink.href = '#';
            deleteLink.setAttribute('data-id', user.id);
            deleteLink.setAttribute('data-delete-route', deleteRoute);
            deleteLink.setAttribute('data-message', message);
            deleteLink.innerHTML = '<i class="fas fa-trash"></i>';

            cells[4].appendChild(editLink);
            cells[4].appendChild(deleteLink);

            cells.forEach(function (cell) {
                row.appendChild(cell);
            });

            tableBody.appendChild(row);
        }
    }).catch(error => {

    })
});

