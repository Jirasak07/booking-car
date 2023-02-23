@section('title', 'ข้อมูลการจอง')
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
<link type="text/css" href="{{ asset('argon/css/ratestar.css') }}" rel=" stylesheet" />
@extends('layouts.layout')
<style>
    .custom-class {
        text-align: center;
        font-weight: bold;

    }
</style>
@section('content')
    @include('layouts.header')
    <div class=" mt-3">
        @include('user.box_list_booking')
    </div>

    <div class="container-fluid mt-3">
        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="bg-white rounded shadow-xl m-dash p-2">
                    @if ($message = Session::get('success_edit'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                text: 'แก้ไขการจองสำเร็จ',
                            });
                        </script>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger" id="ERROR_COPY" style="display:none;">
                            <ul style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <!-- ทำการ วน Loop เพื่อแสดง Error ของ validation ขึ้นมาทั้งหมด -->
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table  fw-bold w-100" id="booking_table">
                            <thead class="table-dark table-hover">
                                <tr align="center">
                                    <th class="fw-bolder" style="font-size: 18px">ลำดับ</th>
                                    <th class="fw-bolder" style="font-size: 18px">ช่วงวันที่</th>
                                    <th class="fw-bolder text-wrap" style="font-size: 18px">สาเหตุ</th>
                                    <th class="fw-bolder" style="font-size: 18px">รายละเอียดการจอง</th>
                                    <th class="fw-bolder" style="font-size: 18px">สถานะการจอง</th>
                                    <th class="fw-bolder" style="font-size: 18px">จัดการ</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($booking2 as $item)
                                    <tr>
                                        <td id="row-id" align="center" style="font-size:18px;font-weight:500">
                                            {{ $i++ }}</td>
                                        <td style="font-size:16px" id="date_range">
                                            @php
                                                echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                            @endphp
                                        </td>
                                        <td style="font-size:16px" id="booking_detail">
                                            @php
                                                $detail = explode('~', $item->booking_detail);
                                            @endphp
                                            {!! Str::limit("$detail[0]", 50, ' ...') !!}
                                        </td>
                                        <td align="center" id="view-de">
                                            <a class="btn btn-primary btn-sm text-white"
                                                onclick="view_detail({{ $item->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                        <td align="center" id="booking_status">
                                            @if ($item->booking_status == '1')
                                                <i
                                                    class="fa-regular fa-clock"style="font-size: 14px;color:#fff;background-color:#FF8B13;padding:4px 4px 4px 4px;border-radius:.375rem;"></i>
                                            @elseif ($item->booking_status == '3')
                                                <i class="fa-sharp fa-solid fa-rectangle-xmark"
                                                    style="color: red;font-size:24px"></i>
                                            @else
                                                <i class="fa-solid fa-square-check" style="color: green;font-size:24px"></i>
                                            @endif
                                        </td>
                                        <td align="center" id="manage">
                                            @if ($item->booking_status == '1')
                                                <button class="btn bg-yellow btn-sm me-2 text-white" style="font-size: 13px"
                                                    onclick="edit_booking({{ $item->id }})">
                                                    <i class="fa-regular fa-pen-to-square"></i><span>แก้ไข</span>
                                                </button>
                                                <button class="btn btn-danger btn-sm" style="font-size: 13px"
                                                    onclick="alertCancel({{ $item->id }})">
                                                    <i class="fa-solid fa-rectangle-xmark"></i><span>ยกเลิก</span>
                                                </button>
                                            @elseif($item->booking_status == '5')
                                                @if ($item->comment == null && $item->point_booking == null)
                                                    <button class="btn btn-info btn-sm me-2 text-white"
                                                        style="font-size: 13px" onclick="comments({{ $item->id }})">
                                                        <i class="fa-regular fa-comment"></i><span>ประเมิน</span>
                                                    </button>
                                                @else
                                                @endif
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Detail Modal -->
        <div class="modal fade" id="viewdetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="staticBackdropLabel">รายละเอียดการจอง</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <strong for="" class="col-sm-2 col-form-label">ชื่อผู้จอง</strong>
                            <div class="col-sm-10">
                                <label type="text" disabled value="" readonly class="form-control-plaintext"
                                    id="user_book" name="user_book">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <strong class="col-sm-2 col-form-label">สถานะการจอง</strong>
                            <div class="col-sm-10">
                                <label class="form-control-plaintext" id="status_booking"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <strong for="" class="col-sm-2 col-form-label">ช่วงวันที่</strong>
                            <div class="col-sm-10">
                                <label class="form-control-plaintext" id="date_booking"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <strong for="" class="col-sm-3 col-form-label">รายละเอียดรถและคนขับ</strong>
                            <div class="col-sm-8">
                                <label name="" id="detail_car" cols="30" rows="3" readonly
                                    class="form-control-plaintext"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <strong for="" class="col-sm-3 col-form-label">รายละเอียดการจอง</strong>
                            <div class="col-sm-8">
                                <label name="" id="detail_booking" cols="30" disabled
                                    rows="5"value="" readonly class="form-control-plaintext"></label>
                            </div>
                        </div>
                        <div class="row mb-1" id="div-de-can">
                            <strong for="" class="col-sm-3 col-form-label ">สาเหตุการยกเลิก</strong>
                            <div class="col-sm-8">
                                <label name="" id="detail_booking_cancel" cols="30" disabled
                                    rows="5"value="" readonly
                                    class="form-control-plaintext text-red"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">ปิด</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit detail booking modal --}}
        <div class="modal fade" id="editdetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="viewdeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="viewdeLabel">แก้ไขรายละเอียดการจอง</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('user.edit.booking') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id" value="" />
                            <div class="row mb-3">
                                <strong for="" class="col-sm-2 col-form-label">ชื่อผู้จอง</strong>
                                <div class="col-sm-10">
                                    <input type="text" disabled value="" readonly class="form-control-plaintext"
                                        id="username" name="username">

                                </div>
                            </div>
                            <div class="row mb-3">
                                <strong for="" class="col-sm-2 col-form-label">ช่วงวันที่</strong>
                                <div class="col-sm-10">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <input type="datetime-local" name="booking_start"
                                                data-date-format="DD MM YYYY HH:mm:ss" id="booking_start" value=""
                                                class="form-control" min="" onchange="updateEndTime()">

                                        </div>
                                        <div class="col-md-5">
                                            <input type="datetime-local" name="booking_end"
                                                data-date-format="DD MM YYYY HH:mm:ss" id="booking_end" value=""
                                                class="form-control" min="" onchange="updateEndTime()">
                                        </div>

                                    </div><label class="plaintext text-danger" style="font-size: 14px" id="error_t"
                                        name="error_t"></label>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <strong class="col-sm-3 col-form-label">รายละเอียดการจอง</strong>
                                <div class="col-sm-9">
                                    <textarea name="booking_detail" id="bdetail" cols="30" rows="3" class=" form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" value="" id="EditBooking" class="btn text-white"
                                style="background-color: #06d6a0">บันทึก</button>
                            <button type="button" class="btn grey btn-danger" style="background-color: #ef476f"
                                data-bs-dismiss="modal"data-dismiss="modal">{{ __('ยกเลิก') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- comments modal --}}
        <div class="modal fade" id="comments" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="viewdeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="viewdeLabel">Comment</h3>
                        <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('users.comment_booking') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id_form" id="id_form" value="" />
                            <div class="row mb-3">
                                <strong for="" class="col-sm-2 col-form-label">ชื่อผู้จอง</strong>
                                <div class="col-sm-10">
                                    <label type="text" disabled value="" readonly class="form-control-plaintext"
                                        id="user_d" name="user_d">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <strong for="" class="col-sm-2 col-form-label">ช่วงวันที่</strong>
                                <div class="col-sm-10">
                                    <label class="form-control-plaintext" id="date_d"></label>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <strong for="" class="col-sm-3 col-form-label">รายละเอียดรถและคนขับ</strong>
                                <div class="col-sm-8">
                                    <label name="" id="car_d" cols="30" rows="3" readonly
                                        class="form-control-plaintext"></label>
                                </div>
                            </div>
                            <div class="row">
                                <strong for="" class="col-sm-3 col-form-label">รายละเอียดการจอง</strong>
                                <div class="col-sm-8">
                                    <label name="" id="booking_d" cols="30" disabled
                                        rows="5"value="" readonly class="form-control-plaintext"></label>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <strong class="col-sm-2 col-form-label ">Review</strong>
                                <div class="col-sm-4">
                                    <input class="star star-5" value="5" id="star-5" type="radio"
                                        name="star" />
                                    <label class="star star-5" for="star-5"></label>
                                    <input class="star star-4" value="4" id="star-4" type="radio"
                                        name="star" />
                                    <label class="star star-4" for="star-4"></label>
                                    <input class="star star-3" value="3" id="star-3" type="radio"
                                        name="star" />
                                    <label class="star star-3" for="star-3"></label>
                                    <input class="star star-2" value="2" id="star-2" type="radio"
                                        name="star" />
                                    <label class="star star-2" for="star-2"></label>
                                    <input class="star star-1" value="1" id="star-1" type="radio"
                                        name="star" />
                                    <label class="star star-1" for="star-1"></label>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col">
                                    <textarea class="form-control" name="comment" rows="5 " placeholder="Comment" maxlength="200"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" value="" id="CommentBooking" class="btn text-white"
                                style="background-color: #06d6a0">บันทึก</button>
                            <button type="button" class="btn grey btn-danger" style="background-color: #ef476f"
                                data-bs-dismiss="modal"data-dismiss="modal">{{ __('ยกเลิก') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

    @push('js')
        <script>
            var has_error = {{ $errors->count() > 0 ? 'true' : 'false' }};
            if (has_error) {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    type: 'error',
                    html: jQuery("#ERROR_COPY").html(),
                    showCloseButton: true,
                });
            }
        </script>
        <script>
            $('#addStar').change('.star', function(e) {
                $(this).submit();
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#booking_table').DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 0
                        },
                        {
                            responsivePriority: 2,
                            targets: 3
                        },
                        {
                            responsivePriority: 3,
                            targets: 5
                        },
                    ],
                    lengthMenu: [10, 20, 50, 100, ],
                    language: {
                        lengthMenu: "แสดง _MENU_ รายการ",
                        search: "ค้นหาข้อมูลในตาราง",
                        info: "แสดงข้อมูล _END_ จากทั้งหมด _TOTAL_ รายการ",
                        paginate: {
                            previous: "ก่อนหน้า",
                            next: "ถัดไป",

                        },
                    },

                });

            });

            function edit_booking(id) {
                var h = window.location.pathname
                var s = h.split('/')
                $.ajax({
                    type: 'GET',
                    url: '/' + s[2] + '/detail/' + id,
                    dataType: 'JSON',
                    success: function(res) {
                        $('#editdetail').modal('toggle');
                        //tag input datetime-local เลือกวันย้อนหลังไม่ได้
                        var now_utc = Date.now()
                        var today = new Date(now_utc).toISOString().substring(0, 16);
                        $("#booking_start").attr("min", today);
                        $("#booking_end").attr("min", today);
                        $('#id').val(res.id);
                        $('#username').val(res.name);
                        $('#booking_start').val(res.booking_start);
                        $('#booking_end').val(res.booking_end);
                        $('#bdetail').val(res.booking_detail);
                    },
                })
            }

            function view_detail(id) {
                var h = window.location.pathname
                var s = h.split('/')
                var status = '';
                var car_detail;
                console.log(id);
                $.ajax({
                    type: 'GET',
                    url: '/' + s[2] + '/detail/' + id,
                    dataType: 'JSON',
                    success: function(res) {
                        moment.locale('th');
                        if (res.booking_status == '1') {
                            status = 'กำลังดำเนินการจอง';
                            $('#status_booking').css("color", "#FFB100");
                            //status.css("color":"red");
                        } else if (res.booking_status == '2') {
                            status = 'ดำเนินการจองเสร็จสิ้น';
                            $('#status_booking').css("color", "green");
                        }else if (res.booking_status == '5') {
                            status = 'ดำเนินการเสร็จสิ้น';
                            $('#status_booking').css("color", "green");
                        } else if (res.booking_status == '3') {
                            status = 'ยกเลิกการจอง';
                            $('#status_booking').css("color", "red");
                        }else{
                            status = 'กำลังดำเนินการ';
                            $('#status_booking').css("color", "#FFB100");
                        }
                        if (res.car_license == '-') {
                            car_detail = '-';
                        } else {
                            car_detail = 'คนขับ ' + res.name_driver + ' ทะเบียนรถ ' + res.car_license +
                                ' ' + res
                                .car_model;
                        }
                        var detail_booking = res.booking_detail;
                        var s_detail = detail_booking.split('~');
                        console.log(s_detail);
                        if (s_detail.length == 2) {
                            $('#detail_booking_cancel').html(s_detail[1]);
                        } else {
                            $('#div-de-can').html('');
                        }
                        var start = moment(res.booking_start).add(543, 'year').format(
                            'ddd ที่ D MMM YYYY เวลา HH:mm')
                        var end = moment(res.booking_end).add(543, 'year').format('ddd ที่ D MMM YYYY เวลา HH:mm')

                        $('#user_book').html(res.name);
                        $('#status_booking').html(status);
                        $('#date_booking').html(start + ' - ' + end);
                        $('#detail_car').html(car_detail);
                        $('#detail_booking').html(s_detail[0]);
                        $('#viewdetail').modal('toggle');
                    }
                });
            }

            function alertCancel(id) {
                var h = window.location.pathname
                var s = h.split('/')
                //alert(id)
                var id = id;
                console.log(id);
                const data = @json($booking2);
                const namecancel = [];

                data.forEach(show => {
                        if (show.id == id) {
                            namecancel.push(show);
                        }
                    }),
                    (async () => {
                        moment.locale('th')
                        const bstart = moment(JSON.stringify(namecancel[0].booking_start)).format(' D MMM ' + (new Date(
                                namecancel[0].booking_start)
                            .getFullYear() +
                            543) + ' เวลา HH:mm');
                        const bend = moment(JSON.stringify(namecancel[0].booking_end)).format(' D MMM ' + (new Date(
                                namecancel[0].booking_end)
                            .getFullYear() +
                            543) + ' เวลา HH:mm');
                        console.log(namecancel)
                        const {
                            value: text
                        } = await Swal.fire({
                            title: '<h2 class="text-darker">ยกเลิกรายการ</h2>',
                            input: 'text',
                            // inputLabel: '<div>jjj</div>รายการจองของ ' + namecancel[0].name,
                            html: '<div class="col-12" ><div style="width: max-content;">' +
                                '<div style="font-size:1rem;" ><span style="font-weight:800">ระหว่างวันที่ :</span> ' +
                                bstart + ' - ' + bend +
                                '</div><div class="text-left" style="font-size:1rem"><span style="font-weight:800">รายละเอียด : </span>' +
                                namecancel[0].booking_detail + ' </div> </div></div>',
                            inputPlaceholder: 'กรอกหมายเหตุการยกเลิก',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#06d6a0',
                            cancelButtonColor: '#ef476f',
                            confirmButtonText: 'บันทึก',
                            cancelButtonText: 'ยกเลิก',

                        }).then((result) => {
                            console.log(result)
                            if (result.isConfirmed) {
                                if (result.value) {
                                    $.ajax({
                                        type: 'GET',
                                        url: '/' + s[2] + '/cancel/' + id + '/' + result.value,
                                        dataType: 'JSON',
                                        success: function(data) {
                                            if (data.status == 'success') {
                                                Swal.fire({
                                                    title: 'เสร็จสิ้น',
                                                    icon: 'success',
                                                    confirmButtonText: 'ตกลง',
                                                }).then((data) => {
                                                    window.location.reload();
                                                })
                                            } else {
                                                Swal.fire({
                                                    title: 'Error',
                                                    icon: 'error',
                                                })
                                            }
                                        },
                                    });
                                } else if (!result.value) {
                                    Swal.fire({
                                        icon: 'error',
                                        text: 'ไม่สำเร็จ กรุณากรอกหมายเหตุการยกเลิกรายการ',
                                        confirmButtonColor: '#118ab2',
                                        confirmButtonText: 'ตกลง',
                                    })
                                }
                            }
                        })
                    })()
            }

            function updateEndTime() {
                var h = window.location.pathname
                var s = h.split('/')
                moment.locale('th');
                var nowDate = new moment();
                var changeStart = $("#booking_start").val();
                var changeEnd = $("#booking_end").val();

                var b_start = moment(changeStart);
                var b_end = moment(changeEnd);
                $.ajax({
                    url: '/' + s[2] + '/validate_booking',
                    method: 'GET',
                    success: function(res) {
                        console.log(res);
                        var diffTimeMin = b_end.diff(b_start, res.timemin.unit);
                        var diffTimeMax = b_end.diff(b_start, res.timemax.unit);

                        var canbook_min = moment(nowDate, 'HH:mm:ss a').add(res
                                .timeafter.time, res.timeafter.unit)
                            .format('YYYY-MM-DD HH:mm');
                        console.log(canbook_min);
                        var canbook_max = moment.max(moment(nowDate, 'HH:mm:ss a').add(
                                res.timebefore.time, res.timebefore.unit + 's')
                            .format('YYYY-MM-DD HH:mm'))

                        //console.log('can max : ', canbook_max);
                        if (changeStart < canbook_min) {
                            $('#error_t').html(res.timeafter.name + ' ' + res.timeafter
                                .time + ' ' + res.timeafter.unit_th);
                        } else if (changeStart > canbook_max) {
                            $('#error_t').html(res.timebefore.name + ' ' + res.timebefore
                                .time + ' ' + res.timebefore.unit_th);
                        } else if (diffTimeMin < res.timemin.time) {
                            $('#error_t').html(res.timemin.name + ' ' + res.timemin
                                .time + ' ' + res.timemin.unit_th);
                        } else if (diffTimeMax > res.timemax.time) {
                            $('#error_t').html(res.timemax.name + ' ' + res.timemax
                                .time + ' ' + res.timemax.unit_th);
                        } else {
                            $('#error_t').html('');
                        }
                    }
                });
            }

            function comments(id) {
                var h = window.location.pathname
                var s = h.split('/')
                var status = '';
                var car_detail;
                var url = '/' + s[2] + '/detail/' + id;
                //console.log(url);
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'JSON',
                    success: function(res) {
                        //console.log(res);
                        moment.locale('th');

                        if (res.car_license == '-') {
                            car_detail = '-';
                        } else {
                            car_detail = 'คนขับ ' + res.name_driver + ' ทะเบียนรถ ' + res.car_license +
                                ' ' + res.car_model;
                        }
                        var detail_booking = res.booking_detail;

                        var start = moment(res.booking_start).add(543, 'year').format(
                            'ddd ที่ D MMM YYYY เวลา HH:mm')
                        var end = moment(res.booking_end).add(543, 'year').format('ddd ที่ D MMM YYYY เวลา HH:mm')
                        var s_detail = detail_booking;
                        $('#id_form').val(id);
                        $('#user_d').html(res.name);
                        $('#date_d').html(start + ' - ' + end);
                        $('#car_d').html(car_detail);
                        $('#booking_d').html(s_detail);
                        $('#comments').modal('toggle');
                    }
                });
            }
        </script>
    @endpush
@endsection
