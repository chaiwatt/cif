<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>#</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th>ตำแหน่ง</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody id="employee_tbody">
        @foreach ($users as $key => $user)
        <tr>
            <td>{{($key + 1 + $users->perPage() * ($users->currentPage() - 1))}}
            </td>
            <td>{{$user->employee_no}}</td>
            <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}</td>
            <td>{{$user->company_department->name}}</td>
            <td>{{$user->user_position->name}}</td>
            <td class="text-right">
                <a class="btn btn-info btn-sm"
                    href="{{route('setting.organization.employee.view',['id' => $user->id])}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-danger btn-sm" data-confirm='ลบพนักงาน "{{$user->name}} {{$user->lastname}}" หรือไม่?'
                    href="#" data-id="{{$user->id}}"
                    data-delete-route="{{ route('setting.organization.employee.delete', ['id' => '__id__']) }}"
                    data-message="ผู้ใช้งาน">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links() }}