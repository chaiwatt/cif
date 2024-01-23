<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>#</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th>ตำแหน่ง</th>
            <th class="text-end">เพิ่มเติม</th>
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
            <td class="text-end">
                <a class="btn btn-action btn-edit btn-sm"
                    href="{{route('setting.organization.employee.view',['id' => $user->id])}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-action btn-delete btn-sm" data-confirm='ลบพนักงาน "{{$user->name}} {{$user->lastname}}" หรือไม่?'
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