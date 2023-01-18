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
                                            @if ($Users->role_user == 1)
                                                Admin
                                            @elseif ($Users->role_user == 2)
                                                User
                                            @endif
                                        </button>
                                        <i class="fa-solid fa-pen-to-square btn btn-warning btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        </i>
                                        <div class="dropdown-menu">
                                            @if ($Users->role_user == 1)
                                                <option value="1" class="option active"style="font-weight: 900">Admin
                                                </option>
                                                <option value="2" class="option" onclick='changeRole(2)'>user</option>
                                            @elseif ($Users->role_user == 2)
                                                <option value="1" class="option" onclick="changeRole(1)">Admin</option>
                                                <option value="2" class="option active" style="font-weight: 900">User
                                                </option>
                                            @endif

                                        </div>
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
            function changeRole(e) {
                const name = e;
                if (e == 1) {
                    var namerole = 'Admin';
                } else if (e == 2) {
                    var namerole = 'User';
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
                        Swal.fire({
                            title: 'เสร็จสิ้น',
                            icon: 'success',
                        })
                    }
                })
            }
        </script>
    </div>
@endsection
