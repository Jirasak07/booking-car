@push('js')
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var pathArray = window.location.host;

            var calendarEl = document.getElementById('calendar1');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // themeSystem: 'bootstrap5',
                selectable: true,
                expandRows: true,
                nowIndicator: true,
                allDaySlot: false,
                events: 'http://'+pathArray+'/index.php/admin/dashboard/eventcalen',
                titleFormat: {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                },
                aspectRatio: 1.5,
                timeFormat: 'HH:mm',
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
                eventClick: function(e) {
                    var event = e.event;

                    var idevent = e.event.id
                    var datat = @json($calenbook);
                    var start = [];
                    var end = [];
                    var name = [];
                    var color = [];
                    var detail = [];
                    datat.forEach(b => {
                        if (b.id == idevent) {
                            start.push(b.start);
                            end.push(b.end);
                            name.push(b.data);
                            color.push(b.type);
                            detail.push(b.titlee);
                        }
                    });
                    // console.log(moment(timzone).format('HH:mm'))
                    moment.locale('th');

                    Swal.fire({
                        title: '<div style="font-size:50%" > รายการจองของคุณ : ' + name[0] +
                            '</div>',
                        html: '<div class="col-12" style="font-size:0.9rem"><i class="fa-solid fa-calendar-days" ></i>  :' +
                            moment(
                                JSON.stringify(start[0])).format(
                                ' DD/MM/' + (new Date(start[0]).getFullYear() + 543) +
                                ' เวลา H:mm') + 'น. -' + moment(
                                JSON.stringify(end[0])).format(
                                ' DD/MM/' + (new Date(end[0]).getFullYear() + 543) +
                                ' เวลา H:mm') + 'น.' + '</div>' +
                            '<div class="mt-3" style="font-size:0.9rem" >รายละเอียดการจอง : ' +
                            detail[0] +'</div>',
                        icon: (color[0] == 2 ? 'success' : 'warning'),
                        iconHtml: (color[0] == 2 ?
                            '<i class="fa-solid fa-calendar-check" ></i>' :
                            '<i class="fa-solid fa-calendar-days"></i>'),





                        // title: moment(JSON.stringify(start[0])).format(
                        // 'ddd ที่ D MMM '+JSON.stringify((new Date(start[0]).getFullYear()+543))+
                        // ' เวลา HH:mm นาที'),

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

                }
            });
            setInterval(() => {
                calendar.refetchEvents()
            }, 2000);
            calendar.updateSize();
            calendar.render();
        });
    </script>
@endpush

<div id='calendar1'></div>
