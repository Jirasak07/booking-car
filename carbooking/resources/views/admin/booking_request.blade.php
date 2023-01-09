@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-sm ">
        <div class="container p-md-2 p-1 mt-sm-2 mt-sm-1 mt-2">
            <div class="card shadow-sm p-3 overflow-auto">
              <table class="overflow-auto table table-md table-hover fw-bold table-responsive-xl">
                    <thead class="table-light" >
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
                            <td>ผู้จอง</td>
                            <td>วันเวลาเริ่มต้น</td>
                            <td>วันเวลาสิ้นสุด</td>
                            <td>รายละเอียด</td>
                            <td>จัดการ</td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>จิรศักดิ์ สิงหบุตร</td>
                            <td>11/01/2566 16:00</td>
                            <td>12/01/2565 09:30</td>
                            <td>ส่งเอกสาร มช</td>
                            <td>
                                <div class="btn btn-warning btn-sm">อนุมัติ</div>
                                <div class="btn btn-danger btn-sm">ยกเลิก</div>
                            </td>
                        </tr>
                    </tbody>
              </table>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>

@endsection
