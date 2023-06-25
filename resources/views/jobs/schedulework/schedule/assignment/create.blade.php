@extends('layouts.pages.dashboard')
@push('scripts')
<style>
    #calendar .fc-header-toolbar,
    #calendar .fc-toolbar {
        display: none;
    }
</style>
@endpush
@section('content')
@include('dashboard.partial.aside', ['groupUrl' => $groupUrl])
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เพิ่มตารางทำงาน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('jobs.schedulework.schedule')}}">ตารางทำงาน</a>
                        </li>
                        <li class="breadcrumb-item active">เพิ่มตารางทำงาน</li>
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
                            <!-- Display validation errors -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ตารางทำงาน<span class="small text-danger">*</span></label>
                                        <input type="text" name="shift" value="{{old('shift')}}"
                                            class="form-control @error('shift') is-invalid @enderror">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label>คำอธิบาย</label>
                                        <input type="text" name="description" value="{{old('description')}}"
                                            class="form-control ">
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>เลือกปี</label>
                                        <select class="form-control select2" style="width: 100%;" id="yearSelect">
                                            <option value="0">2023</option>
                                            <option value="1">2024</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>เลือกเดือน</label>
                                        <select class="form-control select2" style="width: 100%;" id="month-Select">
                                            <option value="0">==เลือกเดือนทำงาน==</option>
                                            <option value="1">มกราคม</option>
                                            <option value="2">กุมภาพันธ์</option>
                                            <option value="3">มีนาคม</option>
                                            <option value="4">เมษายน</option>
                                            <option value="5">พฤษภาคม</option>
                                            <option value="6">มิถุนายน</option>
                                            <option value="7">กรกฎาคม</option>
                                            <option value="8">สิงหาคม</option>
                                            <option value="9">กันยายน</option>
                                            <option value="10">ตุลาคม</option>
                                            <option value="11">ฟฤษจิกายน</option>
                                            <option value="12">ธันวาคม</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 d-flex justify-content-end">
                                    <button class="btn btn-info" id="copy-month-btn">คัดลอกจากเดือนอื่น</button>

                                    <button class="btn btn-success ml-2" id="set-month-btn">เลือกเดือนทำงาน</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
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
                                                    <div class="external-event bg-success" data-id="1">กะทำงานปกติ
                                                        08.00-17.00</div>
                                                    <div class="external-event bg-warning" data-id="2">กะทำงานปกติ
                                                        08.00-17.00 (วันหยุดประจำสัปดาห์)</div>
                                                    <div class="external-event bg-info" data-id="3">กะทำงานปกติ
                                                        08.00-17.00 (วันหยุดนักขัตฤกษ์)
                                                    </div>
                                                    <hr>
                                                    <div class="external-event bg-primary" data-id="4">กะทำงานเช้า
                                                        07.00-16.00</div>
                                                    <div class="external-event bg-danger" data-id="5">กะทำงานเช้า
                                                        07.00-16.00 (วันหยุดประจำสัปดาห์)
                                                    </div>
                                                    <div class="external-event bg-info" data-id="6">กะทำงานปกติ
                                                        07.00-16.00 (วันหยุดนักขัตฤกษ์)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-9">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h4 class="card-title">ตารางทำงานเดือน xxx</h4>
                                        </div>
                                        <div class="card-body ">
                                            <!-- THE CALENDAR -->
                                            <div id="calendar"></div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <div class="row float-right">
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
<script src="{{ asset('assets/js/helper/form-maks.js') }}"></script>
<script>
    $(function () {
        $('.select2').select2()
    function ini_events(ele) {
      ele.each(function () {
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }
        $(this).data('eventObject', eventObject)

        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })
      })
    }

    ini_events($('#external-events div.external-event'))
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;
    var containerEl = document.getElementById('external-events');
    var calendarEl = document.getElementById('calendar');
    var setMonthBtn = document.getElementById('set-month-btn');
    var getUpdatedEventButton = document.getElementById('get-updated-event');
    var monthSelect = document.getElementById('month-Select');

    new Draggable(containerEl, {
      itemSelector: '.external-event',
      eventData: function(eventEl) {
         var eventId = eventEl.getAttribute('data-id');
        return {
          id: eventId, // Include the id in the event data
          title: eventEl.innerText,
          backgroundColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          borderColor: window.getComputedStyle( eventEl ,null).getPropertyValue('background-color'),
          textColor: window.getComputedStyle( eventEl ,null).getPropertyValue('color'),
        };
      }
    });

    var calendar = new Calendar(calendarEl, {
        locale: 'th',
        headerToolbar: {
                start: '', // Empty string to hide the left buttons
                center: 'title', // Display only the title in the center
                end: '' // Empty string to hide the right buttons
        },
        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap',
      //Random default events
      // events: [
      //   {
      //     id             : 10,
      //     title          : 'All Day Event',
      //     start          : new Date(y, m, 1),
      //     backgroundColor: '#f56954', //red
      //     borderColor    : '#f56954', //red
      //     allDay         : true
      //   }
      // ],
      editable  : true,
      droppable : true,
      eventClick: function (info) {
        var event = info.event;
        event.remove();
        console.log('Event removed successfully');
      }
    });

    calendar.render();

    // setMonthBtn.addEventListener('click', function () {
    //   var month = parseInt(monthSelect.value);
    //   if (month === "0") {
    //     return; // Ignore the selection if value is 0
    //   }
      
    //   var year = 2023; // Specify the year
    //   var result = getFirstAndLastDayOfMonth(month, year);
    //   calendar.setOption('validRange', {
    //     start: result.firstDay,
    //     end: result.lastDay
    //   });
    // });


    $('#month-Select').change(function() {
    var selectedValue = $(this).val();
    
    if (selectedValue === "0") {
    return; // Ignore the selection if value is 0
    }
    
    var month = parseInt(selectedValue);
    var year = 2023; // Specify the year
    var result = getFirstAndLastDayOfMonth(month, year);
    
    calendar.setOption('validRange', {
    start: result.firstDay,
    end: result.lastDay
    });
    });

    function getFirstAndLastDayOfMonth(month, year) {
      var firstDay = moment([year, month - 1]).startOf('month').format('YYYY-MM-DD');
      var lastDay = moment([year, month - 1]).endOf('month').add(1, 'day').format('YYYY-MM-DD');

      return {
        firstDay: firstDay,
        lastDay: lastDay
      };
    }

    getUpdatedEventButton.addEventListener('click', function () {
      var events = calendar.getEvents();
      var eventList = [];

      events.forEach(function (event) {
        var eventId = event.id;
        var eventName = event.title;
        var startDate = event.start ? event.start.toISOString().substring(0, 10) : 'N/A';
        var endDate = event.end ? event.end.toISOString().substring(0, 10) : 'N/A';

        // Add 1 day to the start date
        if (event.start) {
          var startDateObj = new Date(event.start);
          startDateObj.setDate(startDateObj.getDate() + 1);
          startDate = startDateObj.toISOString().substring(0, 10);
        }

        // If the event spans multiple days, create an object for each day
        if (event.end && event.start < event.end) {
          var currentDate = new Date(event.start);
          currentDate.setDate(currentDate.getDate() + 1); // Exclude the start date
          while (currentDate <= event.end) {
            var dateObject = {
              'eventId': eventId,
              'eventName': eventName,
              'eventDate': currentDate.toISOString().substring(0, 10)
            };
            eventList.push(dateObject);
            currentDate.setDate(currentDate.getDate() + 1);
          }
        } else {
          var dateObject = {
            'eventId': eventId,
            'eventName': eventName,
            'eventDate': startDate
          };
          eventList.push(dateObject);
        }
      });
      console.log(events);
      console.log(eventList);


      var month = 7; // Specify the month (1-12)
      var year = 2023; // Specify the year

      var daysInMonthArray = getAllDaysInMonth(month, year);
      var missingEvents = [];

      daysInMonthArray.forEach(function (date) {
        var hasEvent = eventList.some(function (event) {
          return event.eventDate === date;
        });

        if (!hasEvent) {
          missingEvents.push(date);
        }
      });

      console.log('Missing Events:', missingEvents);
    });

    function getAllDaysInMonth(month, year) {
      var daysInMonth = new Date(year, month, 0).getDate();
      var daysArray = [];

      for (var day = 1; day <= daysInMonth; day++) {
        var dateString = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);
        daysArray.push(dateString);
      }

      return daysArray;
    }


  })
</script>
@endpush
@endsection