@section('title', 'ข้อมูลการจอง')

@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card-dark shadow-table ">
                <table class=" rounded table table-white table-striped fw-bold table-responsive-sm">
                    <thead class="table-dark">
                        <tr>
                            <th class="fw-bold" align="center">ลำดับ</th>
                            <th align="center">ชื่อ</th>
                            <th align="center">Email</th>
                            <th align="center">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $Users)
                            <tr>
                                <td>1</td>
                                <td>{{ $Users->username }}</td>
                                <td>{{ $Users->email }}</td>
                                <td>
                                    <div class="btn-group dropright" style="width: 30px">
                                        <button type="button" class="btn btn-sm btn-default" style="width: 50px">
                                            {{ $Users->role_user == 1 ? 'Admin' : 'User' }}

                                        </button>
                                        <i class="fa-solid fa-pen-to-square btn btn-warning btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"
                                            onclick='changeRole({{ $Users->role_user }},{{ $Users->id }})'>
                                        </i>
                                        {{-- <div class="dropdown-menu">

                                            @if ($Users->role_user == 1)
                                                <option value="1" class="option active"style="font-weight: 900" disabled >Admin
                                                </option>
                                                <option value="2" class="option" '>user</option>
                                            @elseif ($Users->role_user == 2)
                                                <option value="1" class="option" onclick="changeRole(1)">Admin</option>
                                                <option value="2" class="option active" style="font-weight: 900" disabled>User
                                                </option>
                                            @endif

                                        </div> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                        title: 'เสร็จสิ้น',
                                        icon: 'success',
                                        confirmButtonText: 'ok',
                                    }).then((result) => {
                                        /* Read more about isConfirmed, isDenied below */
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    })

                                } else if (data.status == 'error') {
                                    Swal.fire({
                                        title: 'ไม่สามารถเปลี่ยนได้',
                                        icon: 'error',
                                    })
                                }
                            }
                        })
                    }else {

                    }

                })
            }
        </script>
    </div>
@endsection
