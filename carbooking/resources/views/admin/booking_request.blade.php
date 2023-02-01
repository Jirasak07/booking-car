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
                                            <div class="btn btn-success btn-sm" onclick="modal({{ $bookings['id'] }})"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
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



            {{-- @include('layouts.footers.auth') --}}
        </div>
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">การอนุมัติคำขอ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-2  row text-xl-center">
                            <div class="col-12 text-center mb-3" style="font-weight: 700">
                                <label for="name">รายการของคุณ :</label>
                                <label class=" ml-2" style="font-size: 80%;" for="" id="name"></label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="" class="form-label "
                                    style="line-height:50%;font-weight: 700">วันเวลาที่เริ่มต้น</label>
                                </br>
                                <label class=" ml-2" style="font-size: 80%;" for="" id="start_date"></label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="" class="form-label"
                                    style="line-height:50%;font-weight: 700">วันเวลาที่สิ้นสุด</label>
                                </br>
                                <label class=" ml-2" style="font-size: 80%;" for="" id="end_date"></label>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="" class="form-label"
                                    style="line-height:50%;font-weight: 700">รายละเอียดการจอง</label>
                                </br>
                                <label class=" ml-2" style="font-size: 80%;" for="" id="detail">11012543</label>
                            </div>
                        </div>
                        <div class="d-grid  justify-content-center row">
                            <div class="container">
                                <ul class="nav nav-tabs d-flex justify-content-center">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tab1">ใช้รถภายใน</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab2">ใช้รถภายนอก</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab1">
                                        <form method="POST" action="{{ route('update') }}"
                                            class="d-flex flex-column align-items-center">
                                            @csrf
                                            <input type="hidden" id="idform" name="id_form">

                                            <input type="hidden" name="type" value="1">
                                            <div class=" mt-4">
                                                <label for="select-car">เลือกรถที่ต้องการใช้</label>

                                                <select name="car_id" id="select-car" class="rounded form-control" required
                                                    style="width: 250px; border:1px solid #6673af30 ">
                                                </select>
                                            </div>
                                            <div>
                                                <label for="select-driver">เลือกพนักงานขับรถ</label>
                                                <select name="driver_id" id="select-driver" class="rounded form-control"
                                                    required style="width: 250px;  border:1px solid #6673af30 ">
                                                </select>
                                            </div>



                                            <div class="d-flex align-self-end justify-content-end w-100 mt-4 ">
                                                <button type="submit" class="btn btn-md btn-success "><i
                                                        class="fa-sharp fa-solid fa-floppy-disk"></i> บันทึก</button>
                                                <button type="button" class="btn btn-md btn-outline-danger "
                                                    data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"><i
                                                        class="fa-solid fa-circle-xmark"></i> ยกเลิก</button>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="tab-pane pt-5" id="tab2">

                                        <div class="card card-body">
                                            <div class="alert alert-danger print-error-msg" style="display:none">
                                                <ul></ul>
                                            </div>
                                            <form method="POST" action="{{ route('updateout') }}">
                                                @csrf
                                                <input type="hidden" id="idform2" name="id_form">
                                                <input type="hidden" name="type" value="2">
                                                <div class="form-group row mt-2 d-flex flex-column flex-md-row ">
                                                    <div class="col-6 "> <label for="out-model">ยี่ห้อ</label>
                                                        <input required type="text" id="out-model" name="brand"
                                                            title="กรุณากรอเบอร์โทรให้ถูกต้อง" class="form-control">
                                                    </div>

                                                    <div class="col-6 ">
                                                        <label for="out-license"> ป้ายทะเบียน </label> <input require
                                                            name="car_out_license" type="text" id="out-license"
                                                            class="form-control">

                                                    </div>
                                                    <div class="col-12 "> <label for="out-model">รายละเอียด/รุ่น</label>
                                                        <input require type="text" id="out-model" name="car_out_model"
                                                            class="form-control">

                                                    </div>

                                                    <div class="col-12 "> <label for="out-driver">คนขับ</label>
                                                        <input require type="text" id="out-driver"
                                                            name="car_out_driver" class="form-control">

                                                    </div>
                                                    <div class="col-12 ">
                                                        <label for="out-own"> เจ้าของรถ </label> <input require
                                                            type="text" id="out-own" class="form-control"
                                                            name="owner">

                                                    </div>
                                                    <div class="col-12 "> <label for="out-tell"> เบอร์โทรติดต่อ
                                                        </label>
                                                        <input require type="number" id="out-tell"
                                                            pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$"
                                                            title="กรุณากรอเบอร์โทรให้ถูกต้อง" class="form-control"
                                                            name="car_out_tel" />

                                                    </div>

                                                </div>
                                                <div class="d-flex justify-content-end mt-2">
                                                    <button id="frm1-approve" type="submit"
                                                        class=" btn  btn-success "><i
                                                            class="fa-sharp fa-solid fa-floppy-disk"></i> บันทึก</button>
                                                    <button type="button" class="btn  btn-outline-danger "
                                                        data-bs-dismiss="modal" aria-label="Close"><i
                                                            class="fa-solid fa-circle-xmark"></i> ยกเลิก</button>
                                                </div>

                                            </form>
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

    </div>


    </div>
    @push('js')
        <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>
        <script src = "https://code.jquery.com/jquery-3.5.1.js" >
        </script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>

        <script>
            // $("#frm1-approve").click(function(e) {
            //     e.preventDefault();
            //     var _token = $("input[name='_token']").val();
            //     var type = $("input[name='type']").val();
            //     var idform = $("input[id='idform']").val();
            //     var brand = $("input[name='brand']").val();
            //     var car_out_license = $("input[name='car_out_license']").val();
            //     var car_out_model = $("input[name='car_out_model']").val();
            //     var car_out_driver = $("input[name='car_out_driver']").val();
            //     var owner = $("input[name='owner']").val();
            //     var car_out_tel = $("input[name='car_out_tel']").val();

            //     $.ajax({
            //         url: "{{ route('updateout') }}",
            //         type: 'POST',
            //         data: {
            //             _token: _token,
            //             type: type,
            //             idform: idform,
            //             brand: brand,
            //             car_out_license: car_out_license,
            //             car_out_model: car_out_model,
            //             car_out_driver: car_out_driver,
            //             owner: owner,
            //             car_out_tel: car_out_tel
            //         },
            //         success: function(data) {
            //             if ($.isEmptyObject(data.error)) {
            //                 alert(data.success);
            //             } else {
            //                 printErrorMsg(data.error);
            //             }
            //         }
            //     })
            // })

            function printErrorMsg(msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }
        </script>
        <script>
            $('.nav-tabs a').on('click', function(e) {
                e.preventDefault()
                $(this).tab('show')
            });
            $(document).ready(function() {
                $('#tablerequest').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 0,
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.hidden ?
                                        '<tr style="font-size:10px" data-dt-row="' + col.rowIndex + '" data-dt-column="' +
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
                document.querySelectorAll('#select-car option').forEach(option => option.remove())
                document.querySelectorAll('#select-driver option').forEach(option => option.remove())
                const data = @json($booking);
                var carselect = @json($car);
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

                const bookstart = moment(JSON.stringify(start[0])).format('ddd ที่ D MMM ' + (new Date(start[0]).getFullYear() +
                    543) + ' เวลา HH:mm');
                const bookend = moment(JSON.stringify(end[0])).format('ddd ที่ D MMM ' + (new Date(end[0]).getFullYear() +
                    543) + ' เวลา HH:mm');

                document.getElementById('start_date').innerHTML = bookstart;
                document.getElementById('end_date').innerHTML = bookend;
                document.getElementById('name').innerHTML = name;
                document.getElementById('detail').innerHTML = detail[0];
                //<================================================================>//
                // กำหนด id ของการจองให้กับ form รถภายในและภายนอก
                document.getElementById('idform').value = val;
                document.getElementById('idform2').value = val;
                //<================================================================>//
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
