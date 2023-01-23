@section('title', 'ข้อมูลการจอง')
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    @include('user.box_list_booking')
    <div class="container-fluid mt-4">
        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card shadow-sm p-3 overflow-auto">
                    @if ($message = Session::get('success_edit'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                text: 'แก้ไขการจองสำเร็จ',
                            });
                        </script>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover fw-bold w-100  " id="booking_table">
                            <thead class="table-light">
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
                                        <td align="center" style="font-size:18px;font-weight:500">{{ $i++ }}</td>
                                        <td style="font-size:16px" id="date_range">
                                            @php
                                                echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                            @endphp
                                        </td>
                                        <td style="font-size:16px" id="booking_detail">
                                            {!! Str::limit("$item->booking_detail", 50, ' ...') !!}
                                        </td>
                                        <td align="center">
                                            <a class="btn btn-info btn-sm text-darker"
                                                onclick="view_detail({{ $item->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                        <td align="center" id="booking_status">
                                            @if ($item->booking_status == '1')
                                                <i
                                                    class="fa-regular fa-clock"style="font-size: 14px;color:#fff;background-color:#FF8B13;padding:4px 4px 4px 4px;border-radius:.375rem;"></i>
                                            @elseif ($item->booking_status == '2')
                                                <i class="fa-solid fa-square-check" style="color: green;font-size:24px"></i>
                                            @else
                                                <i class="fa-sharp fa-solid fa-rectangle-xmark"
                                                    style="color: red;font-size:24px"></i>
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if ($item->booking_status == '1')
                                                <button class="btn btn-yellow btn-sm me-2" style="font-size: 13px"
                                                    onclick="edit_booking({{ $item->id }})">
                                                    <i class="fa-regular fa-pen-to-square"></i><span>แก้ไข</span>
                                                </button>
                                                <button class="btn btn-danger btn-sm" style="font-size: 13px"
                                                    onclick="alertCancel({{ $item->id }})">
                                                    <i class="fa-solid fa-rectangle-xmark"></i><span>ยกเลิก</span>
                                                </button>
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
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">รายละเอียดการจอง</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" {{-- onclick="window.location.reload()" --}}
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                            <div class="col-sm-10">
                                <label type="text" disabled value="" readonly class="form-control-plaintext"
                                    id="user_book" name="user_book">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">สถานะการจอง</label>
                            <div class="col-sm-10">
                                <label class="form-control-plaintext" id="status_booking"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="" class="col-sm-2 col-form-label">ช่วงวันที่</label>
                            <div class="col-sm-10">
                                <label class="form-control-plaintext" id="date_booking"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="" class="col-sm-3 col-form-label">รายละเอียดรถและคนขับ</label>
                            <div class="col-sm-8">
                                <label name="" id="detail_car" cols="30" rows="3" readonly
                                    class="form-control-plaintext"></label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="" class="col-sm-3 col-form-label">รายละเอียดการจอง</label>
                            <div class="col-sm-8">
                                <label name="" id="detail_booking" cols="30" disabled
                                    rows="5"value="" readonly class="form-control-plaintext"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
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
                        <h1 class="modal-title fs-5" id="viewdeLabel">แก้ไขรายละเอียดการจอง</h1>
                        <button type="button" class="close" data-bs-dismiss="modal" {{-- onclick="window.location.reload()" --}}
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('user.edit.booking') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id" value="" />
                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled value="" readonly class="form-control-plaintext"
                                        id="username" name="username">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="" class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                <div class="col-sm-10">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <input type="datetime-local" name="booking_start"
                                                data-date-format="DD MM YYYY hh:mm:ss" id="booking_start" value=""
                                                class="form-control" min="">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="datetime-local" name="booking_end"
                                                data-date-format="DD MM YYYY hh:mm:ss" id="booking_end" value=""
                                                class="form-control" min="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">รายละเอียดการจอง</label>
                                <div class="col-sm-9">
                                    <textarea name="booking_detail" id="booking_detail" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="saveBooking" value="ยืนยัน" id="EditBooking"
                                class="btn btn-primary">
                            <button type="button" class="btn grey btn-danger"data-bs-dismiss="modal"
                                {{-- onclick="window.location.reload()" --}} data-dismiss="modal">{{ __('ย้อนกลับ') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        @push('js')
            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    $('#booking_table').DataTable({
                        responsive: true
                    });

                    setInterval(() => {
                        $.ajax({
                            url: '/users/booking/refresh',
                            method: 'GET',
                            success: function(data) {
                                //console.log(data);
                                $('#alllist').html(data.Alllist);
                                $('#alllistapprove').html(data.Alllistapprove);
                                $('#alllistcancle').html(data.Alllistcancle);
                                $('#alllistpending').html(data.Alllistpending);
                                //$('#booking_status').html(data.booking2.booking_status);
                                console.log(data.booking2.id);
                                /* $('#all').html(data.allbooking);
                                $('#pending').html(data.pending);
                                $('#cancel').html(data.cancel);
                                $('#approve').html(data.approve); */
                            }
                        })
                    }, 10000);
                });

                function edit_booking(id) {
                    $.ajax({
                        type: 'GET',
                        url: '/users/detail/' + id,
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
                            $('#booking_detail').val(res.booking_detail);
                        }
                    })
                }

                function view_detail(id) {
                    var status = '';
                    var car_detail;
                    console.log(id);
                    $.ajax({
                        type: 'GET',
                        url: '/users/detail/' + id,
                        dataType: 'JSON',
                        success: function(res) {
                            if (res.booking_status == '1') {
                                status = 'กำลังดำเนินการ';
                                $('#status_booking').css("color", "#FFB100");
                                //status.css("color":"red");
                            } else if (res.booking_status == '2') {
                                status = 'ดำเนินการเสร็จสิ้น';
                                $('#status_booking').css("color", "green");
                            } else {
                                status = 'ยกเลิกการจอง';
                                $('#status_booking').css("color", "red");
                            }
                            if (res.car_license == '-') {
                                car_detail = '-';
                            } else {
                                car_detail = 'คนขับ ' + res.name_driver + ' ทะเบียนรถ ' + res.car_license + ' ' + res
                                    .car_model;
                            }
                            //console.log(res.booking_start);
                            var start = moment(res.booking_start).format('ddd ที่ D MMM YY เวลา HH:mm')
                            var end = moment(res.booking_end).format('ddd ที่ D MMM YY เวลา HH:mm')
                            //console.log(car_detail);
                            $('#viewdetail').modal('toggle');
                            //$('#id_booking').html(res.id);
                            $('#user_book').html(res.name);
                            $('#status_booking').html(status);
                            $('#date_booking').html(start + ' - ' + end);
                            $('#detail_car').html(car_detail);
                            $('#detail_booking').html(res.booking_detail);
                        }
                    });


                }

                function alertCancel(id) {
                    //alert(id)
                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "คุณต้องการยกเลิกการจองใช่หรือไม่!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'GET',
                                url: '/users/cancel/' + id,
                                dataType: 'JSON',
                                success: function(data) {
                                    if (data.status == 'success') {
                                        Swal.fire({
                                            title: 'เสร็จสิ้น',
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                        }).then((data) => {
                                            /* Read more about isConfirmed, isDenied below */
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        })
                                    } else {
                                        Swal.fire({
                                            title: 'Error',
                                            icon: 'error',
                                        })
                                    }
                                },
                            });
                        }
                    })
                }
            </script>
        @endpush

    </div>
@endsection
