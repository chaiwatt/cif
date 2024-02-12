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
                        <div class="card-header">
                            <h4 class="card-title">ผลการประเมิน</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <input type="text" value="{{$assessmentGroup->id}}" id="assessmentGroupId"
                                            name="assessmentGroupId" hidden>
                                        <input type="text" value="{{$user->id}}" name="userId" hidden>
                                        <div class="col-sm-12 table-responsive" id="table_container">
                                            <table class="table table-borderless text-nowrap dataTable dtr-inline">
                                                <thead class="border-bottom">
                                                    <tr>
                                                        <th style="width: 40%">เกณฑ์การประเมิน</th>
                                                        <th style="width: 20%">ตัวคูณคะแนน</th>
                                                        <th style="width: 20%">คะแนนที่ได้</th>
                                                        <th style="width: 20%">คะแนนรวม</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalScore = 0;
                                                        $maxScore = 0;
                                                    @endphp
                                                    @foreach (
                                                        $assessmentGroupUserCriterias as $assessmentGroupUserCriteria)
                                                    @php
                                                        $multiplication =
                                                        $assessmentGroupUserCriteria->getMultiplicationScore($assessmentGroupUserCriteria->assessmentCriteria->id,$assessmentGroup->id);
                                                        $totalScore += $multiplication *$assessmentGroupUserCriteria->score;
                                                        $maxScore += $multiplication *$maxAssessmentScore;
                                                    @endphp
                                                    <td>{{$assessmentGroupUserCriteria->assessmentCriteria->name}}
                                                        <input type="text" value="{{$assessmentGroupUserCriteria->id}}"
                                                            name="assessmentGroupUserCriteriaId[]" class="form-control"
                                                            hidden>
                                                    </td>
                                                    <td>{{$multiplication}}</td>
                                                    <td>{{$assessmentGroupUserCriteria->score}}</td>
                                                    <td>{{$multiplication*$assessmentGroupUserCriteria->score}}</td>
                                                    </tr>
                                                    @if ($loop->last)
                                                    <tr>
                                                        <td colspan="3" style="text-align: right;">
                                                            <strong>Total:</strong>
                                                        </td>
                                                        <td>{{$totalScore}} / {{$maxScore}} =
                                                            {{number_format($totalScore / $maxScore
                                                            *100, 2)}} %</td>
                                                    </tr>
                                                    @endif
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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