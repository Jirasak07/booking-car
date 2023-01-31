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
                initialView: 'timeGridFourDay',
                allDaySlot: false,
                events: 'http://' + pathArray + '/index.php/admin/dashboard/eventcalen',
                titleFormat: {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                },
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
                    console.log(event.title)
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
                            event.title +
                            ' </div><div class="mt-3 text-left px-3" style="font-size:0.9rem"><strong>รถในการเดินทาง</strong> : ' +
                            detail[0] + '<br/><strong> สถานะ : </strong>' + (color[0] == 2 ?
                                'อนุมัติเรียบร้อย' : 'รอดำเนินการ') + '</div>',
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
                    var nowDate = new moment();

                    var booking_start = moment(info.startStr).format('YYYY-MM-DD HH:mm:ss');
                    var booking_end = moment(info.endStr).format('YYYY-MM-DD HH:mm:ss');


                    var canbook = moment(nowDate, 'HH:mm:ss a').add('5', 'hours').format(
                        'YYYY-MM-DD HH:mm:ss a');
                    //var currect = moment(canbook).format('YYYY-MM-DD HH:mm:ss')
                    // console.log(canbook);
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
            }, 2000);

            calendar.render();
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

<!-- Modal Booking for Admin -->
<div class="modal fade" id="bookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('send-booking') }}">
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
                                    data-date-format="DD MM YYYY HH:mm:ss a" name="date_start" id="date_start"
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
                                    data-date-format="DD MM YYYY HH:mm:ss a" id="date_end" name="date_end"
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
                    <input type="submit" name="saveBooking" value="ยืนยัน" id="saveBooking" class="btn btn-primary">
                    <button type="button" class="btn grey btn-danger"data-bs-dismiss="modal" {{-- onclick="window.location.reload()" --}}
                        data-dismiss="modal">{{ __('ย้อนกลับ') }}</button>
                </div>
            </div>
        </form>

    </div>
</div>
<!--End Modal Booking for Admin -->
<div id='calendar1'></div>
