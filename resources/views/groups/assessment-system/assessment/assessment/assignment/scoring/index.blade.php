@extends('layouts.dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/loading.css?v=1.0') }}">
@endpush
<div>
    @include('layouts.partial.loading')
    <div>
        <div class="container-fluid">
            <div class="title-header">
                <div>
                    <h3 class="m-0">การประเมิน: {{$user->name}} {{$user->lastname}}</h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.assessment-system.assessment.assessment.assignment',['id' => $assessmentGroup->id])}}">{{$assessmentGroup->name}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{$user->name}} {{$user->lastname}}</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            @if ($permission->show)
            <div class="row">


                <div class="col-12 ">
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                                        aria-selected="true">ข้อมูลผู้ใช้</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-bs-toggle="tab"
                                        href="#custom-tabs-three-profile" role="tab"
                                        aria-controls="custom-tabs-three-profile" aria-selected="false">การประเมิน</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-three-home-tab">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="card-header border-0">
                                                <label for="">Attendance</label>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                    <thead class="border-bottom">
                                                        <tr>
                                                            <th>รอบเงินเดือน</th>
                                                            <th>ชั่วโมงทำงาน</th>
                                                            <th>จำนวนขาด</th>
                                                            <th>จำนวนลา</th>
                                                            <th>จำนวนมาสาย</th>
                                                            <th>จำนวนกลับก่อน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($datas as $data)
                                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                            $data['paydayDetail']->start_date)->format('d/m/Y') }} -
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                            $data['paydayDetail']->end_date)->format('d/m/Y') }}</td>
                                                        <td>{{$data['workHours']}}</td>
                                                        <td>{{$data['absentCounts']}}</td>
                                                        <td>{{$data['leaveCounts']}}</td>
                                                        <td>{{$data['lateHours']}}</td>
                                                        <td>{{$data['earlyHours']}}</td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-12" id="training-container">

                                            <div class="card-header border-0">
                                                <label for="">การฝึกอบรม</label>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                    <thead class="border-bottom">
                                                        <tr>
                                                            <th style="width: 40%">หัวข้อ</th>
                                                            <th>หน่วยงาน</th>
                                                            <th>ปีที่ฝึกอบรม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($user->trainings->sortBy('year') as $key =>$training)
                                                        <tr>
                                                            <td>{{$training->course}}</td>
                                                            <td>{{$training->organizer}}</td>
                                                            <td>{{$training->year}}</td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-header border-0">
                                                <label for="">ความผิดและโทษ</label>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                    <thead class="border-bottom">
                                                        <tr>
                                                            <th style="width: 40%">ความผิด / โทษ</th>
                                                            <th>วันที่บันทึก</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($user->punishments as $key => $punishment)
                                                        <tr>
                                                            <td>
                                                                @if ($punishment->record_date != null)
                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d',
                                                                $punishment->record_date)->format('d/m/Y') }}
                                                                @endif


                                                            </td>
                                                            <td>{{$punishment->punishment}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-three-profile-tab">
                                    <form
                                        action="{{route('groups.assessment-system.assessment.assessment.assignment.update-scoring')}}"
                                        method="POST">
                                        @csrf
                                        <div class="row">
                                            <input type="text" value="{{$assessmentGroup->id}}" id="assessmentGroupId"
                                                name="assessmentGroupId" hidden>
                                            <input type="text" value="{{$user->id}}" name="userId" hidden>
                                            <div class="col-sm-12" id="table_container">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                        <thead class="border-bottom">
                                                            <tr>
                                                                <th style="width: 50%">เกณฑ์การประเมิน</th>
                                                                <th style="width: 25%">ตัวคูณคะแนน</th>
                                                                <th style="width: 25%">คะแนน</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach (
                                                            $assessmentGroupUserCriterias as $assessmentGroupUserCriteria)
                                                            <td>{{$assessmentGroupUserCriteria->assessmentCriteria->name}}
                                                                <input type="text"
                                                                    value="{{$assessmentGroupUserCriteria->id}}"
                                                                    name="assessmentGroupUserCriteriaId[]"
                                                                    class="form-control" hidden>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    value="{{
                                                                                                                                                                    $assessmentGroupUserCriteria->getMultiplicationScore($assessmentGroupUserCriteria->assessmentCriteria->id,$assessmentGroup->id)
                                                                                                                                                                    }}"
                                                                    name="assessmentScoreMultiplication[]"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <select name="assessmentScore[]"
                                                                        class="form-control select2 @error('assessmentScore') is-invalid @enderror"
                                                                        style="width: 100%;">
                                                                        @foreach ($assessmentScores as $assessmentScore)
                                                                        <option value="{{ $assessmentScore->id }}"
                                                                            @if($assessmentScore->score ==
                                                                            $assessmentGroupUserCriteria->score)
                                                                            selected
                                                                            @endif>
                                                                            {{$assessmentScore->score}}
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
                                            <div class="cif-modal-footer">
                                                <button type="submit" class="btn btn-primary mt-2">บันทึก</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>


            </div>

            @endif

        </div>
    </div>

</div>
{{-- <div class="modal-footer justify-content-between">
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary" id="bntUpdateReportField">ต่อไป</button>
</div>
</div>
</div>
</div>
</div> --}}
@push('scripts')

<script src="{{asset('assets/js/helpers/helper.js?v=1')}}"></script>
<script>
    window.params = {
        importUserGroupRoute: '{{ route('groups.assessment-system.assessment.assessment.assignment.import-user') }}',       
        url: '{{ url('/') }}',
        token: $('meta[name="csrf-token"]').attr('content')
    };
</script>

@endpush
@endsection