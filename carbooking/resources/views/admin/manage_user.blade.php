@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card p-2 shadow-table ">
                <table id="tableuser"class="display responsive nowrap " style="width:100%;font-size:0.8em">
                    <thead class="table-dark" style="width: max-content">
                        <tr>
                            <th class="fw-bold">ลำดับ</th>
                            <th>ชื่อ</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($user as $Users)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $Users->username }}</td>
                                <td>{{ $Users->email }}</td>
                                <td>
                                    <div class="row" style="width: 100px">
                                        <div class="justify-content-center  d-flex align-items-center rounded-0  {{ $Users->role_user == 1 ? 'text-danger' : 'text-dark' }} "
                                            style="width: 50px;font-weight:800;">
                                            {{ $Users->role_user == 1 ? 'Admin' : 'User' }}

                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <div onclick='changeRole({{ $Users->role_user }},{{ $Users->id }})'
                                        class="btn-sm btn text-white btn-warning border-0"
                                        style="width: 90px;background-color:#ffca3a;">
                                        <i class="fa-solid fa-pen-to-square" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        </i>
                                        แก้ไข
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @push('js')
            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                $(document).ready(function() {
                    $('#tableuser').DataTable({
                        responsive: {
                            details: {
                                type: 'column',
                                target: 'tr'
                            }
                        },
                        columnDefs: [{

                            orderable: false,
                            targets: 0
                        }],
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
                    })
                })
            </script>
            <script>
                function changeRole(e, val2) {
                    const name = e;
                    var role = 0;
                    if (e == 2) {
                        var namerole = 'Admin';
                        role = 1;
                    } else if (e == 1) {
                        var namerole = 'User';
                        role = 2;
                    }
                    Swal.fire({
                        title: 'ต้องการเปลี่ยนเป็น' + namerole + 'หรือไม่ ?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#06d6a0',
                        cancelButtonColor: '#ef476f',
                        confirmButtonText: 'ตกลง',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/admin/manage-role/' + val2,
                                method: 'GET',
                                success: function(data) {
                                    if (data.status == 'success') {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'เปลี่ยนสถานะสิทธิ์เสร็จสิ้น',
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then((res) => {
                                            window.location.reload();
                                        })

                                    } else if (data.status == 'error') {
                                        Swal.fire({
                                            title: 'ไม่สามารถเปลี่ยนได้',
                                            icon: 'error',
                                        })
                                    }
                                }
                            })
                        } else {

                        }

                    })
                }
            </script>
        @endpush
    </div>
@endsection
