<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            {{$user->name}} {{$user->lastname}}
        </h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-4">ประเภท</dt>
            <dd class="col-sm-8">{{$leaveType->name}}</dd>
            <dt class="col-sm-4">วันที่ลา</dt>
            <dd class="col-sm-8">{{$startDate}} - {{$endDate}}</dd>
            <dt class="col-sm-4">จำนวนวันที่ลา</dt>
            <dd class="col-sm-8">{{$dayCount}} วัน</dd>
            <dt class="col-sm-4">คร่อมวันหยุด</dt>
            @php
            $holidayArrays = $holidays->toArray();
            @endphp
            <dd class="col-sm-8">@if (count($holidayArrays)>0)
                {{ implode(', ', $holidayArrays) }}
                @else
                -
                @endif</dd>
            <dt class="col-sm-4">วันลาที่เหลือ</dt>
            <dd class="col-sm-8">ลากิจ(xx) ลาป่วย(xx) พักร้อน(xx)</dd>
        </dl>

    </div>
</div>