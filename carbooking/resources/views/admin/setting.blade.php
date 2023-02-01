@extends('layouts.layout')
@section('content')
    @include('layouts.header')

    <div class="container  ">
        <div class="mx-sm-3 mt-5 bg-white rounded ">
            <div class="text-capitalize pt-3 pl-3"><i class="fa-solid fa-gears mr-3"
                    style="font-size: 2rem;"></i>ตั้งค่าข้อมูลพื้นฐานของระบบ</div>
            <div class="d-flex flex-md-row flex-column justify-constent-center  pt-3 px-3" style="gap: 10px">
                <table class="table table-white table-striped table-bordered">
                    <thead class="table-dark ">
                        <tr>
                            <th>ชื่อรายการ</th>
                            <th>ค่าข้อมูล</th>
                            <th>หน่วย</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>
                                <div class="btn btn-info btn-sm" onclick="showModal()">
                                    Edit
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ตั้งค่า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-12">
                        <label for="">รายการ :</label><br />
                    </div>
                    <div class="col-6 ">
                        <label for="">จำนวน :</label>
                        <input required type="number" name="" id=""
                            style="border: 0.2px solid #DADDD8;border-radius: 5px;width:80px">
                    </div>
                    <div class="col-6">
                        <label for="" class="ml-2">หน่วย :</label><select class="ml-2 p-1" name=""
                            id="" style="border: 0.2px solid #DADDD8;border-radius: 5px;font-size:13px">
                            <option value="1">ชั่วโมง</option>
                            <option value="2">วัน</option>
                            <option value="3">เดือน</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">บันทึก</button>
                    <button class="btn btn-danger btn-sm" onclick="closeModal()">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        function showModal() {
            $('#exampleModal').modal('toggle');
        }

        function closeModal() {
            $('#exampleModal').modal('hide');
        }
    </script>
@endsection
