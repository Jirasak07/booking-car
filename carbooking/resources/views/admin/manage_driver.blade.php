@section('title', 'ข้อมูลการจอง')
@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class=" card p-2 shadow-table rounded">
                <table id="tabledriver" class="display responsive nowrap " style="width:100%;font-size:0.8em">
                    <thead class="table-dark table-hover">
                        <tr>
                            <td style="max-width: 30px">ลำดับ</td>
                            <td>รายชื่อ</td>
                            <td>สถานะ</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($driver as $item)
                            <tr>
                                <td>{{ $item['id'] }}</td>
                                <td>{{ $item['driver_fullname'] }}</td>
                                <td>
                                        <div class='{{ $item['driver_status']==1? 'btn btn-success btn-sm ':'btn btn-danger btn-sm'}}' style="width: 80px"
                                            onclick="changeStatus({{ $item['id'] }})">{{$item['driver_status']==1? 'ว่าง':'ไม่ว่าง'}}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @push('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function(){
                    $('#tabledriver').DataTable({
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
                                url: '/admin/manage-driver/' + e,
                                method: 'GET',
                                success: function(data) {
                                    if (data.status == 'success') {
                                        Swal.fire({
                                            title: 'เสร็จสิ้น',
                                            icon: 'success',
                                            confirmButtonText: 'ok',
                                        }).then((result) => {
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
                                }
                            })

                        }
                    })
                }
            </script>
        @endpush
    </div>
@endsection
