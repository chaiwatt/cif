<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>สายอนุมัติ</th>
            <th>ชื่อสกุล</th>
            <th>แผนก</th>
            <th>ประเภทการลา</th>
            <th>ช่วงวันที่</th>
            <th>หัวหน้างาน</th>
            <th>สถานะ</th>
            <th class="text-right">เพิ่มเติม</th>
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
                <span class="ml-3">
                    - {{$approver->user->name}} {{$approver->user->lastname}} (ผู้จัดการ)
                    @if ($leave->manager_approve == 0)
                    <span class="badge bg-primary" style="font-weight: normal;">รออนุมัติ</span>
                    @elseif ($leave->manager_approve == 1)
                    <span class="badge bg-success" style="font-weight: normal;">อนุมัติแล้ว</span>
                    @elseif ($leave->manager_approve == 2)
                    <span class="badge bg-danger" style="font-weight: normal;">ไม่อนุมัติ</span>
                    @endif
                </span>
                @foreach ($approver->authorizedUsers as $user)
                <br>

                <span class="ml-3">
                    - {{$user->name}} {{$user->lastname}}

                    @php
                    $approvalStatus
                    =$leave->getLeaderApprovalStatus($user->id);
                    @endphp
                    {{-- {{$approvalStatus}} --}}
                    @if ($approvalStatus === null)
                    <span class="badge bg-primary" style="font-weight: normal;">รออนุมัติ</span>
                    @elseif ($approvalStatus == 1)
                    <span class="badge bg-success" style="font-weight: normal;">อนุมัติแล้ว</span>
                    @elseif ($approvalStatus == 2)
                    <span class="badge bg-danger" style="font-weight: normal;">ไม่อนุมัติ</span>
                    @elseif ($approvalStatus == 0)
                    <span class="badge bg-primary" style="font-weight: normal;">รออนุมัติ</span>
                    @endif
                </span>
                @endforeach

            </td>
            <td>@if ($leave->status === null || $leave->status === '0')
                <span class="badge bg-primary">รออนุมัติ</span>
                @elseif ($leave->status === '1')
                <span class="badge bg-success">อนุมัติแล้ว</span>
                @elseif ($leave->status === '2')
                <span class="badge bg-danger">ไม่อนุมัติ</span>
                @endif
            </td>
            <td class="text-right">
                @if ($leave->status !== '1')
                <a class="btn btn-info btn-sm approve_leave" data-id="{{$leave->id}}"
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