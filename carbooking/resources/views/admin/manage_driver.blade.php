@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card-dark  shadow-b overflow-auto">
                <table class=" rounded  table table-light  table-striped fw-bold table-responsive-xl">
                    <thead class="table-dark table-hover">
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
                            <td>รายชื่อ</td>
                            <td>สถานะ</td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>จิรศักดิ์ สิงหบุตร</td>
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
