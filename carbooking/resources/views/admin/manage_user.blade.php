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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>tr-Jirasak Singhabutr</td>
                            <td>tr-jirasaks@lanna.com</td>
                            <td>
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-secondary">
                                        Split dropend
                                    </button>
                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown" >

                                    </button>
                                    <ul class="dropdown-menu">
                                        <!-- Dropdown menu links -->
                                    </ul>
                                </div>
                            </td>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
