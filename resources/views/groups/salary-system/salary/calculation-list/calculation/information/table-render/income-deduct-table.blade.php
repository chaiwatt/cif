<table class="table table-bordered table-striped dataTable dtr-inline">
    @php
    $paymentDate = \Carbon\Carbon::parse($paydayDetail->payment_date);
    $endDate = \Carbon\Carbon::parse($paydayDetail->end_date);
    $currentDate = \Carbon\Carbon::now();
    $isExpire = true;
    if($paymentDate->gte($currentDate) && $currentDate->gte($endDate)){
    $isExpire = false;
    }
    @endphp
    <thead>
        <tr>
            <th>เงินเพิ่ม / เงินหัก</th>
            <th>จำนวน</th>
            <th>หน่วย</th>
            <th class="text-end" style="width: 120px">ลบรายการ</th>
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
            <td class="text-end">
                @if ($isExpire == false)
                <a class="btn btn-danger btn-sm delete-income-deduct" data-id="{{$incomeDeductByUser->id}}">
                    <i class="fas fa-trash"></i>
                </a>
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>