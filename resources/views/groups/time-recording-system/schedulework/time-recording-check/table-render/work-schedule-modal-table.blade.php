<table class="table table-bordered text-nowrap">
    <thead>
        <tr>
            <th>วันที่เข้า</th>
            <th style="width:25%">เวลาเข้า</th>
            <th>วันที่ออก</th>
            <th style="width:25%">เวลาออก</th>
            <th class="text-right">บันทึก</th>
        </tr>
    </thead>
    <!-- Add a unique class to the <a> elements instead of using id -->
    <tbody>
        @foreach ($workScheduleAssignmentUsers as $key => $workScheduleAssignmentUser)
        <tr data-id="{{ $workScheduleAssignmentUser->id }}">
            <td>
                {{ date('d/m/Y', strtotime($workScheduleAssignmentUser->date_in)) }}
                {!! (strpos($workScheduleAssignmentUser->workScheduleAssignment->shift->code, '_H') !== false ||
                strpos($workScheduleAssignmentUser->workScheduleAssignment->shift->code, '_TH') !== false) ? '<span
                    class="badge bg-success">วันหยุด</span>' : '' !!}

                @if (strpos($workScheduleAssignmentUser->workScheduleAssignment->shift->code, '_H') === false &&
                strpos($workScheduleAssignmentUser->workScheduleAssignment->shift->code, '_TH') === false)
                @if (empty($workScheduleAssignmentUser->time_in) || empty($workScheduleAssignmentUser->time_out))
                @php
                $checkDate = $workScheduleAssignmentUser->date_in; // Assuming the date is available as
                $leaveStatus = $workScheduleAssignmentUser->checkLeaveStatus($checkDate);
                @endphp

                @if ($leaveStatus['leave'] && $leaveStatus['approved'] && !$leaveStatus['rejected'])
                <span class="badge bg-success">L</span>
                @elseif ($leaveStatus['leave'] && !$leaveStatus['approved'] && !$leaveStatus['rejected'])
                <span class="badge bg-warning">L</span>
                @elseif ($leaveStatus['leave'] && !$leaveStatus['approved'] && $leaveStatus['rejected'])
                <span class="badge bg-danger">R</span>
                @else
                <span class="badge bg-danger" id="error_{{$workScheduleAssignmentUser->id}}">M</span>
                @endif
                @endif
                @endif

                @if (strpos($workScheduleAssignmentUser->code, 'E') !== false)
                <span class="badge bg-warning">E</span>
                @endif

            </td>
            <td style="width: 25%">
                <input type="text" id="time_in[{{ $workScheduleAssignmentUser->id }}]"
                    class="form-control input-time-format" value="{{ $workScheduleAssignmentUser->time_in }}">
            </td>
            <td>{{ date('d/m/Y', strtotime($workScheduleAssignmentUser->date_out)) }}</td>
            <td style="width: 25%">
                <input type="text" id="time_out[{{ $workScheduleAssignmentUser->id }}]"
                    class="form-control input-time-format" value="{{ $workScheduleAssignmentUser->time_out }}">
            </td>
            <td class="text-right">
                <a class="btn btn-info btn-sm btnSaveBtn">
                    <i class="far fa-save"></i>
                </a>
                @if (strpos($workScheduleAssignmentUser->workScheduleAssignment->shift->code, '_H') === false &&
                strpos($workScheduleAssignmentUser->workScheduleAssignment->shift->code, '_TH') === false)
                @if (empty($workScheduleAssignmentUser->time_in) || empty($workScheduleAssignmentUser->time_out))
                <a class="btn btn-danger btn-sm btnAttachment" data-id="{{$workScheduleAssignmentUser->id}}">
                    <i class="fas fa-link"></i>
                </a>
                @endif
                @endif
                @if (!empty($workScheduleAssignmentUser->getAttachmentForDate()))
                <a class="btn btn-warning btn-sm show-leave-attachment" data-id="{{$workScheduleAssignmentUser->id}}">
                    <i class="fas fa-leaf"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>