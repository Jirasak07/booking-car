<style>
    .fc-time {
        margin-bottom: 5px;
    }
</style>

@push('js')
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var pathArray = window.location.host;
            var calendarEl = document.getElementById('calendar');
            //var bookings = @json($booking);
            //console.log(bookings);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                //themeSystem: 'bootstrap5',

                selectable: true,
                timeZone: 'Asia/bangkok',
                locale: 'th',
                initialView: 'timeGridFourDay',
                allDaySlot: false,
                nowIndicator: true,
                timeFormat: 'H(:mm)',
                //hour12: false,
                //minTime: moment().format('HH:mm:ss'),
                titleFormat: {
                    month: 'long',
                    year: 'numeric',
                    day: 'numeric',
                    //weekday: 'long',

                    css: 'font-size:20px'
                },
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridDay,timeGridFourDay,dayGridMonth,listMonth'
                },
                handleWindowResize: true,
                expandRows: true,
                height: '100%',
                aspectRatio: 2,
                eventTimeFormat: { // like '14:30:00'
                    hour: '2-digit',
                    minute: '2-digit',

                    hour12: false
                },
                events: 'http://' + pathArray + '/index.php//users/dashboard/refresh',
                eventDisplay: 'block',


                eventDidMount: function(info) {

                    // console.log(info.event.title);
                    // console.log(info.timeText); //time events
                    /* info.el.title = "---- YOUR TEXT----" */
                },
                /*  eventRender: function(event, element) {
                     element.find('.fc-title').before("<br>");
                     element.find('.fc-title').before(element.find('.fc-time'));
                 }, */

                views: {
                    timeGridFourDay: {
                        type: 'timeGrid',
                        duration: {
                            days: 7
                        },
                        buttonText: '7 day'
                    }
                },
                windowResize: function(arg) {

                },
                /*    eventRender: function(event, element) {
                       element.find('.fc-event-time').append('<br>');
                   }, */
                eventClick: function(e) {
                    var event = e.event;
                    var idevent = e.event.id
                    var datat = @json($booking);
                    var start = [];
                    var end = [];
                    var color = [];
                    var title = [];
                    var detail = [];
                    datat.forEach(b => {
                        if (b.id == idevent) {
                            title.push(b.title)
                            start.push(b.start);
                            end.push(b.end);
                            color.push(b.type);
                            detail.push(b.description);
                        }
                    });
                    // console.log(moment(timzone).format('HH:mm'))
                    moment.locale('th');
                    console.log(idevent);
                    Swal.fire({
                        title: '<div style="font-size:70%" ><strong>รายการจอง</strong></div>',
                        html: '<div class="col-12" style="font-size:0.9rem"><div class=" text-left"><i class="fa-solid fa-calendar-days" ></i>  : ' +
                            moment(
                                JSON.stringify(start[0])).format(
                                'dd ที่ DD/MM/' + (new Date(start[0]).getFullYear() + 543) +
                                ' เวลา H:mm') + ' น. - ' + moment(
                                JSON.stringify(end[0])).format(
                                'dd ที่ DD/MM/' + (new Date(end[0]).getFullYear() + 543) +
                                ' เวลา H:mm') + ' น.' +
                            '</div>' +
                            '</div>' +
                            '<div class="mt-3 text-left px-3" style="font-size:0.9rem" ><strong>รายละเอียดการจอง</strong> : ' +
                            title[0] +
                            '</div><div class="mt-3 text-left px-3" style="font-size:0.9rem"><strong>รถในการเดินทาง</strong> : ' +
                            detail[0] + '</div>',
                        icon: (color[0] == 2 ? 'success' : 'warning'),
                        iconHtml: (color[0] == 2 ?
                            '<i class="fa-solid fa-calendar-check" ></i>' :
                            '<i class="fa-solid fa-calendar-days"></i>'),
                    })

                },
                validRange: {
                    start: moment.now()
                },
                dateClick: function(info) {
                    if (info.start < moment()) {
                        return false;
                    }
                },

                select: function(info) {
                    moment.locale('th');
                    var nowDate = new moment();

                    var booking_start = moment(info.startStr).format('YYYY-MM-DD HH:mm');
                    var booking_end = moment(info.endStr).format('YYYY-MM-DD HH:mm');


                    var canbook = moment(nowDate, 'HH:mm:ss a').add('5', 'hours').format(
                        'YYYY-MM-DD HH:mm');
                    //var currect = moment(canbook).format('YYYY-MM-DD HH:mm:ss')
                    console.log(canbook);
                    // console.log(booking_start);
                    //console.log(currect);
                    if (booking_start < canbook) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            //title: 'Oops...',
                            text: 'โปรดจองก่อนเวลาเดินทาง 5 ชั่วโมง',
                        })
                    } else {
                        $('#bookingModal').modal('toggle');
                        $('#booking_start').html(booking_start);
                        $('#booking_end').html(booking_end);

                        document.getElementById('date_start').value = booking_start;
                        document.getElementById('date_end').value = booking_end;

                        //tag input datetime-local เลือกวันย้อนหลังไม่ได้
                        var now_utc = Date.now()
                        var today = new Date(now_utc).toISOString().substring(0, 16);
                        document.getElementById("date_start").setAttribute("min", today);
                        document.getElementById("date_end").setAttribute("min", today);
                    }
                }

            });
            setInterval(() => {
                calendar.refetchEvents()
            }, 5000);
            calendar.setOption('aspectRatio', 2);
            calendar.updateSize();
            calendar.render(
                /* function(event, element) {
                                element.find('.fc-event-time').append('<br>');
                            } */
            );



        });

        function updateEndTime() {
            var now = new moment();
            console.log(now);
            var changeStart = $("#date_start").val();
            var changeEnd = $("#date_end").val();
            var start = moment(changeStart);
            var end = moment(changeEnd);
            var diffHours = start.diff(now, 'hours');
            var diffInMinutes = end.diff(start, 'minutes');
            console.log(diffHours);
            console.log(diffInMinutes);
            if (diffHours < 5) {
                $('#error').html('โปรดระบุเวลาออกเดินทางก่อน 5 ชั่วโมง');
            } else {
                $('#error').html(' ');
            }
            if (diffInMinutes < 30) {
                $('#error_text').html('โปรดระบุช่วงเวลาอย่างน้อย 30 นาที');
            } else {
                $('#error_text').html(' ');
            }

        }
    </script>
@endpush
<div class="modal fade" id="bookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('sendRe') }}">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="bookingModalLabel">กรอกรายละเอียดการจองรถ</h1>
                    <button type="button" class="close" data-bs-dismiss="modal"{{-- onclick="window.location.reload()" --}}
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <strong for="validationCustom03">วันเดินทางไป</strong>
                        </div>

                        <div class="col-md-4">
                            <div class="col-auto">
                                <input type="datetime-local" data-date="" class="form-control"
                                    data-date-format="DD MM YYYY HH:mm" name="date_start" id="date_start"
                                    onchange="updateEndTime()">
                            </div>

                        </div>
                        <div class="col-md-4 form-text">
                            <label class="plaintext text-danger" style="font-size: 14px" id="error"
                                name="error_text"></label>
                            <label class="plaintext text-danger" style="font-size: 14px" id="error_text"
                                name="error_text"></label>
                        </div>
                        <br />
                        <br />
                        <div class="col-md-3">
                            <strong for="validationCustom03">วันเดินทางกลับ</strong>
                        </div>

                        <div class="col-md-4">
                            <div class="col-auto">
                                <input type="datetime-local" data-date="" class="form-control"
                                    data-date-format="DD MM YYYY HH:mm" id="date_end" name="date_end"
                                    onchange="updateEndTime()">
                            </div>

                        </div>
                        <div class="col-md-4 form-text">
                            <label class="plaintext text-danger" style="font-size: 14px" id="error"
                                name="error_text"></label>
                            <label class="plaintext text-danger" style="font-size: 14px" id="error_text"
                                name="error_text"></label>
                        </div>
                        <br />
                        <br />
                        <div class="col-md-12">
                            <strong class="form-label">รายละเอียดการจอง</strong>
                            <span class=" text-danger">*</span>
                            <textarea name="location" id="location" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="saveBooking" value="" id="saveBooking"
                        class="btn btn-primary">ยืนยัน</button>
                    <button type="button" class="btn grey btn-danger"data-bs-dismiss="modal" {{-- onclick="window.location.reload()" --}}
                        data-dismiss="modal">{{ __('ย้อนกลับ') }}</button>
                </div>
            </div>
        </form>

    </div>
</div>
<div id='calendar' class="py-2 px-2 m-dash p-2"></div>
