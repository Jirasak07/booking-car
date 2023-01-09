<style>
    #calendar {
        max-width: 100%;
        margin: 20px auto;
    }

    .datetimepicker {
        display: inline-flex;
        align-items: center;
        background-color: #fff;
        border: 4px solid;
        border-radius: 8px;

        &:focus-within {
            border-color: teal;
        }

        input {
            font: inherit;
            color: inherit;
            appearance: none;
            outline: none;
            border: 0;
            background-color: transparent;

            &[type=date] {
                width: 10rem;
                padding: .25rem 0 .25rem .5rem;
                border-right-width: 0;

            }

            &[type=time] {
                width: 5.5rem;
                padding: .25rem .5rem .25rem 0;
                border-left-width: 0;
            }
        }

        span {
            height: 1rem;
            margin-right: .25rem;
            margin-left: .25rem;
            border-right: 1px solid #ddd;
        }
    }
</style>

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

                selectable: true,
                timeZone: 'Asia/bangkok',
                locale: 'th',
                initialView: 'timeGridFourDay',
                allDaySlot: false,
                nowIndicator: true,
                titleFormat: {
                    month: 'long',
                    year: 'numeric',
                    day: 'numeric',
                    //weekday: 'long',
                    hour12: 'false',
                    css: 'font-size:20px'
                },
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridDay,timeGridFourDay,dayGridMonth,listMonth'
                },
                // events: 'https://fullcalendar.io/api/demo-feeds/events.json',
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
                    var booking_start = moment(info.startStr).format('YYYY-MM-DD');
                    var booking_end = moment(info.endStr).format('YYYY-MM-DD');
                    var time_start = moment(info.startStr).format('LTS');
                    var time_end = moment(info.endStr).format('LTS');
                    $('#bookingModal').modal('toggle');
                    document.getElementById('booking_start').innerHTML = booking_start;
                    document.getElementById('booking_end').innerHTML = booking_end;
                    document.getElementById('date_start').value = booking_start;
                    document.getElementById('time_start').value = time_start;
                    document.getElementById('date_end').value = booking_end;
                    document.getElementById('time_end').value = time_end;
                    /* if (ty_car1.checked == true) {
                        console.log(ty_car1.value);
                        fill_driver.style.display = "none";
                    } */

                    $('#saveBooking').click(function() {
                        var booking_start = info.startStr;
                        var booking_end = info.endStr;
                        var name = $('#name').val();

                    });
                    /* Swal.fire({
                        icon: 'question',
                        text: 'selected ' + info.startStr + ' to ' + info.endStr
                    }); */
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
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="bookingModalLabel">กรอกรายละเอียดการจองรถ</h1>
                    <button type="button" class="close" onclick="window.location.reload()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <strong for="validationCustom03">วันเดินทางไป</strong>
                        </div>
                        <div class="col-md-2">
                            <label class="plaintext" id="booking_start" name="booking_start"></label>
                        </div>
                        <div class="col-md-6">
                            <input type="date" data-date="" class="datetimepicker" data-date-format="DD MM YYYY" name="date_start"
                                id="date_start">
                            <input type="time" data-date="" class="datetimepicker" data-date-format=""
                                id="time_start" name="time_start">
                        </div>
                        <br />
                        <br />
                        <div class="col-md-3">
                            <strong for="validationCustom03">วันเดินทางกลับ</strong>
                        </div>
                        <div class="col-md-2">
                            <label class="plaintext" id="booking_end" name="booking_end"></label>
                        </div>
                        <div class="col-md-6">
                            <input type="date" data-date="" class="datetimepicker" data-date-format="DD MM YYYY"
                                id="date_end" name="date_end">
                            <input type="time" data-date="" class="datetimepicker" data-date-format=""
                                id="time_end" name="time_end">
                        </div>
                        <br />
                        <br />

                        <div class="col-md-12 mb-3">
                            <strong class="form-label">ชื่อผู้จอง</strong>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="ชื่อผู้จอง">
                        </div>

                        <div class="col-md-12">
                            <strong class="form-label">รายละเอียดการจอง</strong>
                            <textarea name="location" id="location" class="form-control" rows="5">
                        </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-danger" onclick="window.location.reload()"
                        data-dismiss="modal">{{ __('ย้อนกลับ') }}</button>
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    <input type="submit" name="saveBooking" value="ยืนยัน" id="saveBooking" class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>
</div>


<div class="container-fluid">

    <div id='calendar'></div>
</div>
