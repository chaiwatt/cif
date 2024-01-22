<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>รายการล่วงเวลา</th>
            <th>วันที่</th>
            {{-- <th>แผนก</th>
            <th>วันที่</th>
            <th>เวลา</th> --}}
            <th>ผู้อนุมัติเอกสาร</th>
            <th>สถานะ</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($overtimes->where('status',0) as $overtime)
        <tr>

            <td>{{$overtime->name}}</td>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $overtime->from_date)->format('d/m/Y') }}
                - {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $overtime->to_date)->format('d/m/Y') }}</td>

            <td>
                สายอนุมัติ {{$overtime->approver->name}}
                <br>
                <span class="me-3">
                    - {{$overtime->approver->user->name}} {{$overtime->approver->user->lastname}}
                    (ผู้จัดการ)
                    @if ($overtime->manager_approve == 0)
                    <span class="badge bg-primary rounded-3" style="font-weight: normal; padding: 8px 12px">รออนุมัติ</span>
                    @elseif ($overtime->manager_approve == 1)
                    <span class="badge bg-success rounded-3" style="font-weight: normal; padding: 8px 12px">อนุมัติแล้ว</span>
                    @elseif ($overtime->manager_approve == 2)
                    <span class="badge bg-danger rounded-3" style="font-weight: normal; padding: 8px 12px">ไม่อนุมัติ</span>
                    @endif
                    @foreach ($overtime->approver->authorizedUsers as $user)
                    <br>

                    <span class="me-3">
                        - {{$user->name}} {{$user->lastname}}

                        @php
                        $approvalStatus=$overtime->getLeaderApprovalStatus($user->id);
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
            <td>@if ($overtime->status === null || $overtime->status === '0')
                <span class="badge bg-primary rounded-3" style="font-weight: normal; padding: 8px 12px">รออนุมัติ</span>
                @elseif ($overtime->status === '1')
                <span class="badge bg-success rounded-3" style="font-weight: normal; padding: 8px 12px">อนุมัติแล้ว</span>
                @elseif ($overtime->status === '2')
                <span class="badge bg-danger rounded-3" style="font-weight: normal; padding: 8px 12px">ไม่อนุมัติ</span>
                @endif
            </td>
            <td class="text-end">

                @if ($overtime->status !== '1')
                <a class="btn btn-info btn-sm approve_overtime" data-id="{{$overtime->id}}"
                    data-approver_id="{{$overtime->approver->id}}">
                    <i class="fas fa-stamp"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
        {{-- @foreach ($overtimeDetails as $key=> $overtimeDetail)
        @php
        $approver =
        $overtimeDetail->user->approvers->where('document_type_id',2)->first()
        @endphp
        <tr>
            <td>{{$approver->code}}</td>
            <td>{{$overtimeDetail->user->name}}
                {{$overtimeDetail->user->lastname}}</td>
            <td>{{$overtimeDetail->user->company_department->name}}</td>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $overtimeDetail->from_date)->format('d/m/Y') }}
            </td>
            <td>{{ substr($overtimeDetail->start_time, 0, 5) }} - {{
                substr($overtimeDetail->end_time, 0, 5) }}</td>
            <td>
                {{$approver->name}}
                @foreach ($approver->authorizedUsers as $user)
                <br>
                <span class="ml-3">
                    - {{$user->name}} {{$user->lastname}}


                    @php
                    $approvalStatus
                    =$overtimeDetail->getLeaderApprovalStatus($user->id);

                    @endphp
                    @if ($approvalStatus === null)
                    <span class="badge bg-primary" style="font-weight: normal;">รออนุมัติ</span>
                    @elseif ($approvalStatus == 1)
                    <span class="badge bg-success" style="font-weight: normal;">อนุมัติแล้ว</span>
                    @elseif ($approvalStatus == 2)
                    <span class="badge bg-danger" style="font-weight: normal;">ไม่อนุมัติ</span>
                    @elseif ($approvalStatus == 0)
                    <span class="badge bg-primary" style="font-weight: normal;">รออนุมัติ</span>
                    @else
                    <span class="badge bg-primary" style="font-weight: normal;">รออนุมัติ</span>
                    @endif
                </span>
                @endforeach

            </td>
            <td>
                @if ($overtimeDetail->status === null || $overtimeDetail->status === '0')
                <span class="badge bg-primary">รออนุมัติ</span>
                @elseif ($overtimeDetail->status === '1')
                <span class="badge bg-success">อนุมัติแล้ว</span>
                @elseif ($overtimeDetail->status === '2')
                <span class="badge bg-danger">ไม่อนุมัติ</span>
                @endif
            </td>
            <td class="text-right">
                <a class="btn btn-info btn-sm approve_overtime" data-id="{{$overtimeDetail->id}}"
                    data-name="{{$overtimeDetail->user->name}} {{$overtimeDetail->user->lastname}}"
                    data-user_id="{{$overtimeDetail->user->id}}" data-approver_id="{{$approver->id}}">
                    <i class="fas fa-stamp"></i>
                </a>
            </td>
        </tr>
        @endforeach --}}
    </tbody>
</table>