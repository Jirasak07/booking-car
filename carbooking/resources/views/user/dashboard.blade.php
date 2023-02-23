
@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fluid">

        @if ($message = Session::get('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'การจองสำเร็จ',
                    text: 'โปรดรอแอดมินอนุมัติ',
                }).then((result)=>{
                    if (result.isConfirmed) {
                        window.open('{{ route("users.view-booking") }}','_self')
                    }
                });
            </script>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" id="ERROR_COPY" style="display:none;">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <!-- ทำการ วน Loop เพื่อแสดง Error ของ validation ขึ้นมาทั้งหมด -->
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- <div class="col-xl-12">@include('user.calendar')
                <div class="card mt-5">


                </div>
            </div> --}}

        <div class="card px-3 my-3 py-3 shadow-xl" style="height:150vh">
            <div class="row pb-3 pl-3">
                <strong class=" text-danger">หมายเหตุ : </strong>
                &ensp;
                <div class="" style="font-size: 14px;">
                    <i class="fa-solid fa-square"style="color: #06d6a0"></i>
                    อนุมัติเรียบร้อย
                </div>
                &emsp;
                <div class="" style="font-size: 14px;">
                    <i class="fa-solid fa-square"style="color: #ffd166"></i>
                    รอดำเนินการ
                </div>
            </div>
            @include('user.calendar')
        </div>
    </div>
    @push('js')
        <script>
            var has_error = {{ $errors->count() > 0 ? 'true' : 'false' }};
            if (has_error) {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    type: 'error',
                    html: jQuery("#ERROR_COPY").html(),
                    showCloseButton: true,
                });
            }
        </script>
    @endpush
@endsection
