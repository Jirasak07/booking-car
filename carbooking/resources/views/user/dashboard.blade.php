@extends('layouts.user.users')
@section('content')
    @include('layouts.user.header')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">booking</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('user.calendar')
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
