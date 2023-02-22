@extends('layouts.layout');
<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
@section('content')
    @include('layouts.header')

    <div class="mt-3">
        @include('driver.header_driver_list')
    </div>
    <div class="container-fluid mt-4">
        <div class="bg-white rounded shadow-xl m-dash p-2">
            <div class="table-responsive">
                <table class="table  fw-bold w-100" id="dr_table">
                    <thead class="table-dark table-hover">
                        <tr align="center">
                            <th class="fw-bolder" style="font-size: 18px">ลำดับ</th>
                            <th class="fw-bolder" style="font-size: 18px">ช่วงวันที่</th>
                            <th class="fw-bolder text-wrap" style="font-size: 18px">จุดหมาย</th>
                            <th class="fw-bolder" style="font-size: 18px">รายละเอียด</th>
                            <th class="fw-bolder" style="font-size: 18px">ระยะทาง</th>
                            <th class="fw-bolder" style="font-size: 18px">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dr_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 3
                    },
                    {
                        responsivePriority: 3,
                        targets: 5
                    },
                ],
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
        });
    </script>
@endpush
