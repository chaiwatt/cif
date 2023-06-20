@extends('layouts.setting.dashboard')
@push('styles')

@endpush
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">บทบาท: {{$role->name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">{{$role->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <a class="btn btn-primary mb-2" id="un_assignment_group_button" href="">
                <i class="fas fa-plus mr-1">
                </i>
                เพิ่มกลุ่มทำงาน
            </a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รายชื่อกลุ่มทำงาน</h3>
                            <div class="card-tools mr-1">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <div id="searchWrapper" class="d-flex"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="group_table"
                                            class="table table-bordered table-striped dataTable dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ชื่อกลุ่มทำงาน</th>
                                                    <th class="text-right">เพิ่มเติม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($role->groups as $group)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$group->name}}</td>
                                                    <td class="text-right">
                                                        <a class="btn btn-primary btn-sm" href="">
                                                            <i class="fas fa-link"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm"
                                                            data-confirm='ลบกลุ่มทำงาน "{{$group->name}}" หรือไม่?'
                                                            href="#" data-role="{{$role->id}}" data-id="{{$group->id}}">
                                                            <i class="fas fa-trash">
                                                            </i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-group">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">เลือกกลุ่มทำงาน</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table id="group_modal_table" class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 200px;">เลือก</th>
                                                <th>กลุ่มทำงาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" onclick="saveGroups()">บันทึก</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@push('scripts')
{{-- <script src="{{ asset('assets/js/helper/datatable-initialize.js') }}"></script> --}}
<script>
    // $(function () {
    //     initializeDataTable('#group_table');
    // });
    $('a[data-confirm]').click(function(event) {
        event.preventDefault();

        var confirmationMessage = $(this).data('confirm');
        var groupId = $(this).data('id');
        var roleId = $(this).data('role');

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
                // Make an AJAX request to delete the item
                $.ajax({
                    url: `{{ route('setting.assignment.group.detach', ['roleId' => '__roleId__', 'groupId' => '__groupId__']) }}`
                    .replace('__roleId__', roleId)
                    .replace('__groupId__', groupId),
                    type: 'DELETE',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Handle the success response
                        var message = response.message;
                        Swal.fire({
                            title: 'ลบแล้ว',
                            text: message,
                            icon: 'success'
                        }).then((result) => {
                            // Optionally perform additional actions after deletion
                            // For example: reload the page or update the UI
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        // Handle the error response
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
                    }
                });
            }
        });
    });

    document.getElementById('un_assignment_group_button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior

        var userId = 1; // Replace with the actual user ID

        // AJAX call
        $.ajax({
            url: '{{ route("api.get-group") }}',
            method: 'GET',
            success: function(response) {
                renderGroups(response);
                showModal();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

var selectedGroupIds = []; // Define an empty array to store selected group IDs

// Function to render the groups in the table
function renderGroups(groups) {
    // Render the groups in the table
    var tableBody = document.getElementById('group_modal_table').getElementsByTagName('tbody')[0];
    tableBody.innerHTML = ''; // Clear existing table body content

    // Loop through the groups and create table rows
    groups.forEach(function(group) {
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

// To uncheck all checkboxes
function uncheckAllCheckboxes() {
    var checkboxes = document.querySelectorAll('#group_modal_table input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
}

// Function to show the modal
function showModal() {
    $('#modal-group').modal('show');
}

// Function to handle saving the selected groups
function saveGroups() {
    var checkboxes = document.querySelectorAll('#group_modal_table input[type="checkbox"]:checked');
    selectedGroupIds = Array.from(checkboxes).map(function(checkbox) {
        return checkbox.value;
    });
    console.log(selectedGroupIds);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
     // Make an AJAX request with the groupIds
    $.ajax({
        url: '{{ route("setting.assignment.group.store") }}',
        method: 'POST',
        data: {
            group_ids: selectedGroupIds,
            role_id: {{ $role->id }}
        },
        headers: {
        'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            // Handle the success response
            console.log(response);
            // Close the modal
            $('#modal-group').modal('hide');
            
            // Reload the window
            location.reload();
        },
        error: function(xhr) {
            // Handle the error response
            console.log(xhr);
        }
    });
}

</script>
@endpush
@endsection