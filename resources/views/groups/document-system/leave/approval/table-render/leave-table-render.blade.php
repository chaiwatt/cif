<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>สายอนุมัติ</th>
            <th>ชื่อสกุล</th>
            <th>แผนก</th>
            <th>ประเภทการลา</th>
            <th>ช่วงวันที่</th>
            <th>หัวหน้างาน</th>
            <th>สถานะ</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaves->where('status',0) as $key=> $leave)
        @php
        $approver = $leave->user->approvers->where('document_type_id',1)->first()
        @endphp
        <tr>
            <td>{{$approver->code}}</td>
            <td>{{$leave->user->name}} {{$leave->user->lastname}}</td>
            <td>{{$leave->user->company_department->name}}</td>
            <td>{{$leave->leaveType->name}}</td>
            <td>{{ date_create_from_format('Y-m-d H:i:s',
                $leave->from_date)->format('d/m/Y H:i') }} - {{
                date_create_from_format('Y-m-d H:i:s',
                $leave->to_date)->format('d/m/Y H:i') }}</td>
            <td>
                สายอนุมัติ {{$approver->name}}
                <br>
                <span class="me-3">
                    - {{$approver->user->name}} {{$approver->user->lastname}} (ผู้จัดการ)
                    @if ($leave->manager_approve == 0)
                    <span class="badge bg-primary rounded-3" style="font-weight: normal; padding: 8px 12px">รออนุมัติ</span>
                    @elseif ($leave->manager_approve == 1)
                    <span class="badge bg-success rounded-3" style="font-weight: normal; padding: 8px 12px">อนุมัติแล้ว</span>
                    @elseif ($leave->manager_approve == 2)
                    <span class="badge bg-danger rounded-3" style="font-weight: normal; padding: 8px 12px">ไม่อนุมัติ</span>
                    @endif
                </span>
                @foreach ($approver->authorizedUsers as $user)
                <br>

                <span class="me-3">
                    - {{$user->name}} {{$user->lastname}}

                    @php
                    $approvalStatus
                    =$leave->getLeaderApprovalStatus($user->id);
                    @endphp
                    {{-- {{$approvalStatus}} --}}
                    @if ($approvalStatus === null)
                    <span class="badge bg-primary rounded-3" style="font-weight: normal; padding: 8px 12px">รออนุมัติ</span>
                    @elseif ($approvalStatus == 1)
                    <span class="badge bg-success rounded-3" style="font-weight: normal; padding: 8px 12px">อนุมัติแล้ว</span>
                    @elseif ($approvalStatus == 2)
                    <span class="badge bg-danger rounded-3" style="font-weight: normal; padding: 8px 12px">ไม่อนุมัติ</span>
                    @elseif ($approvalStatus == 0)
                    <span class="badge bg-primary rounded-3" style="font-weight: normal; padding: 8px 12px">รออนุมัติ</span>
                    @endif
                </span>
                @endforeach

            </td>
            <td>@if ($leave->status === null || $leave->status === '0')
                <span class="badge bg-primary rounded-3" style="font-weight: normal; padding: 8px 12px">รออนุมัติ</span>
                @elseif ($leave->status === '1')
                <span class="badge bg-success rounded-3" style="font-weight: normal; padding: 8px 12px">อนุมัติแล้ว</span>
                @elseif ($leave->status === '2')
                <span class="badge bg-danger rounded-3" style="font-weight: normal; padding: 8px 12px">ไม่อนุมัติ</span>
                @endif
            </td>
            <td class="text-end">
                @if ($leave->status !== '1')
                <a class="btn btn-action btn-edit btn-sm approve_leave" data-id="{{$leave->id}}"
                    data-name="{{$leave->user->name}} {{$leave->user->lastname}}" data-user_id="{{$leave->user->id}}"
                    data-approver_id="{{$approver->id}}">
                    <i class="fas fa-stamp"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>