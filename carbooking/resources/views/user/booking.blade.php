@section('title', 'Booking')

@extends('layouts.user.users')
@section('content')
    @include('layouts.user.header')
    <div class="container-fluid mt--7">
        <div class="row mb-3">
            <div class="col-xl-12">
                <div class="card shadow-sm p-3 overflow-auto">
                    <table class="overflow-auto table  table-hover fw-bold table-responsive-xl">
                        <thead class="table-light">
                            <tr align="center">
                                <td class="fw-bolder">ลำดับ</td>
                                <td class="fw-bolder">ช่วงวันที่</td>
                                <td class="fw-bolder">รายละเอียดการจอง</td>
                                <td class="fw-bolder">สถานะการจอง</td>
                                <td class="fw-bolder">จัดการ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td align="center">1</td>
                                <td>วันที่เดินทางไป ถึง วันที่เดินทางกลับ</td>
                                <td align="center">
                                    <button class="btn btn-neutral btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewde">ดู</button>
                                </td>
                                <td align="center">

                                    <button class="btn btn-yellow btn-sm">กำลังดำเนินการ</button>
                                </td>
                                <td align="center">
                                    <button class="btn btn-danger btn-sm">ยกเลิก</button>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">2</td>
                                <td>วันที่เดินทางไป ถึง วันที่เดินทางกลับ</td>
                                <td align="center">
                                    <button class="btn btn-neutral btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewde">ดู</button>
                                </td>
                                <td align="center">
                                    <button class="btn btn-dark btn-sm me-2">ดำเนินการเสร็จสิ้น</button>
                                    <button class="btn btn-danger btn-sm me-2">ถูกยกเลิก</button>
                                    
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal view detail -->
        <div class="modal fade" id="viewde" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="viewdeLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewdeLabel">รายละเอียดการจอง</h1>
                        <button type="button" class="close" onclick="window.location.reload()" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="" class="col-sm-2 col-form-label">ชื่อผู้จอง</label>
                            <div class="col-sm-10">
                                <input type="text" disabled value="ตัวแปรชื่อผู้จอง" readonly
                                    class="form-control-plaintext" id="user_book" name="user_book">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="" class="col-sm-2 col-form-label">ช่วงวันที่</label>
                            <div class="col-sm-10">
                                <input type="text" disabled value="วันที่เดินทางไป ถึง วันที่เดินทางกลับ" readonly
                                    class="form-control-plaintext" id="">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="" class="col col-form-label">รายละเอียดรถและคนขับ</label>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <input type="text" disabled value="ทะเบียนรถ ยี่ห้อและชื่อคนขับ" readonly
                                class="form-control-plaintext" id="user_book" name="user_book">
                        </div>
                        <div class="row mb-1">
                            <label for="" class="col col-form-label">รายละเอียดการจอง</label>
                        </div>
                        <div class="row mb-3">
                            <textarea type="text" class="form-control-plaintext" disabled readonly id="location" name="location">
                                -สถานที่การเดินทาง
                                -ชื่อผู้ร่วมเดินทาง
                            </textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary text-uppercase"
                            onclick="window.location.reload()">ok</button>
                    </div>
                </div>
            </div>
        </div>
        @push('js')
            <script></script>
        @endpush
        @include('layouts.footers.auth')
    </div>
@endsection
