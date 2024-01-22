<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>สายอนุมัติ</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อสกุล</th>
            <th>แผนก</th>
            <th>ประเภทการลา</th>
            <th>ช่วงวันที่</th>
            <th>ผู้อนุมัติเอกสาร</th>
            <th>สถานะ</th>

            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaves as $key=> $leave)
        @php
        $approver =
        $leave->user->approvers->where('document_type_id',1)->first()
        @endphp
        <tr>
            <td>{{$approver->code}}</td>
            <td>{{$leave->user->employee_no}}</td>
            <td>{{$leave->user->name}} {{$leave->user->lastname}}</td>
            <td>{{$leave->user->company_department->name}}</td>
            <td>{{$leave->leaveType->name}}</td>
            <td>{{ date_create_from_format('Y-m-d H:i:s',
                $leave->from_date)->format('d/m/Y H:i') }} - {{
                date_create_from_format('Y-m-d H:i:s',
                $leave->to_date)->format('d/m/Y H:i') }}</td>
            <td>
                {{$approver->name}}
                @foreach ($approver->authorizedUsers as $user)
                <br>
                <span class="ml-3">-{{$user->name}}
                    {{$user->lastname}}</span>

                @endforeach
            </td>
            <td>@if ($leave->status === null)
                <span class="badge bg-primary rounded-3" style="padding: 8px 12px">รออนุมัติ</span>
                @elseif ($leave->status === '1')
                <span class="badge bg-success rounded-3" style="padding: 8px 12px">อนุมัติแล้ว</span>
                @elseif ($leave->status === '2')
                <span class="badge bg-danger rounded-3" style="padding: 8px 12px">ไม่อนุมัติ</span>
                @endif
            </td>

            <td class="text-end">
                @if (!empty($leave->attachment))
                <a class="btn btn-action btn-links btn-sm show-attachment" data-id="{{$leave->id}}">
                    <i class="fas fa-link"></i>
                </a>
                @endif

                @if ($leave->status === null)
                <a class="btn btn-action btn-edit btn-sm"
                    href="{{route('groups.document-system.leave.document.view',['id' => $leave->id])}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-action btn-delete btn-sm"
                    data-confirm='ลบรายการลา "{{$leave->user->name}} {{$leave->user->lastname}}" หรือไม่?' href="#"
                    data-id="{{$leave->id}}"
                    data-delete-route="{{ route('groups.document-system.leave.document.delete', ['id' => '__id__']) }}"
                    data-message="รายการลา">
                    <i class="fas fa-trash"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$leaves->links()}}