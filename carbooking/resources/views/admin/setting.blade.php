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
                                    {{ $item->unit_th }}
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
    <template id="template">
        <swal-html>
            <swal-title>
                <label for="" id="title"></label>
            </swal-title>
            <form id="formsetting">
                @csrf
                <input type="hidden" id="id_form" name="id_form">
                <div class="d-flex justify-content-center">
                    <div style="width: 60%;gap:10px"
                        class=" py-3  d-flex flex-column align-items-start justify-content-start">
                        <div>
                            <label style="width: 80px">จำนวน :</label>
                            <input required class="p-2" required type="number" id="qty" name="time" min="0" step="1"
                                style="border: 0.2px solid #DADDD8;border-radius: 5px;width:180px;font-size:13px;">
                        </div>
                        <div>

                            <label style="width: 80px">หน่วย :</label>
                            <select class="p-2" name="unit" id="unit-select"
                                style="border: 0.2px solid #DADDD8;border-radius: 5px;font-size:13px;width:180px">
                                <option value="hours">ชั่วโมง</option>
                                <option value="day">วัน</option>
                                <option value="month">เดือน</option>
                            </select>
                        </div>
                    </div>


                </div>
            </form>
        </swal-html>
    </template>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        function showModal(id) {
            var dataSetting = @json($time);
            var idset = '';
            var dataset = '';
            var select = '';
            var title = '';
            Swal.fire({
                template: '#template',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                title: 'ตั้งค่า',
                showCancelButton: true,
                cancelButtonColor: '#ef476f',
                confirmButtonColor: '#06d6a0',
                focusConfirm: false,
            }).then((respp) => {
                if (respp.isConfirmed) {
                    var frm = $('#formsetting').serialize();
                    let time = $('#qty').val();
                    if (time < 1 ) {
                        Swal.fire({
                            icon: 'error',
                            title: 'กรุณากรอกข้อมูลให้ถูกต้อง'
                        })
                    } else {
                        $.ajax({
                            url: "edit-setting",
                            type: "POST",
                            data: frm,
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ตั้งค่าเสร็จสิ้น !!',
                                }).then((res) => {
                                    window.location.reload()
                                })
                            },
                             error: function(response) {
                                Swal.fire({
                                    icon:'error',
                                    title:'กรุณากรอกข้อมูลให้ถูกต้อง'
                                })
                             },
                        });
                    }
                    let unit = $('#unit-select').val();
                    let id_form = $('#id_form').val();
                }
            })
            dataSetting.forEach(el => {
                if (el.id == id) {
                    idset = el.id
                    dataset = el.time
                    select = el.unit
                    title = el.name


                }
            });
            $('#title').append(title);
            $('#unit-select').val(select);
            $('#qty').val(dataset);
            $('#id_form').val(idset);

        }
    </script>
@endsection
