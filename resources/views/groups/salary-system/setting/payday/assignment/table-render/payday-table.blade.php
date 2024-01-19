<table class="table table-striped text-nowrap">
    <thead>
        <tr>
            <th>เดือน</th>
            <th>เริ่มวันที่</th>
            <th>ถึงวันที่</th>
            <th>วันที่จ่ายเงินเดือน</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($paydayDetials as $paydayDetail)
        <tr>
            <td>{{$paydayDetail->month->name}} {{$payday->year}}</td>
            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$paydayDetail->start_date)->format('d/m/Y')}}
            </td>
            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$paydayDetail->end_date)->format('d/m/Y')}}
            </td>
            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$paydayDetail->payment_date)->format('d/m/Y')}}
            </td>

            <td class="text-end">
                <a class="btn btn-primary btn-sm update-payday" href="#" data-id="{{$paydayDetail->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-danger btn-sm" data-confirm='ลบรอบคำนวนเงินเดือน "{{$paydayDetail->name}}" หรือไม่?'
                    href="#" data-id="{{$paydayDetail->id}}"
                    data-delete-route="{{ route('groups.salary-system.setting.payday.assignment.delete', ['id' => '__id__']) }}"
                    data-message="รอบคำนวนเงินเดือน">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>