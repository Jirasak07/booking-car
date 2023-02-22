<style>
</style>

@push('js')
    <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.0.2/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var pathArray = window.location.host;
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                //themeSystem: 'bootstrap5',
                slotMinTime:'08:00:00',
                slotMaxTime:'18:30:00',
                slotDuration:'00:10',
                selectable: true,
                // expandRows: true,
                height:1700,
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

                    var b_start = moment(info.startStr);
                    var b_end = moment(info.endStr);

                    var booking_e = moment(b_end,'HH:mm:ss a').add(1,'minutes').format('YYYY-MM-DD HH:mm');
                    //console.log('booking_e :'+booking_e);
                    $.ajax({
                        url: '/users/validate_booking',
                        method: 'GET',
                        success: function(res) {
                            console.log(res);
                            var diffTimeMin = b_end.diff(b_start, res.timemin.unit);
                            var diffTimeMax = b_end.diff(b_start, res.timemax.unit);

                            var canbook_min = moment(nowDate, 'HH:mm:ss a').add(res
                                    .timeafter.time, res.timeafter.unit)
                                .format('YYYY-MM-DD HH:mm');
                            //console.log(canbook_min);
                            var canbook_max = moment.max(moment(nowDate, 'HH:mm:ss a').add(
                                    res.timebefore.time, res.timebefore.unit + 's')
                                .format('YYYY-MM-DD HH:mm'))

                            //console.log('can max : ', canbook_max);
                            if (booking_start < canbook_min) {
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    text: res.timeafter.name + ' ' + res.timeafter
                                        .time + ' ' + res.timeafter.unit_th + '',
                                })
                            } else if (booking_start > canbook_max) {
                                //console.log('max');
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    text: res.timebefore.name + ' ' + res.timebefore
                                        .time + ' ' + res.timebefore.unit_th + '',
                                });
                            } else if (diffTimeMin < res.timemin.time) {
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    text: res.timemin.name + ' ' + res.timemin
                                        .time + ' ' + res.timemin.unit_th + '',
                                });
                            } else if (diffTimeMax > res.timemax.time) {
                                event.preventDefault();
                                Swal.fire({
                                    icon: 'error',
                                    text: res.timemax.name + ' ' + res.timemax
                                        .time + ' ' + res.timemax.unit_th + '',
                                });
                            } else {
                                // $('#booking_start').html(booking_start);
                                // $('#booking_end').html(booking_end);
                                document.getElementById('date_start').value = booking_start;
                                document.getElementById('date_end').value = booking_e;

                                document.getElementById('location').focus();
                                //tag input datetime-local เลือกวันย้อนหลังไม่ได้
                                var now_utc = Date.now()
                                var today = new Date(now_utc).toISOString().substring(0,
                                    16);
                                document.getElementById("date_start").setAttribute("min",
                                    today);
                                document.getElementById("date_end").setAttribute("min",
                                    today);
                                $('#bookingModal').modal('toggle');
                            }
                        }
                    });
                }
            });
            setInterval(() => {
                calendar.refetchEvents()
            }, 5000);
            calendar.setOption('aspectRatio', 2);
            calendar.updateSize();
            calendar.render();
        });

        function updateEndTime() {
            moment.locale('th');
            var nowDate = new moment();
            var changeStart = $("#date_start").val();
            var changeEnd = $("#date_end").val();

            var b_start = moment(changeStart);
            var b_end = moment(changeEnd);

            $.ajax({
                url: '/users/validate_booking',
                method: 'GET',
                success: function(res) {
                    console.log(res);
                    var diffTimeMin = b_end.diff(b_start, res.timemin.unit);
                    var diffTimeMax = b_end.diff(b_start, res.timemax.unit);

                    var canbook_min = moment(nowDate, 'HH:mm:ss a').add(res
                            .timeafter.time, res.timeafter.unit)
                        .format('YYYY-MM-DD HH:mm');
                    //console.log(canbook_min);
                    var canbook_max = moment.max(moment(nowDate, 'HH:mm:ss a').add(
                            res.timebefore.time, res.timebefore.unit + 's')
                        .format('YYYY-MM-DD HH:mm'))

                    //console.log('can max : ', canbook_max);
                    if (changeStart < canbook_min) {
                        $('#error').html(res.timeafter.name + ' ' + res.timeafter
                            .time + ' ' + res.timeafter.unit_th);
                    } else if (changeStart > canbook_max) {
                        $('#error').html(res.timebefore.name + ' ' + res.timebefore
                            .time + ' ' + res.timebefore.unit_th);
                    } else if (diffTimeMin < res.timemin.time) {
                        $('#error').html(res.timemin.name + ' ' + res.timemin
                            .time + ' ' + res.timemin.unit_th);
                    } else if (diffTimeMax > res.timemax.time) {
                        $('#error').html(res.timemax.name + ' ' + res.timemax
                            .time + ' ' + res.timemax.unit_th);
                    } else {
                        $('#error').html('');
                    }
                }
            });
        }
    </script>
@endpush
<div class="modal fade" id="bookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('sendRe') }}" id="booking-store">
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
                            <textarea name="location" id="location" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-primary" onclick="save_form()">ยืนยัน</div>
                    <button type="button" class="btn grey btn-danger"data-bs-dismiss="modal" {{-- onclick="window.location.reload()" --}}
                        data-dismiss="modal">{{ __('ยกเลิก') }}</button>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    function save_form() {
        var frm = $('#booking-store').serialize()
        console.log(frm)
        $.ajax({
            url: '{{ route('sendRe') }}',
            type: "POST",
            data: frm,
            success: function(response) {
                // window.location.reload()
                var id = response.id_form
                $.ajax({
                    url: '/users/store-mail/' + id,
                    type: 'GET',
                    dataType: 'JSON',
                })
            }
        }).then((dd) => {
            Swal.fire({
                icon: 'success',
                text: 'การจองเสร็จสิ้น โปรดรอการอนุมัติ',
                timer: 1200,
                showConfirmButton: false,
            }).then((res) => {
                $.ajax({
                    url: '/users/message',
                    type: 'GET',
                })
                window.location.reload()
            })
        })
    }
</script>
<div id='calendar'></div>
