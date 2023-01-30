@section('title', 'ข้อมูลการจอง')
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
                        @if ($history['booking_status'] == 2 || $history['booking_status'] == 3)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $history['name'] }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($history['booking_start'])) }}</td>
                                <td>{{ thaidate('l ที่ j F Y เวลา G:i นาที', strtotime($history['booking_end'])) }}</td>
                                <td>
                                    <i class='{{ $history['booking_status'] == 2 ? 'fa-solid fa-square-check text-success' : 'fa-solid fa-square-xmark text-danger ' }}'
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
            console.log(his)
        </script>
        <script>
            function showDetailHistory(id) {
                moment.locale('th');
                $.ajax({
                    url: '/admin/history/' + id,
                    method: 'GET',
                    success: function(data) {
                        var detail = data.detail;
                        console.log(data)
                        var start = moment(detail[0].sdate).format('D MMM ' + (new Date(detail[0].sdate)
                            .getFullYear() + 543) + ' เวลา  H:mm น. - ')
                        var end = moment(detail[0].edate).format('D MMM ' + (new Date(detail[0].edate)
                            .getFullYear() + 543) + ' เวลา  H:mm น. ')
                        var status = detail[0].booking_status;
                        var driver = detail[0].driver;
                        var car = detail[0].car_detail + ' ทะเบียน ' + detail[0].car
                        var det = String(detail[0].booking_detail).split("~")
                        Swal.fire({
                            title: '<div style="font-size:50%" > รายการจองของคุณ : ' + detail[0].name_user +
                                ' </div>',
                            html: '<div class=" d-flex justify-content-center "> <div style="width: max-content;"><div class="text-left" style="font-size:0.9rem;">ระยะเวลา : ' +
                                start + end +
                                ' </div><div  class="text-left" style="font-size:0.9rem;" >รายละเอียด : ' +
                                det[0] +
                                '</div><div class="text-left" style="font-size:0.9rem" >พนักงานขับ : ' +
                                driver +
                                '</div><div class="text-left" style="font-size:0.9rem"> รถที่ใช้ : ' + (
                                    status == 2 ? car : '-') +
                                ' </div> <div  class="text-left" style="font-size:0.9rem">สถานะ : ' + (
                                    status == 2 ? 'อนุมัติ' : 'ยกเลิก') +
                                '</div> <div  class="text-left" style="font-size:0.9rem">หมายเหตุ : ' + (
                                    status == 2 ? '-' : det[1]) + '</div> </div> </div>',
                            icon: (status == 2 ? 'success' : 'error'),
                            showCancelButton: (status == 2 ? true : false),
                            confirmButtonText: '<i class="fa-solid fa-check"> ตกลง',
                            cancelButtonText: '<i class="fa-solid fa-ban"> ยกเลิกรายการ',
                            showDeniedButton: true,
                            confirmButtonColor: '#06d6a0',
                            cancelButtonColor: '#ef476f',
                        }).then((res) => {
                            console.log(res)
                            if (res.dismiss == 'cancel') {
                                Swal.fire({
                                    input: 'text',
                                    icon:'warning',
                                    title: 'กรุณากรอกหมายเหตุการยกเลิก',
                                    inputPlaceholder: 'หมายเหตุการยกเลิก',
                                    confirmButtonText: 'บันทึก',
                                    showCancelButton: true,
                                    cancelButtonColor:'#ef476f',
                                    confirmButtonColor:'#06d6a0',
                                    cancelButtonText:'ยกเลิก'
                                }).then((resp) => {
                                    if (resp.isConfirmed) {
                                        if(resp.value){
                                            alert(resp.value)
                                        }else{
                                            Swal.fire({
                                                text:'กรุณากรอกข้อมูล',
                                                icon:'error'
                                            })
                                        }
                                    }
                                })
                            }
                        })
                    }
                })

            }
        </script>
    @endpush
@endsection
