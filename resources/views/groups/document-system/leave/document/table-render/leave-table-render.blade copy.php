<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>#</th>
            <th>ชื่อสกุล</th>
            <th>แผนก</th>
            <th>ประเภทการลา</th>
            <th>ช่วงวันที่</th>
            <th>ครึ่งวัน</th>
            <th>สถานะ</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaves as $key=> $leave)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$leave->user->name}} {{$leave->user->lastname}}</td>
            <td>{{$leave->user->company_department->name}}</td>
            <td>{{$leave->leaveType->name}}</td>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $leave->from_date)->format('d/m/Y') }}
                - {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $leave->to_date)->format('d/m/Y') }}</td>
            <td>{{$leave->half_day == 1 ? 'ใช่' : '-'}}</td>
            <td>@if ($leave->status === null)
                <span class="badge bg-primary">รออนุมัติ</span>
                @elseif ($leave->status === '1')
                <span class="badge bg-success">อนุมัติแล้ว</span>
                @elseif ($leave->status === '2')
                <span class="badge bg-danger">ไม่อนุมัติ</span>
                @endif
            </td>
            <td class="text-right">
                <a class="btn btn-info btn-sm"
                    href="{{route('groups.document-system.leave.document.view',['id' => $leave->id])}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-danger btn-sm"
                    data-confirm='ลบรายการลา "{{$leave->user->name}} {{$leave->user->lastname}}" หรือไม่?' href="#"
                    data-id="{{$leave->id}}"
                    data-delete-route="{{ route('groups.document-system.leave.document.delete', ['id' => '__id__']) }}"
                    data-message="รายการลา">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>