<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th class="text-center" style="width: 150px">ตรวจสอบ</th>
            <th>รอบเงินเดือน</th>
            <th style="width: 200px">วันที่ผิดพลาด</th>
            <th style="width: 200px">รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th class="text-right" style="width: 120px">แก้ไข</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td class="text-center">

                @if (count($user->getErrorDate()) > 0)
                <i class="fas fa-times-circle text-danger"></i>
                @else
                <i class="fas fa-check-circle text-success"></i>
                @endif
            </td>
            <td>
                <ul>
                    @foreach ($user->getPaydayWithTodays() as $getPaydayWithToday)
                    <li>{{$getPaydayWithToday->name}}</li>
                    @endforeach
                </ul>


                {{-- {{$user->getPaydayWithToday()->name}} --}}
            </td>
            <td>
                @if (count($user->getErrorDate()) > 0)
                <ul>
                    @foreach ($user->getErrorDate() as $dateIn)
                    <li>{{ \Carbon\Carbon::parse($dateIn)->format('d/m/Y') }}</li>
                    @endforeach
                </ul>
                @endif
            </td>
            <td>{{ $user->employee_no }}</td>
            <td>{{ $user->prefix->name }}{{
                $user->name }} {{
                $user->lastname }}</td>
            <td>{{ $user->company_department->name
                }}</td>
            <td class="text-right">
                @php
                $paydayDetailWithToday = $user->getPaydayDetailWithToday();
                @endphp
                <a class="btn btn-sm btn-info" data-id="{{$user->id}}"
                    data-startDate="{{$paydayDetailWithToday->start_date}}"
                    data-endDate="{{$paydayDetailWithToday->end_date}}" id="user"><i class="fas fa-pencil-alt"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}