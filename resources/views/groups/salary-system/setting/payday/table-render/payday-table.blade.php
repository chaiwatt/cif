<table class="table table-borderless text-nowrap">
    <thead class="border-bottom">
        <tr>
            <th>กลุ่มพนักงาน</th>
            <th>จำนวนพนักงาน</th>
            <th>ปี</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($paydays as $payday)
        <tr>
            <td>{{$payday->name}}</td>
            <td>{{$payday->users->count()}}</td>
            <td>{{$payday->year}}</td>
            <td class="text-end">
                <a class="btn btn-user btn-action btn-sm"
                    href="{{ route('groups.salary-system.setting.payday.assignment-user', ['id' => $payday->id]) }}">
                    <i class="fas fa-users"></i>
                </a>
                <a class="btn btn-links btn-action btn-sm"
                    href="{{ route('groups.salary-system.setting.payday.assignment', ['id' => $payday->id]) }}">
                    <i class="fas fa-link"></i>
                </a>
                @if ($permission->update)
                <a class="btn btn-edit btn-action btn-sm"
                    href="{{route('groups.salary-system.setting.payday.view',['id' => $payday->id])}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                @endif

                @if ($permission->delete)
                <a class="btn btn-delete btn-action btn-sm" data-confirm='ลบรอบคำนวนเงินเดือน "{{$payday->name}}" หรือไม่?'
                    href="#" data-id="{{$payday->id}}"
                    data-delete-route="{{ route('groups.salary-system.setting.payday.delete', ['id' => '__id__']) }}"
                    data-message="รอบคำนวนเงินเดือน">
                    <i class="fas fa-trash"></i>
                </a>
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>