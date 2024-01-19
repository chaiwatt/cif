<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            {{-- <th>ระดับ</th> --}}
            <th>รอบจ่ายเงินเดือน</th>
            <th>เบี้ยขยัน</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($userDiligenceAllowances as $key
        =>$userDiligenceAllowance)
        <tr>
            {{-- <td>{{$education->level}}</td> --}}
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $userDiligenceAllowance->paydayDetail->start_date)->format('d/m/Y')
                }} -
                {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $userDiligenceAllowance->paydayDetail->end_date)->format('d/m/Y')
                }}</td>
            <td>{{$userDiligenceAllowance->diligenceAllowanceClassify->cost}}
            </td>
            <td class="text-end">

                @if ($loop->iteration == 2)
                <a class="btn btn-primary btn-sm btn-update-user-diligence-allowance"
                    data-id="{{$userDiligenceAllowance->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>