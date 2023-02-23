@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-sm mx-3 mt-2 pt-3">
        <div class=" card p-2   ">
            <table id="tablehistory" class="display responsive nowrap " style="width:100%;font-size:0.8em">
                <thead class="table-dark table-hover">
                    <tr>
                        <th style="max-width: 30px">ลำดับ</th>
                        <th>ผู้จอง</th>
                        <th>วันเวลาเริ่มต้น</th>
                        <th>วันเวลาสิ้นสุด</th>
                        <th>สถานะ</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($hiss as $history)
                        @if ($history['booking_status'] != 1)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $history['name'] }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($history['booking_start'])) }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($history['booking_end'])) }}</td>
                                <td>
                                    <i class='{{ $history['booking_status'] == 3 ? 'fa-solid fa-square-xmark text-danger ' : 'fa-solid fa-square-check text-success' }}'
                                        style="font-size: 2em"></i>
                                </td>
                                <td>
                                    <div class="btn btn-sm bg-primary text-white"
                                        onclick="showDetailHistory({{ $history['id'] }})"> <i class="fa-solid fa-eye"></i>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <template id="my-template">
        <swal-html>
            <form action="" id="formedit">
                @csrf
                <input type="hidden" name="id_form" id="id_form">
                <div>
                    <swal-input-label>เลือกรถ</swal-input-label>
                    <select id="car-select" class="swal2-input" name="license" style="width: 80%;font-size:14px">
                    </select>
                </div>
                <div class="mt-2">
                    <swal-input-label for="driver-select">เลือกพนักงานขับ</swal-input-label>
                    <select id="driver-select" class="swal2-input" name="driver" style="width: 80%;font-size:14px">
                    </select>
                </div>
            </form>

        </swal-html>
    </template>

    </div>
    @push('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://momentjs.com/downloads/moment.min.js"></script>
        <script src="https://momentjs.com/downloads/moment-with-locales.js"></script>

        <script>
            $(document).ready(function() {
                $('#tablehistory').DataTable({
                    responsive: {
                        details: false
                    },
                    columnDefs: [{
                            responsivePriority: 1,
                            targets: 4
                        },
                        {
                            responsivePriority: 2,
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
            })
        </script>

        <script>
            var his = @json($hiss);
        </script>
        <script>
            function showDetailHistory(id) {
                var datenow = moment(new Date()).format('yyyy-MM-DD H:mm:ss')
                moment.locale('th');
                $.ajax({
                    url: '/admin/history/' + id,
                    method: 'GET',
                    success: function(data) {
                        var detail = data.detail;
                        console.log(detail)
                        var start = moment(detail[0].sdate).format('D MMM ' + (new Date(detail[0].sdate)
                            .getFullYear() + 543) + ' เวลา  H:mm น. - ')
                        var end = moment(detail[0].edate).format('D MMM ' + (new Date(detail[0].edate)
                            .getFullYear() + 543) + ' เวลา  H:mm น. ')
                        var status = detail[0].booking_status;
                        var driver = detail[0].driver;
                        var car = detail[0].car_detail + ' ทะเบียน ' + detail[0].car
                        var det = String(detail[0].booking_detail).split("~")
                        var tf = ''
                        if (status != 3) {
                            (detail[0].type_car == 1 ? (tf = true) : (tf = false))
                        } else {
                            tf = false
                        }
                        Swal.fire({
                            title: '<div style="font-size:50%" > รายการจองของคุณ : ' + detail[0].user +
                                ' </div>',
                            html: '<div class=" d-flex justify-content-center "> <div style="width: max-content;"><div class="text-left" style="font-size:0.9rem;">ระยะเวลา : ' +
                                start + end +
                                ' </div><div  class="text-left" style="font-size:0.9rem;" >รายละเอียด : ' +
                                det[0] +
                                '</div><div class="text-left" style="font-size:0.9rem" >พนักงานขับ : ' +
                                (status != 3 ? driver : '-') +
                                '</div><div class="text-left" style="font-size:0.9rem"> รถที่ใช้ : ' + (
                                    status != 3 ? car : '-') +
                                ' </div> <div  class="text-left" style="font-size:0.9rem">สถานะ : ' + (
                                    status != 3 ? 'อนุมัติ' : 'ยกเลิก') +
                                '</div> <div  class="text-left" style="font-size:0.9rem">หมายเหตุ : ' + (
                                    status != 3 ? '-' : det[1]) + '</div> </div> </div>',
                            icon: (status != 3 ? 'success' : 'error'),
                            showCancelButton: (status == 2 ? true : false),
                            showDenyButton: (tf ? true : false),
                            confirmButtonText: '<i class="fa-solid fa-check"> ตกลง',
                            denyButtonText: '<i class="fa-solid fa-pen-to-square"> แก้ไข',
                            cancelButtonText: '<i class="fa-solid fa-ban"> ยกเลิกรายการ',
                            showDeniedButton: true,
                            confirmButtonColor: '#06d6a0',
                            denyButtonColor: '#ffb703',
                            cancelButtonColor: '#ef476f',
                            focusConfirm: false,
                            showCloseButton: true,
                        }).then((res) => {
                            if (res.dismiss == 'cancel') {
                                if (detail[0].sdate > datenow) {
                                    Swal.fire({
                                        input: 'text',
                                        icon: 'warning',
                                        title: 'กรุณากรอกหมายเหตุการยกเลิก',
                                        inputPlaceholder: 'หมายเหตุการยกเลิก',
                                        confirmButtonText: 'บันทึก',
                                        showCancelButton: true,
                                        cancelButtonColor: '#ef476f',
                                        confirmButtonColor: '#06d6a0',
                                        cancelButtonText: 'ยกเลิก'
                                    }).then((resp) => {
                                        if (resp.isConfirmed) {
                                            if (resp.value) {
                                                $.ajax({
                                                    type: 'GET',
                                                    url: '/admin/cancel/' + id + '/' + resp
                                                        .value,
                                                    dataType: 'JSON',
                                                    success: function(data) {
                                                        if (data.status == 'success') {
                                                            Swal.fire({
                                                                title: 'เสร็จสิ้น',
                                                                icon: 'success',
                                                                confirmButtonText: 'ok',
                                                            }).then((data) => {
                                                                window.location
                                                                    .reload();
                                                            })
                                                        } else {
                                                            Swal.fire({
                                                                title: 'เกิดข้อผิดพลาด',
                                                                icon: 'error',
                                                            })
                                                        }
                                                    },
                                                });
                                            } else {
                                                Swal.fire({
                                                    text: 'กรุณากรอกข้อมูล',
                                                    icon: 'error'
                                                })
                                            }
                                        }
                                    })
                                } else if (detail[0].sdate < datenow) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ไม่สามารถแก้ไข หรือยกเลิกรายการนี้',
                                        text: 'เนื่องจากกำลังดำเนินการ'
                                    })
                                }
                            } else if (res.isDenied == true) {
                                if (detail[0].sdate > datenow) {
                                    $.ajax({
                                        type: 'GET',
                                        url: '/admin/manage-carin/' + id,
                                        dataType: 'JSON',
                                        success: function(data) {
                                            console.log(data.driver)
                                            var car = data.car
                                            var driver = data.driver
                                            // เช็ครถว่างหรือไม่ว่างใน Select option ตอนกดอนุมัติ
                                            car.forEach(carsel => {
                                                $('#car-select').append($('<option>', {
                                                    value: carsel.id,
                                                    text: carsel.car_model +
                                                        ' ทะเบียน ' + carsel
                                                        .car_license
                                                }))
                                            })
                                            driver.forEach(driver => {
                                                $('#driver-select').append($(
                                                    '<option>', {
                                                        value: driver.id,
                                                        text: driver
                                                            .name
                                                    }))
                                            })
                                            $('#id_form').val(id);
                                        },
                                    })
                                    Swal.fire({
                                        template: '#my-template',
                                        title: 'แก้ไขรายละเอียดการจอง',
                                        confirmButtonText: 'Save',
                                        confirmButtonColor: '#06d6a0',
                                        focusConfirm: false,
                                        showCancelButton: true,
                                        cancelButtonText: 'cancel',
                                        cancelButtonColor: '#ef476f',
                                        focusCancel: false,
                                    }).then((res) => {
                                        if (res.isConfirmed) {
                                            var frm = $('#formedit').serialize();
                                            console.log(frm)
                                            $.ajax({
                                                url: "edit-book",
                                                type: "POST",
                                                data: frm,
                                                success: function(response) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'แก้ไขเสร็จสิ้น !!',
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
                                    })
                                } else if (detail[0].sdate < datenow) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'ไม่สามารถแก้ไข หรือยกเลิกรายการนี้',
                                        text: 'เนื่องจากกำลังดำเนินการ',

                                    })
                                }

                            }
                        })
                    }
                })
            }
        </script>
    @endpush
@endsection
