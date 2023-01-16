@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
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
                            <th align="center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>tr-Jirasak Singhabutr</td>
                            <td>tr-jirasaks@lanna.com</td>
                            <td>
                                <div class="text-danger  text-capitalize " style="width: 50px;font-weight:bold">admin</div>
                            </td>
                            <td>
                                <div class="btn text-white  btn-sm" style="background-color: #ffb500"><i class="fa-solid fa-user-pen"></i></div>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>tr-Patcharawan Gedpun</td>
                            <td>tr-patcharawang@lanna.com</td>
                            <td>
                                <div class="text-dark text-capitalize " style="width: 50px;font-weight:bold">user</div>
                            </td>
                            <td>
                                <div class="btn text-white bg-yellow btn-sm"><i class="fa-solid fa-user-pen"></i></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
