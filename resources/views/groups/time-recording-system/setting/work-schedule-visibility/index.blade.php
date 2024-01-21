@extends('layouts.dashboard')

@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">การมองเห็นตารางทำงาน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">การมองเห็นตารางทำงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">ตารางทำงาน</h4>
                        </div>

                        <div class="card-body pt-0">
                            <form
                                action="{{route('groups.time-recording-system.setting.work-schedule-visibility.store')}}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 table-responsive" id="table_container">
                                        <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                            <thead class="border-bottom">
                                                <tr>
                                                    <th style="width: 120px">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="select_all" checked>
                                                            <label for="select_all">เลือก</label>
                                                        </div>
                                                    </th>
                                                    <th>ชื่อตารางทำงาน</th>
                                                    <th>ปีตารางทำงาน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($workSchedules as $workSchedule)
                                                <tr>
                                                    <td>
                                                        <div class="icheck-primary d-inline">
                                                            <input name="workSchedules[]" type="checkbox"
                                                                class="work-schedule-checkbox"
                                                                id="checkboxPrimary{{$workSchedule->id}}"
                                                                value="{{$workSchedule->id}}" {{
                                                                $workSchedule->shouldUncheck() ? '' : 'checked' }}>
                                                            <label for="checkboxPrimary{{$workSchedule->id}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{$workSchedule->name}}</td>
                                                    <td>{{$workSchedule->year}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit"
                                        class="btn btn-primary">บันทึก</button>
                                    <input type="file" id="file-input" style="display: none;">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@push('scripts')

<script>
    $(document).on('change', '#select_all', function (e) {
    $('.work-schedule-checkbox').prop('checked', this.checked);
    });
    
    $(document).on('change', '.work-schedule-checkbox', function (e) {
    if ($('.work-schedule-checkbox:checked').length == $('.work-schedule-checkbox').length) {
    $('#select_all').prop('checked', true);
    } else {
    $('#select_all').prop('checked', false);
    }
    });
</script>

@endpush
@endsection