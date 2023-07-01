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
@include('layouts.partial.dashborad-aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$workSchedule->name}} : {{$month->name}} {{$year}} <span id="expire_message"
                            class="text-danger"></span> </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.schedule.assignment',['id' => $workSchedule->id])}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$workSchedule->name}} เดือน{{$month->name}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">รายละเอียดตารางทำงาน</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="sticky-top mb-3">
                                        <div class="card card-outline card-success">
                                            <div class="card-header">
                                                <h4 class="card-title">กะการทำงาน</h4>
                                            </div>
                                            <div class="card-body">
                                                <!-- the events -->
                                                <div id="external-events">
                                                    @foreach ($shifts as $key => $shift)
                                                    <div class="external-event font-weight-normal"
                                                        style="background-color: {{$shift->color}};color:#ffffff"
                                                        data-id="{{$shift->id}}">{{$shift->name}}</div>
                                                    @if (($key + 1) % 3 === 0 && $key !== count($shifts) - 1)
                                                    <hr>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-9">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h4 class="card-title">ตารางทำงาน {{$month->name}} {{$year}}</h4>
                                        </div>
                                        <div class="card-body ">
                                            <!-- THE CALENDAR -->
                                            <div id="calendar" data-events="{{ $events }}">></div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="row float-right" id="get_updated_event_wrapper">
                                <button class="btn btn-info" id="get-updated-event">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
{{-- <script type="module" src="{{asset('assets/js/helper/dashboard/jobs/schedule/calendar.js?v=1')}}"></script> --}}
<script type="module" src="{{asset('assets/js/helpers/time-recording-system/schedule/calendar.js?v=1')}}"></script>
<script>
    $(function () {
        $('.select2').select2()
        window.params = {
            addCalendarRoute: '{{ route('groups.time-recording-system.schedulework.schedule.assignment.store-calendar') }}',
            url: '{{ url('/') }}',
            token: $('meta[name="csrf-token"]').attr('content')
        };

        var yearlyHolidays = @json($yearlyHolidays);
        yearlyHolidays.forEach(function(holiday) {
            var year = holiday.year;
            var month = holiday.month < 10 ? '0' + holiday.month : holiday.month; var day=holiday.day < 10 ? '0' + holiday.day :
                holiday.day; var date=year + '-' + month + '-' + day; addBgSuccessClassToDate(date); 
        });

        function addBgSuccessClassToDate(date) {
            var tdElements = document.querySelectorAll('td.fc-daygrid-day');
            tdElements.forEach(function (td) {
                if (td.getAttribute('data-date') === date) {
                    td.classList.add('bg-success');
                }
            });
        }
    });
    

</script>
@endpush
@endsection