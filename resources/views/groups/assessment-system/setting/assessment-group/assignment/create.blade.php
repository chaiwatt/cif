@extends('layouts.dashboard')
@push('scripts')
<style>
    #calendar .fc-header-toolbar,
    #calendar .fc-toolbar {
        display: none;
    }
</style>
@endpush
@section('content')
<div>
    <div>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center my-4 px-4">
                <div>
                    <h3 class="m-0">นำเข้าเกณฑ์การประเมิน</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('groups.assessment-system.setting.assessment-group.assignment', ['id' => $assessmentGroup->id]) }}">กลุ่มการประเมิน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$assessmentGroup->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <h5> ผิดพลาด</h5>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">เกณฑ์การประเมิน</h4>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search_query" id="search_query"
                                        class="form-control" placeholder="ค้นหา">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form
                                action="{{route('groups.assessment-system.setting.assessment-group.assignment.store')}}"
                                method="POST">
                                @csrf
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <input type="text" value="{{$assessmentGroup->id}}" name="assessmentGroupId"
                                            hidden>
                                        <div class="col-sm-12 table-responsive" id="table_container">
                                            <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th style="width: 120px">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" id="select_all">
                                                                <label for="select_all">เลือก</label>
                                                            </div>
                                                        </th>
                                                        <th>เกณฑ์การประเมิน</th>
                                                        <th>ตัวคูณคะแนน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($assessmentCriterias as $assessmentCriteria)
                                                    <tr>
                                                        <td>
                                                            <div class="icheck-primary d-inline">
                                                                <input name="criterias[]" type="checkbox"
                                                                    class="criteria-checkbox"
                                                                    id="checkboxPrimary{{$assessmentCriteria->id}}"
                                                                    value="{{$assessmentCriteria->id}}">
                                                                <label
                                                                    for="checkboxPrimary{{$assessmentCriteria->id}}"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{$assessmentCriteria->name}}</td>
                                                        <td>
                                                            <div class="form-group mb-0">
                                                                <select name="assessmentScoreMultiplication[]"
                                                                    class="form-control select2 @error('assessmentScoreMultiplication') is-invalid @enderror"
                                                                    style="width: 100%;">
                                                                    @foreach ($assessmentScoreMultiplications
                                                                    as $assessmentScoreMultiplication)
                                                                    <option
                                                                        value="{{ $assessmentScoreMultiplication->id }}">
                                                                        {{
                                                                        $assessmentScoreMultiplication->multiplication
                                                                        }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-2 text-end">
                                        @if ($permission->create)
                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="module" src="{{asset('assets/js/helpers/time-recording-system/schedule/assignment/assignment.js?v=1')}}">
</script>
<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        searchRoute: '{{ route('groups.time-recording-system.schedulework.schedule.assignment.user.search') }}',
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };

</script>
<script>
    $(document).on('change', '#select_all', function (e) {
    $('.criteria-checkbox').prop('checked', this.checked);
    });
    
    $(document).on('change', '.criteria-checkbox', function (e) {
    if ($('.criteria-checkbox:checked').length == $('.criteria-checkbox').length) {
    $('#select_all').prop('checked', true);
    } else {
    $('#select_all').prop('checked', false);
    }
    });
</script>
@endpush
@endsection