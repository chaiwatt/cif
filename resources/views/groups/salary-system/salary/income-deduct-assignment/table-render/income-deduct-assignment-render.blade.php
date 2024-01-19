<table class="table table-bordered table-striped dataTable dtr-inline" id="userTable">
    <thead>
        <tr>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>รอบเงินเดือน</th>
            <th>เงินได้ / เงินหัก</th>
            <th>แผนก</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody id="employee_tbody">
        @foreach ($incomeDeductUsers as $key => $incomeDeductUser)
        <tr>
            @php
            $incomeDeductByUsers =
            $incomeDeductUser->user->getIncomeDeductByUsers()
            @endphp
            <td>{{$incomeDeductUser->user->employee_no}}</td>
            <td>{{$incomeDeductUser->user->prefix->name}}{{$incomeDeductUser->user->name}}
                {{$incomeDeductUser->user->lastname}}</td>
            <td>{{$incomeDeductUser->user->getPaydayWithToday()->name}}</td>
            <td>
                @if (count($incomeDeductByUsers) != 0)
                <ul class="mb-0">
                    @foreach ($incomeDeductByUsers as $incomeDeductByUser)
                    <li>{{$incomeDeductByUser->incomeDeduct->name}}
                        {{$incomeDeductByUser->value}}
                        {{$incomeDeductByUser->incomeDeduct->unit->name}}</li>
                    @endforeach
                </ul>
                @endif
            </td>
            <td>{{$incomeDeductUser->user->company_department->name}}</td>
            <td class="text-end">
                <a class="btn btn-danger btn-sm btn-delete" href="" data-id="{{$incomeDeductUser->user->id}}">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $incomeDeductUsers->links() }}