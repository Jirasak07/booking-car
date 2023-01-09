@section('title', 'Booking')

@extends('layouts.user.users')
@section('content')
    @include('layouts.user.header')
    <div class="container-fluid mt--7">
        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-darker ls-1 mb-1 fw-bolder">การจอง</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" border="1">
                            <thead class="table-dark ">
                                <tr>
                                    <th></th>
                                    <th>ช่วงวันที่</th>
                                    <th>รายละเอียดการจอง</th>
                                    <th>สถานะการจอง</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>1</th>
                                    <td></td>
                                    <td>
                                        <button class="btn btn-yellow">
                                            รอดำเนินการ
                                        </button>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--  <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-darker ls-1 mb-1 fw-bolder">ประวัติการจอง</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div> --}}
        @include('layouts.footers.auth')
    </div>
@endsection
