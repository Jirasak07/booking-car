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
                                        @if ($item->booking_status == 1)
                                            <td style="font-size: 18px" align="center">{{ $i++ }}</td>
                                            <td style="font-size: 16px">
                                                @php
                                                    echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                                @endphp

                                            </td>
                                            <td class="text-wrap" style="font-size: 16px">
                                                {!! Str::limit("$item->booking_detail", 50, ' ...') !!}
                                            </td>
                                            <td align="center">
                                                <button class="btn btn-neutral btn-sm text-darker"data-toggle="modal"
                                                    data-target="#viewde{{ $item->id }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </td>
                                            <td align="center">
                                                <button class="btn bg-yellow btn-sm"
                                                    style="font-size: 14px;color:#393E46">กำลังดำเนินการ</button>
                                            </td>
                                            <td align="center">
                                                <button class="btn btn-yellow btn-sm me-2" style="font-size: 13px"
                                                    data-toggle="modal" data-target="#editde{{ $item->id }}">
                                                    <i class="fa-regular fa-pen-to-square"></i><span>แก้ไข</span></button>
                                                <button class="btn btn-danger btn-sm" style="font-size: 13px"
                                                    onclick="alertCancel({{ $item->id }})">
                                                    <i class="fa-solid fa-rectangle-xmark"></i><span>ยกเลิก</span></button>
                                            </td>
                                        @else
                                            <td style="font-size: 18px" align="center">{{ $i++ }}</td>
                                            <td style="font-size: 16px">
                                                @php
                                                    echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                                @endphp
                                            </td>
                                            <td class="text-wrap" style="font-size: 16px">{!! Str::limit("$item->booking_detail", 50, ' ...') !!}</td>
                                            <td align="center">
                                                <button class="btn btn-neutral btn-sm text-darker"data-toggle="modal"
                                                    data-target="#viewde{{ $item->id }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                            </td>
                                            <td align="center">
                                                @if ($item->booking_status == '2')
                                                    <i class="fa-solid fa-square-check"
                                                        style="color: green;font-size:24px"></i>
                                                @else
                                                    <i class="fa-sharp fa-solid fa-rectangle-xmark"
                                                        style="color: red;font-size:24px"></i>
                                                @endif
                                            </td>
                                            <td></td>
                                        @endif
                                    </tr>

                                    <div class="modal fade" id="editde{{ $item->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewdeLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="viewdeLabel">แก้ไขรายละเอียดการจอง
                                                    </h1>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        {{-- onclick="window.location.reload()" --}} data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="POST" action="{{ route('user.edit.booking') }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" id="id"
                                                            value="{{ $item->id }}" />
                                                        <div class="row mb-3">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" disabled value="{{ $item->username }}"
                                                                    readonly class="form-control-plaintext" id="username"
                                                                    name="username">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                                            <div class="col-sm-10">
                                                                <div class="row g-3">
                                                                    <div class="col-md-5">
                                                                        <input type="datetime-local" name="booking_start"
                                                                            data-date-format="DD MM YYYY hh:mm:ss"
                                                                            id="booking_start"
                                                                            value="{{ $item->booking_start }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <input type="datetime-local" name="booking_end"
                                                                            data-date-format="DD MM YYYY hh:mm:ss"
                                                                            id="booking_end"
                                                                            value="{{ $item->booking_end }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-3 col-form-label">รายละเอียดการจอง</label>
                                                            <div class="col-sm-9">
                                                                <textarea name="booking_detail" id="booking_detail" cols="30" rows="3" class="form-control">{{ $item->booking_detail }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" name="saveBooking" value="ยืนยัน"
                                                            id="EditBooking" class="btn btn-primary">
                                                        <button type="button"
                                                            class="btn grey btn-danger"data-bs-dismiss="modal"
                                                            {{-- onclick="window.location.reload()" --}}
                                                            data-dismiss="modal">{{ __('ย้อนกลับ') }}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- modal view detail --}}
                                    <div class="modal fade" id="viewde{{ $item->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewdeLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="viewdeLabel">รายละเอียดการจอง</h1>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        {{-- onclick="window.location.reload()" --}} data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- $item->id --}}
                                                    @if ($item->booking_status == 1)
                                                        <div class="row mb-3">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" disabled
                                                                    value="{{ $item->username }}" readonly
                                                                    class="form-control-plaintext" id="user_book"
                                                                    name="user_book">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">สถานะการจอง</label>
                                                            <div class="col-sm-10">
                                                                <label
                                                                    class=" text-danger form-control-plaintext">กำลังดำเนินการ</label>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                                            <div class="col-sm-10">
                                                                <label class="form-control-plaintext">
                                                                    @php
                                                                        echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                                                    @endphp
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label">รายละเอียดรถและคนขับ</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" disabled value="-" readonly
                                                                    class="form-control-plaintext" id="">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label">รายละเอียดการจอง</label>
                                                            <div class="col-sm-8">
                                                                <textarea name="" id="" cols="30" disabled rows="5"value="" readonly
                                                                    class="form-control-plaintext">{{ $item->booking_detail }}</textarea>
                                                            </div>
                                                        </div>
                                                    @elseif ($item->booking_status == 2)
                                                        <div class="row mb-3">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" disabled
                                                                    value="{{ $item->username }}" readonly
                                                                    class="form-control-plaintext" id="user_book"
                                                                    name="user_book">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">สถานะการจอง</label>
                                                            <div class="col-sm-10">
                                                                <label
                                                                    class=" text-green form-control-plaintext">ดำเนินการเสร็จสิ้น</label>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                                            <div class="col-sm-10">
                                                                <label class="form-control-plaintext">
                                                                    @php
                                                                        echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                                                    @endphp
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @foreach ($booking as $data)
                                                            @if ($data->id == $item->id)
                                                                <div class="row mb-1">
                                                                    <label for=""
                                                                        class="col-sm-3 col-form-label">รายละเอียดรถและคนขับ</label>
                                                                    <div class="col-sm-8">
                                                                        @php
                                                                            if ($item->type_car == 1) {
                                                                                $type = 'รถภายในบริษัท';
                                                                            } else {
                                                                                $type = 'รถภายนอกบริษัท';
                                                                            }
                                                                            
                                                                            if ($item->type_car == 1) {
                                                                                $driver = $data->driver_fullname;
                                                                                $car = $data->car_license;
                                                                            } else {
                                                                                $driver = $data->car_out_driver . ' ' . $data->car_out_tel;
                                                                                $car = $data->car_out_license . ' ' . $data->car_out_model;
                                                                            }
                                                                        @endphp

                                                                        <textarea name="" id="" cols="30" rows="3" readonly class="form-control-plaintext">
คนขับรถ {{ $driver }}
รถที่ใช้เดินทาง {{ $type }} {{ $car }}
                                                                    </textarea>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <div class="row mb-1">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label">รายละเอียดการจอง</label>
                                                            <div class="col-sm-8">
                                                                <textarea name="" id="" cols="30" disabled rows="5"value="" readonly
                                                                    class="form-control-plaintext">{{ $item->booking_detail }}</textarea>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="row mb-3">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" disabled
                                                                    value="{{ $item->username }}" readonly
                                                                    class="form-control-plaintext" id="user_book"
                                                                    name="user_book">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">สถานะการจอง</label>
                                                            <div class="col-sm-10">
                                                                <label
                                                                    class=" text-danger form-control-plaintext">ยกเลิกการจอง</label>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <label for=""
                                                                class="col-sm-2 col-form-label">ช่วงวันที่</label>
                                                            <div class="col-sm-10">
                                                                <label class="form-control-plaintext">
                                                                    @php
                                                                        echo thaidate('วันที่ d M Y เวลา H:i', $item->booking_start) . '&nbsp;-&nbsp;' . thaidate('วันที่ d M Y เวลา H:i', $item->booking_end);
                                                                    @endphp
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @foreach ($booking as $data)
                                                            @if ($data->id == $item->id)
                                                                <div class="row mb-1">
                                                                    <label for=""
                                                                        class="col-sm-3 col-form-label">รายละเอียดรถและคนขับ</label>
                                                                    <div class="col-sm-8">
                                                                        @php
                                                                            if ($item->type_car == 1) {
                                                                                $type = 'รถภายในบริษัท';
                                                                            } else {
                                                                                $type = 'รถภายนอกบริษัท';
                                                                            }
                                                                            
                                                                            if ($item->type_car == 1) {
                                                                                $driver = $data->driver_fullname;
                                                                                $car = $data->car_license;
                                                                            } else {
                                                                                $driver = $data->car_out_driver . ' ' . $data->car_out_tel;
                                                                                $car = $data->car_out_license . ' ' . $data->car_out_model;
                                                                            }
                                                                        @endphp

                                                                        <textarea name="" id="" cols="30" rows="3" readonly class="form-control-plaintext">
คนขับรถ {{ $driver }}
รถที่ใช้เดินทาง {{ $type }} {{ $car }}
                                                                </textarea>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <div class="row mb-1">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label">รายละเอียดการจอง</label>
                                                            <div class="col-sm-8">
                                                                <textarea name="" id="" cols="30" disabled rows="5"value="" readonly
                                                                    class="form-control-plaintext">{{ $item->booking_detail }}</textarea>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-primary text-uppercase"data-bs-dismiss="modal"
                                                        {{-- onclick="window.location.reload()" --}} data-dismiss="modal">ok</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end modal view detail --}}
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        @push('js')
            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    setInterval(() => {
                        console.log('refresh');
                    }, 5000);
                    $('#booking_table').DataTable({
                        responsive: true
                    });
                    //tag input datetime-local เลือกวันย้อนหลังไม่ได้
                    var now_utc = Date.now()
                    var today = new Date(now_utc).toISOString().substring(0, 16);
                    document.getElementById("booking_start").setAttribute("min", today);
                    document.getElementById("booking_end").setAttribute("min", today);
                });

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
                                            confirmButtonText: 'ok',
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
