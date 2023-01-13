@extends('layouts.admin.admin')

@section('content')
    @include('layouts.admin.header')
    <div class="container-sm">
        <div class="shadow-table">

            <table class="rounded table table-md  table-white table-striped fw-bold table-responsive-lg">
                <thead class="table-dark table-hover">
                    <tr>
                        <td class="fw-bold">ลำดับ</td>
                        <td>ผู้จอง</td>
                        <td>วันเวลาเริ่มต้น</td>
                        <td>วันเวลาสิ้นสุด</td>
                        <td>สถานะ</td>
                        <td>รายละเอียด</td>

                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td>จิรศักดิ์ สิงหบุตร</td>
                        <td>item->booking_start</td>
                        <td> item->booking_end</td>
                        <td>$item->booking_detail</td>
                        <td>
                            <div class="btn btn-sm bg-primary text-white"> <i class="fa-solid fa-eye"></i></div>

                        </td>

                    </tr>
                    <tr>
                        <td>1</td>
                        <td>จิรศักดิ์ สิงหบุตร</td>
                        <td>item->booking_start</td>
                        <td> item->booking_end</td>
                        <td>$item->booking_detail</td>
                        <td>
                            <div class="btn btn-sm bg-primary text-white"> <i class="fa-solid fa-eye"></i></div>

                        </td>

                    </tr>


                </tbody>
            </table>
        </div>

        {{-- @include('layouts.footers.auth') --}}
    </div>
    </div>
@endsection
