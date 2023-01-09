@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-sm ">
        <div class="container p-md-2 p-1 mt-sm-2 mt-sm-1 mt-2">
            <div class="card shadow-sm p-3 overflow-auto">

                <table class="overflow-auto table table-md table-hover fw-bold table-responsive-xl">
                    <thead class="table-light">
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
                                <div class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    อนุมัติ</div>
                                <div class="btn btn-danger btn-sm">ยกเลิกคำขอ</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- @include('layouts.footers.auth') --}}
    </div>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">การอนุมัติคำขอ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid  justify-content-center row gap">
                        <div class="form-check col-5 " onclick="chkform()">
                            <input class="form-check-input" type="radio" name="g" onclick="myfunction()"
                                value="1" checked>
                            <label class="form-check-label" for="1">
                                ใช้รถภายใน
                            </label>
                        </div>
                        <div class="form-check col-5 ">
                            <input class="form-check-input" type="radio" name="g" onclick="myfunction()"
                                value="2">
                            <label class="form-check-label" for="2">
                                ใช้รถภายนอก
                            </label>
                        </div>
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">อนุมัติ</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>

                </div>
            </div>
        </div>
    </div>
    <script>
        function chkform(){
            var rd1 = 
        }
    </script>
@endsection
