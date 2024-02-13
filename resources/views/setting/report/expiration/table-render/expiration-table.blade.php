<div class="table-responsive">
<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>#</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th>ตำแหน่ง</th>
            <th>วันหมดอายุวีซ่า (วดป.)</th>
            <th>วันหมดอายุใบอนุญาต (วดป.)</th>
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
            <td
                class="{{ (Carbon\Carbon::parse($user->visa_expiry_date)->lessThan(Carbon\Carbon::now())) ? 'text-danger' : '' }}">
                {{
                Carbon\Carbon::parse($user->visa_expiry_date)->format('d-m-Y')
                }}
            </td>
            <td
                class="{{ (Carbon\Carbon::parse($user->permit_expiry_date)->lessThan(Carbon\Carbon::now())) ? 'text-danger' : '' }}">
                {{
                Carbon\Carbon::parse($user->permit_expiry_date)->format('d-m-Y')
                }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links() }}
</div>