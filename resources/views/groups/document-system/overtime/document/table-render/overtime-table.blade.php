<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th style="width:70px">เลือก</th>
            <th>วันที่</th>
            <th>รายการล่วงเวลา</th>
            <th>แผนก</th>
            <th class="text-center">มอบหมาย</th>
            <th class="text-end">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($overtimes as $key=> $overtime)
        <tr>
            <td>

                <div class="icheck-primary d-inline">
                    <input name="overtime[]" type="checkbox" class="overtime-checkbox"
                        id="checkboxPrimary{{$overtime->id}}" value="{{$overtime->id}}" @if ($overtime->status != 0)
                    disabled
                    @endif

                    >
                    <label for="checkboxPrimary{{$overtime->id}}">
                    </label>
                </div>


            </td>
            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                $overtime->from_date)->format('d/m/Y') }}
            </td>
            <td>{{$overtime->name}}</td>
            <td>{{$overtime->approver->company_department->name}}</td>

            <td class="text-center">
                {{count($overtime->overtimeDetails()->with('user')->get()->pluck('user')->unique())}}
            </td>
            <td class="text-end">
                <a class="btn btn-action btn-links btn-sm"
                    href="{{route('groups.document-system.overtime.approval.assignment.download',['id' => $overtime->id])}}">
                    <i class="fas fa-download"></i>
                </a>
                <a class="btn btn-user btn-action btn-sm"
                    href="{{ route('groups.document-system.overtime.approval.assignment', ['id' => $overtime->id]) }}">
                    <i class="fas fa-link"></i>
                </a>
                @if ($overtime->status == 0)
                <a class="btn btn-delete btn-action btn-sm" data-confirm='ลบรายการล่วงเวลา "{{$overtime->name}}" หรือไม่?' href="#"
                    data-id="{{$overtime->id}}"
                    data-delete-route="{{ route('groups.document-system.overtime.document.delete', ['id' => '__id__']) }}"
                    data-message="รายการล่วงเวลา">
                    <i class="fas fa-trash"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$overtimes->links()}}