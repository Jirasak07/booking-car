@section('title', 'Dashboard')
@extends('layouts.layout')
@section('content')
    @include('layouts.header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card mt-5">
                    @include('user.calendar')
                </div>
            </div>
        </div>

    </div>
@endsection
