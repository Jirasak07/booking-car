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
                        @foreach($user as $Users)
                        <tr>
                            <td>1</td>
                            <td>{{$Users->username}}</td>
                            <td>{{$Users->email}}</td>
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
                        </tr> @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
