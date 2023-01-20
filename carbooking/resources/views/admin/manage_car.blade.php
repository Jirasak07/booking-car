@section('title', 'ข้อมูลการจอง')
@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fulid mx-3 ">
        <div class="container-md p-md-2 p-1 mt-sm-2 mt-sm-1 mt-4">
            <div class="card p-2 shadow-table rounded ">
                <table id="tabledcar1"class="display responsive nowrap " style="width:100%;font-size:0.8em">
                    <thead class="table-dark">
                        <tr>
                            <td class="fw-bold">ลำดับ</td>
                            <td>หมายเลขทะเบียน</td>
                            <td>รายละเอียดรถ</td>
                            <td>สถานะ</td>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($car as $cars)
                            <tr>
                                <td>{{ $cars['id'] }}</td>
                                <td>{{ $cars['car_license'] }}</td>
                                <td>{{ $cars['car_model'] }}</td>

                                <td>
                                    @if ($cars['car_status'] == 1)
                                        <a class="btn btn-success btn-sm " style="width: 90px"
                                            href="{{ route('changestatus', $cars['id']) }}">{{ __('พร้อมใช้งาน') }}</a>
                                    @elseif($cars['car_status'] == 2)
                                        <a class="btn btn-danger btn-sm " style="width: 90px"
                                            href="{{ route('changestatus', $cars['id']) }}">{{ __('ไม่พร้อมใช้งาน') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @push('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                $('#tabledcar1').DataTable({
                    responsive: {
                        details: {
                            type: 'column',
                            target: 'tr'
                        }
                    },
                    columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0
                    }],
                    lengthMenu: [10, 20, 50, 100, ],
                    language: {
                        lengthMenu: "แสดง _MENU_ รายการ",
                        search: "ค้นหาข้อมูลในตาราง",
                        info: "แสดงข้อมูล _END_ จากทั้งหมด _TOTAL_ รายการ",

                        paginate: {

                            previous: "ก่อนหน้า",
                            next: "ถัดไป",

                        },
                    },
                });
            })
        </script>
    @endpush
@endsection
