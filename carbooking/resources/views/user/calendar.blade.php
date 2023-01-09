<style>
    #calendar {
        max-width: 100%;
        margin: 20px auto;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
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
                var booking_end = moment(info.endStr).format('dddd, MMMM Do YYYY, h:mm:ss a');
                $('#bookingModal').modal('toggle');
                document.getElementById('booking_start').innerHTML = booking_start;
                document.getElementById('booking_end').innerHTML = booking_end;
                document.getElementById('date_start').value = booking_start;
                /* if (ty_car1.checked == true) {
                    console.log(ty_car1.value);
                    fill_driver.style.display = "none";
                } */

                $('#saveBooking').click(function() {
                    var booking_start = info.startStr;
                    var booking_end = info.endStr;
                    var name = $('#name').val();

                });

                $('#modalClose').click(function(){
                    
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

<div class="modal fade" id="bookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bookingModalLabel">กรอกรายละเอียดการจองรถ</h1>
                <button type="button" id="modalClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <div class="row g-3">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">วันเดินทางไป</label>
                        <div class="col-sm-10">
                            <label class="form-control-plaintext" id="booking_start" name="booking_start"></label>
                            <input type="date" data-date="" data-date-format="DD MM YYYY" id="date_start">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">วันเดินทางกลับ</label>
                        <div class="col-sm-10">
                            <label class="form-control-plaintext" id="booking_end" name="booking_end"></label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="ชื่อผู้จอง">
                    </div>
                    <div class="col-md-12">
                        <label for="inputPassword4" class="form-label">ระบุสถานที่</label>
                        <input type="text" name="location" id="location" class=" form-control">
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                <button type="button" name="saveBooking" id="saveBooking" class="btn btn-primary">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div id='calendar'></div>
</div>
