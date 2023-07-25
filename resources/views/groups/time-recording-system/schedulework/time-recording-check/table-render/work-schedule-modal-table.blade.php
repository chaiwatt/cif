<table class="table table-bordered text-nowrap">
    <thead>
        <tr>
            <th>วันที่เข้า</th>
            <th style="width:25%">เวลาเข้า</th>
            <th>วันที่ออก</th>
            <th style="width:25%">เวลาออก</th>
            <th class="text-right">แก้ไข</th>
        </tr>
    </thead>
    <!-- Add a unique class to the <a> elements instead of using id -->
    <tbody>
        @foreach ($workScheduleAssignmentUsers as $key => $workScheduleAssignmentUser)
        <tr data-id="{{ $workScheduleAssignmentUser->id }}">
            <td>{{ $workScheduleAssignmentUser->date_in }}</td>
            <td style="width: 25%">
                <input type="text" id="time_in[{{ $workScheduleAssignmentUser->id }}]"
                    class="form-control input-time-format" value="{{ $workScheduleAssignmentUser->time_in }}">
            </td>
            <td>{{ $workScheduleAssignmentUser->date_out }}</td>
            <td style="width: 25%">
                <input type="text" id="time_out[{{ $workScheduleAssignmentUser->id }}]"
                    class="form-control input-time-format" value="{{ $workScheduleAssignmentUser->time_out }}">
            </td>
            <td class="text-right">
                <!-- Add a unique class (e.g., "btnSaveBtn") to the <a> elements -->
                <a class="btn btn-success btn-sm btnSaveBtn">
                    <i class="fas fa-save"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>