<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{$user->name}} {{$user->lastname}}
                @if (count($notFoundShiftAssignments) !=0 || count($workShifts) == 0)
                <span class="text-danger"> (ไม่พบตารางการทำงาน)</span>
                @endif
            </h3>
        </div>
        <div class="card-body">
            <div></div>
            <dl class="row">
                <dt class="col-sm-4">ประเภท</dt>
                <dd class="col-sm-8">{{$leaveType->name}}</dd>
                <dt class="col-sm-4">เริ่มวันที่</dt>
                <dd class="col-sm-8">{{$startDate}} เวลา {{$startTime}}</dd>
                <dt class="col-sm-4">ถึงวันที่</dt>
                <dd class="col-sm-8">{{$endDate}} เวลา {{$endTime}}</dd>
                {{-- <dt class="col-sm-4">จำนวนวันที่ลา</dt>
                <dd class="col-sm-8">{{$dayCount}} วัน</dd> --}}
                {{-- <dt class="col-sm-4">คร่อมวันหยุด</dt>
                @php
                $holidayArrays = $holidays;
                @endphp
                <dd class="col-sm-8">@if (count($holidayArrays)>0)
                    {{ implode(', ', $holidayArrays) }}
                    @else
                    -
                    @endif</dd> --}}
                {{-- <dt class="col-sm-4">วันลาที่เหลือ</dt>
                <dd class="col-sm-8">ลากิจ <strong>{{$userLeave->business_leave}}</strong><br>
                    ลาป่วย <strong>{{$userLeave->sick_leave}}</strong><br>
                    พักร้อน <strong>{{$userLeave->annual_leave}}</strong></dd> --}}
                <dt class="col-sm-4">ผู้อนุมัติ</dt>
                <dd class="col-sm-8" id="approver" data-approver="{{ json_encode($approver) }}">
                    @if ($approver !== null && $approver->authorizedUsers->isNotEmpty())
                    @foreach ($approver->authorizedUsers as $user)
                    <span>{{ $user->name }} {{ $user->lastname }}</span><br>
                    @endforeach
                    @else
                    <span class="text-danger">ไม่พบผู้อนุมัติ</span>
                    @endif
                </dd>
            </dl>
        </div>
    </div>
</div>


@if ($approver !== null && $approver->authorizedUsers->isNotEmpty() && count($notFoundShiftAssignments) == 0)
<div class="col-md-12">
    <button class="btn bg-success float-right" id="save_leave">บันทึก</button>
</div>
@endif