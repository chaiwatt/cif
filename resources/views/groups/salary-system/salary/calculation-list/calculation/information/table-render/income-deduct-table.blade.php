<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>เงินเพิ่ม / เงินหัก</th>
            <th>จำนวน</th>
            <th>หน่วย</th>
            <th class="text-right" style="width: 120px">ลบรายการ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->getIncomeDeductUsers($paydayDetail->id) as $key =>
        $incomeDeductByUser)
        <tr>
            <td>{{$incomeDeductByUser->incomeDeduct->name}}
            </td>
            <td>{{$incomeDeductByUser->value}}</td>
            <td>{{$incomeDeductByUser->incomeDeduct->unit->name}}</td>
            <td class="text-right"><a class="btn btn-danger btn-sm delete-income-deduct"
                    data-id="{{$incomeDeductByUser->id}}">
                    <i class="fas fa-trash"></i>
                </a></td>
        </tr>
        @endforeach
    </tbody>
</table>