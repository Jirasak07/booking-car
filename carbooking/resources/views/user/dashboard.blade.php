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
            <div class="col-xl-12">
                <div class="card mt-5">

                    @include('user.calendar')
                </div>
            </div>
        </div>

    </div>
@endsection
