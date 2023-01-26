@section('title', 'Dashboard')
@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fluid">
        <div class="row">
            @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'การจองสำเร็จ',
                        text: 'โปรดรอแอดมินอนุมัติ',
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
        </div>
        <div class="bg-white mb-5 mt-6 rounded " style="height:150vh">
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
