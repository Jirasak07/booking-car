@section('title', 'RDI-KPRU Admin ')
@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-5 px-lg-5">
        <div class="row justify-content-around mb-4 align-items-center">
            <div class="col-4 ">
                <label style="font-size: 20px;" class=" fw-bold">ประเมินผลโครงร่างงานวิจัย</label>
                <br>
                <label>รหัสโครงร่างงานวิจัย : {{ $list[0]->research_id }}</label>
            </div>
            <div class="col-4 text-end">

            </div>
        </div>

        <div class="row justify-content-center">
            <div class="card col-sm-12">
                <form action="{{ route('add-sum-feed') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">ชื่อโครงร่างงานวิจัยภาษาไทย</label>
                        <div class="col-sm-9">
                            <textarea type="text" readonly class="form-control-plaintext" value="">{{ $list[0]->research_th }}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-bold">ผลการประเมิน</label>
                        <div class="col-sm-10"onclick="pass()">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="AssessmentResults"
                                    id="AssessmentResults1" value="ไม่ผ่าน" checked>
                                <label class="form-check-label" for="AssessmentResults1">ไม่ผ่าน</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="AssessmentResults"
                                    id="AssessmentResults2" value="ผ่าน" {{-- disabled --}}>
                                <label class="form-check-label" for="AssessmentResults2">ผ่าน</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row"id="checkFile">
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input onclick="sugges()" class="form-check-input" type="checkbox" id="mustAddFile"
                                    name="mustAddFile" value="mustAddFile">
                                <label class="form-check-label text-danger"
                                    for="mustAddFile">ต้องการเพิ่มไฟล์ข้อเสนอแนะ</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row " id="suggestion">
                        <label class="col-sm-2 col-form-label fw-bold">ข้อเสนอแนะ</label>
                        <div class="col-sm-10">
                            <textarea {{-- onkeyup="sugges()" --}} class="form-control" name="suggestion" {{-- id="suggestion" --}} rows="20"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row" id="suggestionFile">
                        <label class="col-sm-2 col-form-label fw-bold">ไฟล์ข้อเสนอแนะ</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="suggestionFile" id="suggestionFile"
                                rows="20">
                            </ด>
                        </div>
                    </div>
                    <div class=" card-footer d-grid gap-2 d-md-flex justify-content-md-center">
                        <form action="" method="post">
                            <input type="hidden" name="research_id" id="research_id" value="{{ $list[0]->research_id }}">
                            <input class="btn btn-warning" type="submit" name="submit" id="save" value="บันทึก">
                            {{-- status=2 --}}
                            <input class="btn btn-success" type="submit" name="submit" id="ok" value="ยืนยัน">
                            {{-- status=1 --}}
                        </form>
                        <a href="{{ url()->previous() }}" class="btn btn-danger" type="button">ย้อนกลับ</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"
        integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            document.getElementById("suggestionFile").style.display = "none";
        });

        function sugges() {
            var rb = document.getElementById('AssessmentResults2');
            //var rb = document.querySelector('input[id="refers2"]:checked').value;
            var ck = document.getElementById('mustAddFile');
            var cf = document.getElementById('checkFile');
            var x = document.getElementById("suggestionFile");
            var z = document.getElementById("suggestion");
            var bs = document.getElementById("save");

            //x.value = x.value.toUpperCase();

            console.log('false');
            if (ck.checked == true) {
                console.log('true');
                Swal.fire({
                    text: "คุณต้องการเพิ่มไฟล์ข้อเสนอแนะ ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่',
                    cancelButtonText: 'ไม่',
                }).then((result) => {
                    if (result.isConfirmed) {
                        x.style.display = "";
                        z.style.display = "none";
                        bs.style.display = "none";
                    }
                    if (result.dismiss) {
                        //console.log('false');
                        ck.checked = false;
                        x.style.display = "none";
                        z.style.display = "";
                        bs.style.display = "";
                    }
                })

            } else {
                //console.log('false');
                ck.style.display = "";
                x.style.display = "none";
                z.style.display = "";
            }

        }

        function pass() {
            var rb2 = document.getElementById('AssessmentResults2');
            var rb1 = document.getElementById('AssessmentResults1');
            //var rb = document.querySelector('input[id="refers2"]:checked').value;
            var ck = document.getElementById('mustAddFile');
            var cf = document.getElementById('checkFile');
            var x = document.getElementById("suggestionFile");
            var z = document.getElementById("suggestion");
            var bs = document.getElementById("save");

            //x.value = x.value.toUpperCase();

            if (rb2.checked == true) {
                cf.style.display = "none";
                x.style.display = "none";
                z.style.display = "none";
                bs.style.display = "none";
                console.log('true');
            }
            if (rb1.checked == true) {
                cf.style.display = "";
                bs.style.display = "";
                sugges();
            }
        }
    </script>
@endsection
