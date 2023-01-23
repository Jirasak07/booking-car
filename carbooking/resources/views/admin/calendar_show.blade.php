@push('js')
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar1');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // themeSystem: 'bootstrap5',
                selectable: true,
                contentHeight: 600,
                handleWindowResize: true,
                expandRows: true,
                height: '100%',
                nowIndicator: true,
                allDaySlot: false,
                events: 'http://localhost:2222/index.php/admin/dashboard/eventcalen',
                titleFormat: {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                },
                aspectRatio: 2,
                timeFormat: 'HH:mm',
                initialView: 'timeGridFourDay',
                nowIndicator: true,
                allDaySlot: false,
                timeZone: 'Asia/bangkok',
                locale: 'th',
                headerToolbar: {
                    left: 'title',
                    right: 'prev,next',
                    center: 'timeGridFourDay,dayGridMonth,listWeek',
                },
                views: {
                    timeGridFourDay: {
                        type: 'timeGrid',
                        duration: {
                            days: 7
                        },
                        buttonText: '7 day'
                    },
                    listWeek: {
                        buttonText: 'สัปดาห์'
                    },
                    dayGridMonth: {
                        buttonText: 'เดือน'
                    }

                },
                windowResize: function(arg) {

                },
                eventClick: function(e) {
                    var event = e.event;
                    var idevent = e.event.id
                    var datat = @json($calenbook);
                    var start = [];
                    var end = [];
                    var title2 = [];
                    datat.forEach(b => {
                        if (b.id == idevent) {
                            start.push(b.start);
                            end.push(b.end);
                            title2.push(b.title2);
                        }
                    });

                    console.log(idevent)
                    // console.log(moment(timzone).format('HH:mm'))
                    moment.locale('th');
                    Swal.fire({
                        icon: 'question',
                        title: moment(JSON.stringify(start[0])).format(
                            'ddd ที่ D MMM ' + (new Date(start[0]).getFullYear() +
                                543) + ' เวลา HH:mm นาที'),
                        text: event.title +"+"+ title2[0] ,

                    });
                },
                validRange: function(nowDate) {
                    return {
                        start: nowDate
                    };
                },
                dateClick: function(info) {

                },
                eventConstraint: function(info) {
                    // check if there is already an event scheduled in the selected time slot
                    console.log(info.startStr);

                    /* if (checkEventExists(start, end)) {
                        return false; // this time slot is not valid for selection
                    }
                    return true; */ // this time slot is valid for selection
                },
                select: function(info) {
                    moment.locale('th');
                    Swal.fire({
                        title: JSON.stringify(moment(info.startStr).format(
                            'ddd ที่ D MMM ' + (new Date(info.startStr).getFullYear() +
                                543) + ' เวลา HH:mm นาที')),
                        icon: 'info',
                        text: info.startStr
                    })
                }
            });
            setInterval(() => {
                calendar.refetchEvents()
            }, 2000);
            calendar.setOption('aspectRatio', 2);
            calendar.updateSize();
            calendar.render();
        });
    </script>
@endpush

<div id='calendar1'></div>
