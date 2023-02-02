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
                        @foreach ($time as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->time }}</td>

                                <td>
                                    @if ($item->unit == 'hours')
                                        ชั่วโมง
                                    @elseif($item->unit == 'day')
                                        วัน
                                    @else
                                        เดือน
                                    @endif
                                </td>
                                <td>
                                    <div class="btn btn-info btn-sm" onclick="showModal({{ $item->id }})">
                                        Edit
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                </table>
            </div>

        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formsetting" class="modal-content">
                {{-- method="POST" action="{{ url('admin/edit-setting') }}" --}}
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
                        <input required type="number" id="qty" name="time"
                            style="border: 0.2px solid #DADDD8;border-radius: 5px;width:80px">
                    </div>
                    <div class="col-6">
                        <input type="hidden" id="id_form" name="id_form">
                        <label for="" class="ml-2">หน่วย :</label>
                        <select class="ml-2 p-1" name="unit" id="unit-select"
                            style="border: 0.2px solid #DADDD8;border-radius: 5px;font-size:13px">
                            <option value="hours">ชั่วโมง</option>
                            <option value="day">วัน</option>
                            <option value="month">เดือน</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">บันทึก</button>
                    <div class="btn btn-danger btn-sm" onclick="closeModal()">ยกเลิก</div>
                </div>
            </form>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script type="text/javascript">
        $('#formsetting').on('submit', function(e) {
            e.preventDefault();
            let time = $('#qty').val();
            let unit = $('#unit-select').val();
            let id_form = $('#id_form').val();
            $.ajax({
                url: "edit-setting",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    time: time,
                    unit: unit,
                    id_form: id_form,
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'ตั้งค่าเสร็จสิ้น !!',
                    }).then((res) => {
                        window.location.reload()
                    })
                },
                // error: function(response) {

                // },
            });
        })
    </script>
    <script>
        function showModal(id) {
            var dataSetting = @json($time);
            var idset = '';
            var dataset = '';
            dataSetting.forEach(el => {
                if (el.id == id) {
                    idset = el.id
                    dataset = el.time
                    $('#unit-select').val(el.unit);
                }
            });
            $('#qty').val(dataset);
            $('#id_form').val(idset);
            $('#exampleModal').modal('toggle');
        }

        function closeModal() {
            $('#exampleModal').modal('hide');
        }
    </script>
@endsection
