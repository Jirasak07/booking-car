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

            {{-- <div class="col-xl-12">@include('user.calendar')
                <div class="card mt-5">


                </div>
            </div> --}}
        </div>
        <div class="bg-white mb-5 mt-5 rounded" style="height:150vh">
            @include('user.calendar')
        </div>
    </div>

@endsection
