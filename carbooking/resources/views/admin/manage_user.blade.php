@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card-dark shadow-sm ">
                <table class=" rounded table table-light  fw-bold table-responsive-sm">
                    <thead class="table-dark">
                        <tr>
                            <th class="fw-bold">ลำดับ</th>
                            <th>ชื่อ</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>tr-Jirasak Singhabutr</td>
                            <td>tr-jirasaks@lanna.com</td>
                            <td>Admin</td>
                            <td>
                                <div class="btn btn-warning btn-sm">แก้ไขบทบาท</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
