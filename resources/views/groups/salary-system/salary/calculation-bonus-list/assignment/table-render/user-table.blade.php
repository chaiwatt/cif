<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>พนักงาน</th>
            <th>แผนก</th>
            <th style="width: 300px">โบนัส</th>
            <th class="text-end" style="width: 100px">เพิ่มเติม
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bonusUsers as $key=> $bonusUser)
        <tr>
            <td>{{$bonusUser->user->name}} {{$bonusUser->user->lastname}}</td>
            <td>{{$bonusUser->user->company_department->name}}</td>
            <td>
                <input type="text" name="description" data-id="{{$bonusUser->id}}" value="{{$bonusUser->cost}}"
                    class="form-control decimal-input bonus" @if ($bonus->status ==
                1) readonly @endif>
            </td>
            @if ($bonus->status == 0)
            <td class="text-end">
                <a class="btn btn-action btn-delete btn-sm delete" href="" data-id="{{$bonusUser->id}}">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
            @endif

        </tr>
        @endforeach
    </tbody>
</table>
{{$bonusUsers->links()}}