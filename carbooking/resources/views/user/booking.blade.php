@section('title', 'ข้อมูลการจอง')

@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <!-- box header booking pages -->
    <div class="pt-5">
        <div class="container-fluid">
            <div class="">
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="card-title text-uppercase text-muted mb-0">การจองทั้งหมด</h3>
                                        <span class="h2 font-weight-bold mb-0">{{ $Alllist }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                            <i class="fa-solid fa-calendar-check"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="card-title text-uppercase text-muted mb-0">ยกเลิการจอง</h3>
                                        <span class="h2 font-weight-bold mb-0">{{ $Alllistcancle }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                            <i class="fa-solid fa-ban"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="card-title text-uppercase text-muted mb-0">กำลังดำเนินการ</h3>
                                        <span class="h2 font-weight-bold mb-0">{{ $Alllistpending }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h3 class="card-title text-uppercase text-muted mb-0">ดำเนินการเสร็จสิ้น</h3>
                                        <span class="h2 font-weight-bold mb-0">{{ $Alllistapprove }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                            <i class="fa-regular fa-circle-check" style="font-size: 24px"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end box header booking pages -->


    <div class="container-fluid mt-4">
        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card shadow-sm p-3 overflow-auto">

                    <table class="overflow-auto table table-hover fw-bold table-responsive-xl" id="booking_table">
                        <thead class="table-light">
                            <tr align="center">
                                <td class="fw-bolder" style="font-size: 18px">ลำดับ</td>
                                <td class="fw-bolder" style="font-size: 18px">ช่วงวันที่</td>
                                <td class="fw-bolder" style="font-size: 18px">รายละเอียดการจอง</td>
                                <td class="fw-bolder" style="font-size: 18px">สถานะการจอง</td>
                                <td class="fw-bolder" style="font-size: 18px">จัดการ</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($booking2 as $item)
                                <tr align="center">
                                    @if ($item->booking_status == 1)
                                        <td style="font-size: 18px">{{ $i++ }}</td>
                                        <td style="font-size: 16px">
                                            @php
                                                echo thaidate('l j F Y', $item->booking_start) . '&nbsp;ถึง&nbsp;' . thaidate('l j F Y', $item->booking_end);
                                            @endphp

                                        </td>
                                        <td>
                                            <button class="btn btn-neutral btn-sm text-darker"data-toggle="modal"
                                                data-target="#viewde{{ $item->id }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </td>
                                        <td>
                                            @if ($item->booking_status == '1')
                                                <button class="btn bg-yellow btn-sm"
                                                    style="font-size: 14px;color:#393E46">กำลังดำเนินการ</button>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-yellow btn-sm me-2" style="font-size: 13px"
                                                data-toggle="modal" data-target="#editde{{ $item->id }}">แก้ไข</button>
                                            <button class="btn btn-danger btn-sm" style="font-size: 13px"
                                                onclick="alertCancel({{ $item->id }})">ยกเลิก</button>
                                        </td>
                                    @else
                                        <td style="font-size: 18px">{{ $i++ }}</td>
                                        <td style="font-size: 16px">
                                            @php
                                                echo thaidate('l j F Y', $item->booking_start) . '&nbsp;ถึง&nbsp;' . thaidate('l j F Y', $item->booking_end);
                                            @endphp
                                        </td>
                                        <td>
                                            <button class="btn btn-neutral btn-sm text-darker"data-toggle="modal"
                                                data-target="#viewde{{ $item->id }}">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </td>
                                        <td>
                                            @if ($item->booking_status == '2')
                                                <i class="fa-solid fa-square-check" style="color: green;font-size:24px"></i>
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
                                                <h1 class="modal-title fs-5" id="viewdeLabel">แก้ไขรายละเอียดการจอง</h1>
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
                                                                        id="booking_end" value="{{ $item->booking_end }}"
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
                                                            <input type="text" disabled value="{{ $item->username }}"
                                                                readonly class="form-control-plaintext" id="user_book"
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
                                                            <input type="text" disabled
                                                                value="{{ $item->booking_start }} ถึง {{ $item->booking_end }}"
                                                                readonly class="form-control-plaintext" id="">
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
                                                            <input type="text" disabled
                                                                value="{{ $item->booking_detail }}" readonly
                                                                class="form-control-plaintext" id="">
                                                        </div>
                                                    </div>
                                                @elseif ($item->booking_status == 2)
                                                    <div class="row mb-3">
                                                        <label for=""
                                                            class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" disabled value="{{ $item->username }}"
                                                                readonly class="form-control-plaintext" id="user_book"
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
                                                            <input type="text" disabled
                                                                value="{{ $item->booking_start }} ถึง {{ $item->booking_end }}"
                                                                readonly class="form-control-plaintext" id="">
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
                                                            <input type="text" disabled
                                                                value="{{ $item->booking_detail }}" readonly
                                                                class="form-control-plaintext" id="">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row mb-3">
                                                        <label for=""
                                                            class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" disabled value="{{ $item->username }}"
                                                                readonly class="form-control-plaintext" id="user_book"
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
                                                            <input type="text" disabled
                                                                value="{{ $item->booking_start }} ถึง {{ $item->booking_end }}"
                                                                readonly class="form-control-plaintext" id="">
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
                                                            <input type="text" disabled
                                                                value="{{ $item->booking_detail }}" readonly
                                                                class="form-control-plaintext" id="">
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


        @push('js')
            <script>
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
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            //console.log('comfirm');
                            $.ajax({
                                type: 'GET',
                                url: "{{ url('/users/cancel') }}/" + id,
                                data: {
                                    _token: CSRF_TOKEN
                                },
                                dataType: 'JSON',
                                success: function(result) {
                                    console.log(result.success);
                                    window.location.reload();
                                },
                            });
                            /* Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ) */
                        }
                    })
                    /* swal.fire({
                        icon: 'question',
                        text: "คุณต้องการยกเลิกการจองคิวรถนี้ใช่หรือไม่",
                        type: "warning", 
                        showCancelButton: !0,
                        confirmButtonText: "ใช่",
                        cancelButtonText: "ไม่",
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d11',

                    }).then(function(e) {

                        if (e.value === true) {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                            $.ajax({
                                type: 'GET',
                                url: "{{ url('/users/cancel') }}/" + id,
                                data: {
                                    _token: CSRF_TOKEN
                                },
                                dataType: 'JSON',
                                success: function(results) {
                                    if (results.success == true) {
                                        swal.fire("Done!", results.message, "success");
                                        // refresh page after 2 seconds
                                        setTimeout(function() {
                                            location.reload();
                                        }, 2000);
                                    } else {
                                        swal.fire("Error!", results.message, "error");
                                    }
                                }
                            });

                        } else {
                            e.dismiss;
                        }

                    }, function(dismiss) {
                        return false;
                    })  */
                }
            </script>
        @endpush

    </div>
@endsection
