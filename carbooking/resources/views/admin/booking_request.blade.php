@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="" id="re">
        <div class="container-fulid mx-3 ">
            <div class="container-md pt-3 pb-3 ">
                <div class=" card shadow-table p-3  ">
                    <table id="tablerequest" class="display responsive nowrap " style="width:100%;font-size:0.8em">
                        <thead class="table-dark">
                            <tr>
                                <th class="d-grid d-md-none" style="max-width: 20px"></th>
                                <th style="max-width: 30px">ลำดับ</th>
                                <th>ผู้จอง</th>
                                <th>วันเวลาเริ่มต้น</th>
                                <th>วันเวลาสิ้นสุด</th>
                                <th>รายละเอียด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($booking as $bookings)
                                @if ($bookings['booking_status'] == 1)
                                    <tr>
                                        <td class="control d-grid d-md-none"></td>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $bookings['name'] }}</td>

                                        <td class="text-truncate" style="max-width: 250px">
                                            {{ thaidate('l ที่ j F Y เวลา G:i ', strtotime($bookings['booking_start'])) }}
                                        </td>
                                        <td class="text-truncate" style="max-width: 300px">
                                            {{ thaidate('l ที่ j F Y เวลา G:i ', strtotime($bookings['booking_end'])) }}
                                        </td>
                                        <td>{{ $bookings['booking_detail'] }}</td>
                                        <td>
                                            <div class="btn btn-success btn-sm" onclick="modal({{ $bookings['id'] }})">
                                                <i class="fa-solid fa-check"></i> อนุมัติ
                                            </div>
                                            <a class="text-white btn btn-danger btn-sm "
                                                onclick="alertCancel({{ $bookings['id'] }})"> <i
                                                    class="fa-solid fa-ban"></i> ยกเลิก</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        <!-- Modal -->
        <template id="approve">
            <swal-title>
                <div style="font-size: 0.6em">
                    รายการจองของคุณ : <label for="" id="name"></label>
                </div>
            </swal-title>

            <swal-html>
                <div style="font-size: 13px" class="d-flex flex-column align-items-start">
                    <div>
                        <strong>วันเวลา : </strong> <label for="" id="start_date"></label> - <label for=""
                            id="end_date"></label> <br>
                    </div>
                    <div>
                        <strong>รายละเอียด : </strong> <label for="" id="detail"></label>
                    </div>

                </div>
                <ul class="nav nav-tabs mt-2">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab1" onclick="tab(1)">ใช้รถภายใน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2" onclick="tab(2)">ใช้รถภายนอก</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="mt-1 tab-pane active p-3 " id="tab1">
                        <form action="" id="approveform">
                            @csrf
                            <input type="hidden" name="id_form" id="id_form">
                            <input type="hidden" id="formtab1" value="1">
                            <input type="hidden" name="type" value="1">
                            <label for="">เลือกรถ</label>
                            <select name="car_id" id="select-car" class="rounded form-control" required
                                style="width: 100%; border:1px solid #6673af30 ">
                            </select>
                            <label class="mt-2" for="">เลือกพนักงานขับ</label>
                            <select name="driver_id" id="select-driver" class=" rounded form-control" required
                                style="width: 100%; border:1px solid #6673af30 ">
                            </select>
                        </form>

                    </div>
                    <div class="mt-1 tab-pane p-3 " id="tab2">
                        <form action="" id="approve-out">
                            @csrf
                            <input type="hidden" name="id_form" id="id_form2">
                            <input type="hidden" name="type" value="2">
                            <div class="row">
                                <div class="col-md-6 col-12 mt-1 text-left">
                                    <label for="lplate">ทะเบียน</label>
                                    <input required class="form-control rounded" type="text" name="car_out_license"
                                        id="lplate" style="width: 100%; border:1px solid #6673af30 ">
                                </div>
                                <div class="col-md-6 col-12 mt-1 text-left">
                                    <label for="brand">ยี่ห้อ</label>
                                    <input required class="form-control rounded" type="text" name="brand"
                                        id="brand" style="width: 100%; border:1px solid #6673af30 ">
                                </div>
                                <div class="col-md-6 col-12 mt-1 text-left">
                                    <label for="model">รุ่น</label>
                                    <input required class="form-control rounded" type="text" name="car_out_model"
                                        id="model" style="width: 100%; border:1px solid #6673af30 ">
                                </div>
                                <div class="col-md-6 col-12 mt-1 text-left">
                                    <label for="driver">คนขับ</label>
                                    <input required class="form-control rounded" type="text" name="car_out_driver"
                                        id="driver" style="width: 100%; border:1px solid #6673af30 ">
                                </div>
                                <div class="col-md-6 col-12 mt-1 text-left">
                                    <label for="owner">เจ้าของรถ</label>
                                    <input required class="form-control rounded" type="text" name="owner"
                                        id="owner" style="width: 100%; border:1px solid #6673af30 ">
                                </div>
                                <div class="col-md-6 col-12 mt-1 text-left">
                                    <label for="phone">เบอร์โทรศัพท์</label>
                                    <input required class="form-control rounded" type="text" name="car_out_tel"
                                        id="phone" style="width: 100%; border:1px solid #6673af30 ">
                                </div>
                            </div>


                        </form>

                    </div>
                </div>


            </swal-html>

        </template>
    </div>
    </div>
    </div>


    @push('js')
        <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script>
            function tab(val) {
                if (val == 1) {
                    $('#formtab1').val(1)
                } else {
                    $('#formtab1').val(0)
                }

            }
            $(document).ready(function() {
                $('#tablerequest').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 0,
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.hidden ?
                                        '<tr style="font-size:10px" data-dt-row="' + col.rowIndex +
                                        '" data-dt-column="' +
                                        col.columnIndex + '">' +
                                        '<td>' + col.title + ':' + '</td> ' +
                                        '<td>' + col.data + '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ?
                                    $('<table/>').append(data) :
                                    false;
                            }
                        }
                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 1
                        },
                        {
                            responsivePriority: 10001,
                            targets: 4
                        },
                        {
                            responsivePriority: 2,
                            targets: -1
                        }
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

            function modal(val) {
                const data = @json($booking);
                var carselect = @json($car);
                // ใช้แสดงข้อมูลรายละเอียดการจอง บน Modal
                const bookdata = [];
                moment.locale('th');
                const start = [];
                const end = [];
                const detail = [];
                const name = [];
                data.forEach(showBooking => {
                    if (showBooking.id == val) {
                        start.push(showBooking.booking_start);
                        name.push(showBooking.name);
                        end.push(showBooking.booking_end);
                        detail.push(showBooking.booking_detail);
                    }
                });
                Swal.fire({
                    template: '#approve',
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonColor: '#06d6a0',
                    cancelButtonColor: '#ef476f',
                    confirmButtonText: '<i class="fa-sharp fa-solid fa-floppy-disk"> บันทึก',
                    cancelButtonText: '<i class="fa-solid fa-circle-xmark"> ยกเลิก',
                }).then((res) => {
                    if (res.isConfirmed) {
                        var formid = $('#formtab1').val()
                        if (formid == 1) {
                            var frm = $('#approveform').serialize();
                            console.log(frm)
                            $.ajax({
                                url: "{{ route('update') }}",
                                type: "POST",
                                data: frm,
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'อนุมัติเสร็จสิ้น !!',
                                    }).then((res) => {
                                        window.location.reload()
                                    })
                                },
                                error: function(response) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'กรุณากรอกข้อมูลให้ถูกต้อง'
                                    })
                                },
                            });

                        } else {

                            var frm = $('#approve-out').serialize();
                            $.ajax({
                                url: "{{ route('updateout') }}",
                                type: "POST",
                                data: frm,
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'อนุมัติเสร็จสิ้น !!',
                                    }).then((res) => {
                                        window.location.reload()
                                    })
                                },
                                error: function(response) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'กรุณากรอกข้อมูลให้ถูกต้อง'
                                    })
                                },
                            });
                        }
                    }
                })
                document.querySelectorAll('#select-car option').forEach(option => option.remove())
                document.querySelectorAll('#select-driver option').forEach(option => option.remove())
                $('#name').text(name);
                const bookstart = moment(JSON.stringify(start[0])).format('ddd ที่ D MMM ' + (new Date(start[0]).getFullYear() +
                    543) + ' เวลา HH:mm');
                const bookend = moment(JSON.stringify(end[0])).format('ddd ที่ D MMM ' + (new Date(end[0]).getFullYear() +
                    543) + ' เวลา HH:mm');

                // document.getElementById('start_date').innerHTML = bookstart;
                $('#start_date').text(bookstart)
                $('#end_date').text(bookend)
                $('#detail').text(detail[0])
                $('#id_form').val(val);
                $('#id_form2').val(val);
                $.ajax({
                    type: 'GET',
                    url: '/admin/manage/' + val,
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data.driver)
                        var car = data.car
                        var driver = data.driver
                        // เช็ครถว่างหรือไม่ว่างใน Select option ตอนกดอนุมัติ
                        car.forEach(carsel => {
                            $('#select-car').append($('<option>', {
                                value: carsel.id,
                                text: carsel.car_model + ' ทะเบียน ' + carsel.car_license
                            }))
                        })
                        driver.forEach(driver => {
                            $('#select-driver').append($('<option>', {
                                value: driver.id,
                                text: driver.driver_fullname
                            }))
                        })

                    },
                    //<================================================================>//
                })

            }
        </script>
        <script>
            function alertCancel(id) {
                const data = @json($booking);
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
                            title: 'ยกเลิกรายการ',
                            input: 'text',
                            // inputLabel: '<div>jjj</div>รายการจองของ ' + namecancel[0].name,
                            html: '<div class="d-flex justify-content-center" ><div style="width: max-content;"> <div class="text-left" style="font-size:0.9rem;">เจ้าของรายการ : ' +
                                namecancel[0].name + '</div> <div style="font-size:0.9rem;" >ระหว่างวันที่ : ' +
                                bstart + '-' + bend +
                                '</div><div class="text-left" style="font-size:0.9rem">รายละเอียด : ' +
                                namecancel[0].booking_detail + ' </div> </div></div>',
                            inputPlaceholder: 'กรอกหมายเหตุ',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#06d6a0',
                            cancelButtonColor: '#ef476f',
                            confirmButtonText: '<i class="fa-sharp fa-solid fa-floppy-disk"> บันทึก',
                            cancelButtonText: '<i class="fa-solid fa-ban"> ยกเลิก',

                        }).then((result) => {
                            console.log(result)
                            if (result.isConfirmed) {
                                if (result.value) {
                                    $.ajax({
                                        type: 'GET',
                                        url: '/admin/cancel/' + id + '/' + result.value,
                                        dataType: 'JSON',
                                        success: function(data) {
                                            if (data.status == 'success') {
                                                Swal.fire({
                                                    title: 'เสร็จสิ้น',
                                                    icon: 'success',
                                                    confirmButtonText: 'ok',
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
        </script>
    @endpush
@endsection
