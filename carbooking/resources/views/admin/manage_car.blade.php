@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-fulid mx-5 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card-dark shadow-sm ">
                <table class=" rounded table table-light  fw-bold table-responsive-sm">
                    <thead class="table-dark">
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
                            <td>หมายเลขทะเบียน</td>
                            <td>รายละเอียดรถ</td>
                            <td>สถานะ</td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1กงฏ ตาก 34554</td>
                            <td>Honda Wave125i</td>
                            <td>
                                <div class="btn btn-danger btn-sm">"ตัวแปรชื่อ สถานะ"</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
