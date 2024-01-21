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
                    <h3 class="m-0">{{$workSchedule->name}} : {{$month->name}} {{$year}} <span id="expire_message"
                            class="text-danger"></span> </h3>
                </div>
                <div aria-label="breadcrumb">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a
                                href="{{route('groups.time-recording-system.schedulework.schedule.assignment',['id' => $workSchedule->id])}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">{{$workSchedule->name}} เดือน {{$month->name}}</li>
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
                            <h4 class="card-title">รายละเอียดตารางทำงาน</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    {{-- <div class="sticky-top mb-3"> --}}
                                        <div class="card card-outline card-success sticky-top">
                                            <div class="card-header">
                                                <h4 class="card-title">กะการทำงาน</h4>
                                            </div>
                                            <div class="card-body">
                                                <!-- the events -->
                                                <div id="external-events">
                                                    @foreach ($shifts as $key => $shift)
                                                    <div class="external-event font-weight-normal"
                                                        style="background-color: {{$shift->color}};color:#ffffff"
                                                        data-id="{{$shift->id}}">
                                                        {{$shift->name}}</div>
                                                    @if (($key + 1) % 3 === 0 && $key !== count($shifts) - 1)
                                                    <hr>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        {{--
                                    </div> --}}
                                </div>
                                <!-- /.col -->
                                <div class="col-md-9">
                                    <div class="card card-outline card-success sticky-top">
                                        <div class="card-header">
                                            <h4 class="card-title">ตารางทำงาน {{$month->name}} {{$year}}</h4>
                                        </div>
                                        <div class="card-body ">
                                            <!-- THE CALENDAR -->
                                            <div id="calendar" data-events="{{ $events }}"></div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            {{-- <div class="row float-right" id="get_updated_event_wrapper">
                                @if ($permission->create || $permission->update)
                                <button class="btn btn-info" id="get-updated-event">บันทึก</button>
                                @endif
                            </div> --}}
                            <div class="d-flex justify-content-end mt-2">
                                @if ($permission->create || $permission->update)
                                <button class="btn btn-primary" id="get-updated-event">บันทึก</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src="{{ asset('assets/js/helpers/helper.js?v=1') }}"></script>
<script type="module" src="{{asset('assets/js/helpers/time-recording-system/schedule/calendar.js?v=1')}}"></script>
<script>
    
    $(function () {
        $('.select2').select2()
        window.params = {
            addCalendarRoute: '{{ route('groups.time-recording-system.schedulework.schedule.assignment.work-schedule.store') }}',
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