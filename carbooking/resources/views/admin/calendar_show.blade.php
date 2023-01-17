@push('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <!-- Modal -->
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                // themeSystem: 'bootstrap5',
                titleFormat:  {
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
                height: '100%',
                events: 'https://fullcalendar.io/api/demo-feeds/events.json',
                headerToolbar: {
                    left: 'title',
                    right: 'prev,next',
                    center: 'dayGridMonth,listWeek',
                },
                views: {
                    timeGridFourDay: {
                        type: 'dayGrid',
                        duration: {
                            days: 7
                        },
                        buttonText: '7 day'
                    },
                    listWeek:{
                        buttonText:'สัปดาห์'
                    },
                    dayGridMonth:{
                        buttonText:'เดือน'
                    }

                },
            });

            calendar.render();
        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar-show');
        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         themeSystem: 'jquery-ui',
        //         selectable: false,
        //         timeZone: 'Asia/bangkok',
        //         locale: 'th',
        //         initialView: 'timeGridFourDay',
        //         allDaySlot: false,
        //         nowIndicator: true,
        //         eventColor: ['#fff', '#000'],
        //         // aspectRatio: 0.5,
        //         titleFormat: {
        //             month: 'long',
        //             year: 'numeric',
        //             day: 'numeric',
        //             //weekday: 'long',
        //             hour12: 'false',
        //         },
        //         headerToolbar: {
        //             left: 'prev,next',
        //             center: 'title',
        //             right: 'timeGridDay,timeGridFourDay,dayGridMonth,listMonth'
        //         },


        //         //events: 'https://fullcalendar.io/api/demo-feeds/events.json',
        //         views: {
        //             timeGridFourDay: {
        //                 type: 'timeGrid',
        //                 duration: {
        //                     days: 7
        //                 },
        //                 buttonText: '7 day'
        //             }

        //         },

        //     });

        //     calendar.updateSize();
        //     calendar.render();
        // });
    </script>
@endpush
{{-- <div class="calendar">
    <div id='calendar-show'></div>
</div> --}}

<div id='calendar-container'>
    <div id='calendar'></div>
</div>
