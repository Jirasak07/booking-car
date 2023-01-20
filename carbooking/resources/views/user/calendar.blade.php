<style>
    #calendar {
        max-width: 100%;
        margin: 20px auto;
    }
</style>

@push('js')
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(() => {

                $.ajax({
                    url: '/users/dashboard/refresh',
                    method: 'GET',
                    success: function(data) {
                        $('#calendar').html(data.calendar);

                    }
                })
            }, 5000);
            var calendarEl = document.getElementById('calendar');
            var bookings = @json($booking);
            console.log(bookings);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                //themeSystem: 'bootstrap5',
                selectable: true,
                timeZone: 'Asia/bangkok',
                locale: 'th',
                initialView: 'timeGridFourDay',
                allDaySlot: false,
                nowIndicator: true,
                timeFormat: 'HH:mm',
                //hour12: false,
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
                eventClick: function(e) {
                    moment.locale('th');
                    var newdate = new Date().getTimezoneOffset();
                    var newdate2 = new Date(e.event.start);
                    alert(JSON.stringify(newdate2.getDay()))
                    var eventObj = e.event;
                    var startb = JSON.stringify(eventObj.start)
                    var endb = JSON.stringify(eventObj.end)
                    var date = new Date(eventObj.start)
                    // alert(date.getUTCHours())
                    //alert('Clicked ' + );
                    Swal.fire({
                        title: date.getUTCDate() +'-'+(date.getUTCMonth()+1)+'-'+(date.getUTCFullYear()+543)+'เวลา'+date.getUTCHours()+':'+date.getUTCMinutes(),
                    });
                },
                events: bookings,
                views: {
                    timeGridFourDay: {
                        type: 'timeGrid',
                        duration: {
                            days: 7
                        },
                        buttonText: '7 day'
                    }
                },
                validRange: function(nowDate) {
                    return {
                        start: nowDate
                    };
                },
                dateClick: function(info) {

                },

                select: function(info) {
                    var booking_start = moment(info.startStr).format('YYYY-MM-DD HH:mm:ss');
                    var booking_end = moment(info.endStr).format('YYYY-MM-DD HH:mm:ss');
                    var booking_s = moment(info.startStr).format('YYYY-MM-DD HH:mm:ss');
                    var booking_e = moment(info.endStr).format('YYYY-MM-DD HH:mm:ss');

                    $('#bookingModal').modal('toggle');
                    $('#booking_start').html(booking_start);
                    $('#booking_end').html(booking_end);
                    document.getElementById('start').value = booking_start;
                    document.getElementById('end').value = booking_end;
                    document.getElementById('date_start').value = booking_s;
                    document.getElementById('date_end').value = booking_e;

                    //tag input datetime-local เลือกวันย้อนหลังไม่ได้
                    var now_utc = Date.now()
                    var today = new Date(now_utc).toISOString().substring(0, 16);
                    document.getElementById("date_start").setAttribute("min", today);
                    document.getElementById("date_end").setAttribute("min", today);
                }

            });

            calendar.render();
        });
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
                            <label class="plaintext" id="booking_start" name="booking_start"></label>
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" name="start" id="start" value="">
                            <input type="datetime-local" data-date="" class="form-control"
                                data-date-format="DD MM YYYY HH:mm:ss a" name="date_start" id="date_start">

                        </div>
                        <br />
                        <br />
                        <div class="col-md-3">
                            <strong for="validationCustom03">วันเดินทางกลับ</strong>
                        </div>
                        <div class="col-md-4">
                            <label class="plaintext" id="booking_end" name="booking_end"></label>
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" name="end" id="end">
                            <input type="datetime-local" data-date="" class="form-control"
                                data-date-format="DD MM YYYY HH:mm:ss a" id="date_end" name="date_end">
                        </div>
                        <br />
                        <br />
                        <div class="col-md-12">
                            <strong class="form-label">รายละเอียดการจอง</strong>
                            <span class=" text-danger">*</span>
                            <textarea name="location" id="location" class="form-control" rows="5" required></textarea>
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

<div class="container-fluid">

    <div id='calendar'></div>
</div>
