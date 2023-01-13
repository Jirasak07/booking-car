@section('title', 'Dashboard')
@extends('layouts.user.users')
@section('content')
    @include('layouts.user.header')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    @include('user.calendar')
                </div>
            </div>
        </div>

    </div>
@endsection
