<style>
    #calendar {
        max-width: 100%;
        margin: 20px auto;
    }
</style>

@push('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <!-- Modal -->
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"
        integrity="sha512-oHBLR38hkpOtf4dW75gdfO7VhEKg2fsitvHZYHZjObc4BPKou2PGenyxA5ZJ8CCqWytBx5wpiSqwVEBy84b7tw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>
    {{-- <script src='fullcalendar/dist/index.global.js'></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var bookings = @json($booking);
            //console.log(bookings);
            var g = "1234"
            //console.log(bookings);
            /*console.log(bookings);
              for (let index = 0; index < bookings.length; index++) {
                            let re = bookings[index].type;
                            if (re == '1') {
                                $(this).css('background-color', '#f72585');
                            } else if (re == '2') {
                                $(this).css('background-color', '#0a0908');
                            } else {
                                $(this).css('background-color', '#00bbf9');
                            }
                        }
             */
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

                    /* Swal.fire({
                        icon: 'question',
                        text: 'clicked ' + info.dateStr
                    }); */
                },
                
                select: function(info) {
                    var booking_start = moment(info.startStr).format('YYYY-MM-DD hh:mm:ss a');
                    var booking_end = moment(info.endStr).format('YYYY-MM-DD hh:mm:ss a');
                    var booking_s = moment(info.startStr).format('YYYY-MM-DD hh:mm:ss');
                    var booking_e = moment(info.endStr).format('YYYY-MM-DD hh:mm:ss');
                    /* var time_start = moment(info.startStr).format('LTS');
                    var time_end = moment(info.endStr).format('LTS'); */
                    //var today = new Date().toISOString().split('T')[0];
                    //console.log(today);
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
                            <input type="datetime" data-date="" class="form-control"
                                data-date-format="DD MM YYYY hh:mm:ss" name="date_start" id="date_start">

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
                            <input type="datetime" data-date="" class="form-control"
                                data-date-format="DD MM YYYY hh:mm:ss" id="date_end" name="date_end">
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
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <input type="submit" name="saveBooking" value="ยืนยัน" id="saveBooking" class="btn btn-primary">
                    <button type="button" class="btn grey btn-danger"data-bs-dismiss="modal" {{-- onclick="window.location.reload()" --}}
                        data-dismiss="modal">{{ __('ย้อนกลับ') }}</button>
                </div>
            </div>
        </form>

    </div>
</div>

<div class="container-fluid">
    {{-- <label class=" text-lighter">{{ Auth::user()->id }}</label> --}}
    <div id='calendar' {{-- class="table-responsive" --}}></div>
</div>
