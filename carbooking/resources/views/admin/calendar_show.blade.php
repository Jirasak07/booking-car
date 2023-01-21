@push('js')
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar1');
            var ev = @json($calenbook);
            console.log('event', ev);
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // themeSystem: 'bootstrap5',
                selectable: true,
                nowIndicator: true,
                allDaySlot: false,
                events: ev,
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
                height: '145vh',
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
                eventClick: function(e) {
                    var event = e.event;
                    var idevent = e.event.id
                    var datat = @json($calenbook);
                    var start=[];
                    var end=[];
                    datat.forEach(b => {
                        if(b.id == idevent){
                            start.push(b.start);
                            end.push(b.end);
                        }
                    });

                    console.log(idevent)
                    // console.log(moment(timzone).format('HH:mm'))
                    moment.locale('th');
                    Swal.fire({
                        icon: 'question',
                        title: moment(JSON.stringify(start[0])).format(
                            'ddd ที่ D MMM '+(new Date(start[0]).getFullYear()+
                    543) +' เวลา HH:mm นาที'),
                    text:event.title,

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
                        title: JSON.stringify(moment(info.startStr).add(543, 'year').format(
                            'ddd ที่ D MMM YY เวลา HH:mm นาที')),
                        icon: 'info',
                        text:info.startStr
                    })
                }
            });
            calendar.render();
        });
    </script>
@endpush
<div id='calendar-container'>
    <div id='calendar1'></div>
</div>
