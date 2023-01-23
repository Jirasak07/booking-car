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
                    var name = [];
                    datat.forEach(b => {
                        if (b.id == idevent) {
                            start.push(b.start);
                            end.push(b.end);
                            name.push(b.data);
                        }
                    });

                    console.log(idevent)
                    // console.log(moment(timzone).format('HH:mm'))
                    moment.locale('th');

                    Swal.fire({
                        customClass: {
                            title: ''
                        },
                        title: 'รายการจองของ :' + name[0],
                        text: name[0],




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
<template id="my-template">
    <swal-title>
        Save changes to "Untitled 1" before closing?
    </swal-title>
    <swal-icon type="warning" color="red"></swal-icon>
    <swal-button type="confirm">
        Save As
    </swal-button>
    <swal-button type="cancel">
        Cancel
    </swal-button>
    <swal-button type="deny">
        Close without Saving
    </swal-button>
    <swal-param name="allowEscapeKey" value="false" />
    <swal-param name="customClass" value='{ "popup": "my-popup" }' />
    <swal-function-param name="didOpen" value="popup => console.log(popup)" />
</template>
<script>
    function Click() {
        Swal.fire({
            template: '#my-template'
        })
    }
</script>
<div class="btn btn-sm btn-danger" onclick="Click()">ปุ่ม</div>
