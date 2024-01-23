<table class="table table-borderless text-nowrap dataTable dtr-inline">
    <thead class="border-bottom">
        <tr>
            <th>การใช้งาน</th>
            <th>ฟิลด์ที่ส่งออกรายงาน</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportFields as $reportField)
        <tr>
            <td>
                <div class="icheck-primary d-inline">
                    <input name="users[]" type="checkbox" id="checkboxPrimary{{$reportField->id}}"
                        value="{{$reportField->id}}" @if ($reportField->status == 1)
                    checked
                    @endif
                    >
                    <label for="checkboxPrimary{{$reportField->id}}">
                    </label>
                </div>
            </td>
            <td>{{$reportField->comment}}</td>
        </tr>
        @endforeach
    </tbody>
</table>