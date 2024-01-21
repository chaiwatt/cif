// import * as EventCalendar from './api/calendar-api.js'
import * as RequestApi from '../../request-api.js';
    
    const url = window.location.href;
    const segments = url.split('/');
    var workScheduleId = segments[segments.length - 5];
    var year = segments[segments.length - 3];
    var month = segments[segments.length - 1];
    var dateRange = getFirstAndLastDayOfMonth(month, year);
    checkIfExpired(year, month);

    ini_events($('#external-events div.external-event'))

    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;
    var containerEl = $('#external-events')[0];
    var calendarEl = $('#calendar')[0];

    new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function (eventEl) {
            var eventId = eventEl.getAttribute('data-id');
            return {
                id: eventId, // Include the id in the event data
                title: eventEl.innerText,
                backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
            };
        }
    });
    const events = JSON.parse(calendarEl.dataset.events);
    var calendar = new Calendar(calendarEl, {
        locale: 'th',
        headerToolbar: {
            start: '', // Empty string to hide the left buttons
            center: 'title', // Display only the title in the center
            end: '' // Empty string to hide the right buttons
        },
        initialView: 'dayGridMonth',
        validRange: {
            start: dateRange.firstDay,
            end: dateRange.lastDay
        },
        themeSystem: 'bootstrap',
        events: events,
        editable: true,
        droppable: true,
        eventClick: function (info) {
            var event = info.event;
            event.remove();
            console.log('Event removed successfully');
        }
    });

    calendar.render();

    function getFirstAndLastDayOfMonth(month, year) {
        var firstDay = moment([year, month - 1]).startOf('month').format('YYYY-MM-DD');
        var lastDay = moment([year, month - 1]).endOf('month').add(1, 'day').format('YYYY-MM-DD');

        return {
            firstDay: firstDay,
            lastDay: lastDay
        };
    }
        
    $(document).on('click', '#get-updated-event', function (e) {
        e.preventDefault();

        var events = calendar.getEvents();
        var daySchedules = [];
        var allEvents = []
        events.forEach(function (event) {
            var eventId = event.id;
            var eventName = event.title;
            var startDate = event.start ? event.start.toISOString().substring(0, 10) : 'N/A';
            var endDate = event.end ? event.end.toISOString().substring(0, 10) : 'N/A';

            // Add 1 day to the start date
            if (event.start) {
                startDate = new Date(event.start);
                startDate.setDate(startDate.getDate() + 1);
                startDate = startDate.toISOString().substring(0, 10);
            }

            // If the event spans multiple days, create an object for each day
            if (event.end && event.start < event.end) {
                var currentDate = new Date(event.start);
                currentDate.setDate(currentDate.getDate() + 1); // Exclude the start date
                while (currentDate <= event.end) {
                    daySchedules.push({
                        'eventId': eventId,
                        'eventName': eventName,
                        'eventDate': currentDate.toISOString().substring(0, 10)
                    });
                    currentDate.setDate(currentDate.getDate() + 1);
                }
                allEvents.push({
                    'eventId': eventId,
                    'eventName': eventName,
                    'eventStartDate': startDate,
                    'eventEndDate': event.end.toISOString().substring(0, 10),
                    'longEvent': true
                });
            } else {
                daySchedules.push({
                    'eventId': eventId,
                    'eventName': eventName,
                    'eventDate': startDate
                });
                allEvents.push({
                    'eventId': eventId,
                    'eventName': eventName,
                    'eventStartDate': startDate,
                    'eventEndDate': null,
                    'longEvent': false
                });
            }
        });

        var daysInMonthArray = getAllDaysInMonth(month, year);
        var missingEvents = [];

        daysInMonthArray.forEach(function (date) {
            var hasEvent = daySchedules.some(function (event) {
                return event.eventDate === date;
            });

            if (!hasEvent) {
                missingEvents.push(date);
            }
        });

        if (missingEvents.length > 0)
        {
            Swal.fire(
                'ผิดพลาด',
                'กรุณากรอกกะการทำงานให้ครบทุกวัน',
                'warning'
            )
            return;
        }

        var addCalendarUrl = window.params.addCalendarRoute
        var dataSet = {
            'allEvents': allEvents,
            'daySchedules': daySchedules,
            'month': month,
            'year': year,
            'workScheduleId': workScheduleId,
        }
        
        var token = window.params.token
        RequestApi.postRequest(dataSet, addCalendarUrl, token).then(response => {
            var url = window.params.url + '/groups/time-recording-system/schedulework/schedule/assignment/view/' + response.workScheduleId
            window.location.href = url; // Redirect to the generated URL
        }).catch(error => {

        })
        
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
    function checkIfExpired(year, month) {
        // Get the current year and month using Moment.js
        var currentDate = moment();
        var currentYear = currentDate.year();
        var currentMonth = currentDate.month() + 1; // Note: Month is zero-indexed in Moment.js
        // Compare the year and month with the current year and month

        if ((parseInt(year) === parseInt(currentYear) && parseInt(month) < parseInt(currentMonth))) {
            $('#get_updated_event_wrapper').hide();
            $('#expire_message').text('(หมดเวลา)');
        }
    }

    function ini_events(ele) {
        ele.each(function () {
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            }
            $(this).data('eventObject', eventObject)

            // $(this).draggable({
            //     zIndex: 1070,
            //     revert: true, // will cause the event to go back to its
            //     revertDuration: 0  //  original position after the drag
            // })
        })
    }



