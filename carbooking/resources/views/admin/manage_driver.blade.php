@section('title', 'ข้อมูลการจอง')

@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="  shadow-table rounded">
                <table class=" rounded table table-white table-striped fw-bold table-md">
                    <thead class="table-dark table-hover">
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
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
                                    @if ($item['driver_status'] == 1)
                                        <div class="btn btn-success btn-sm " style="width: 80px"
                                            onclick="changeStatus({{ $item['id'] }})">{{ __('ว่าง') }}</div>
                                    @elseif($item['driver_status'] == 2)
                                        <a class="btn btn-danger btn-sm " style="width: 80px"
                                            onclick="changeStatus({{ $item['id'] }})">{{ __('ไม่ว่าง') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    </div>
@endsection
