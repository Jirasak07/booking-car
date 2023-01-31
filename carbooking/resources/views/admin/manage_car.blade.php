@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card p-2 shadow-table rounded ">
                <table id="tabledcar1"class="display responsive nowrap " style="width:100%;font-size:0.8em">
                    <thead class="table-dark">
                        <tr>
                            <th style="max-width: 30px">ลำดับ</th>
                            <th>หมายเลขทะเบียน</th>
                            <th>รายละเอียดรถ</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 1
                        @endphp
                        @foreach ($car as $cars)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $cars['car_license'] }}</td>
                                <td>{{ $cars['car_model'] }}</td>
                                <td>
                                    <div class='{{ $cars['car_status'] == 1 ? 'btn btn-success btn-sm ' : 'btn btn-danger btn-sm' }}'
                                        style="width: 90px" onclick="changeStatus({{ $cars['id'] }})">
                                        {{ $cars['car_status'] == 1 ? 'พร้อมใช้งาน' : 'ไม่พร้อมใช้งาน' }}</div>
                                </td>
                            </tr>
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
        <script>
            $(document).ready(function() {
                $('#tabledcar1').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },

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
            function changeStatus(e) {
                Swal.fire({
                    title: 'ต้องการเปลี่ยนสถานะหรือไม่ ?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#06d6a0',
                    cancelButtonColor: '#ef476f',
                    confirmButtonText: 'ตกลง',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/manage-car/' + e,
                            method: 'GET',
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'เปลี่ยนสถานะเสร็จสิ้น',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then((res) => {
                                        window.location.reload();
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        icon: 'error',

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
