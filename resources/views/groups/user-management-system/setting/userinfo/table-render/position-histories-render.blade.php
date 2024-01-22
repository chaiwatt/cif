<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>วันที่ปรับ</th>
            <th>ตำแหน่ง</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->positionHistories->sortBy('adjust_date') as $key =>
        $positionHistory)
        <tr>
            <td>{{
                \Carbon\Carbon::createFromFormat('Y-m-d',$positionHistory->adjust_date)->format('d/m/Y')
                }}</td>
            <td>{{$positionHistory->user_position->name}}</td>
            <td class="text-end">
                <a class="btn btn-edit btn-action btn-sm btn-update-position-history" data-id="{{$positionHistory->id}}">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <a class="btn btn-delete btn-action btn-sm btn-delete-position-history" data-id="{{$positionHistory->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>