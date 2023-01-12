@extends('layouts.app', ['class' => 'bg-gray'])

@section('content')
    @include('layouts.headers.guest')
    <div class="container  pb-5 " >
        <div class="row justify-content-center  ">
            <div class="col-lg-5 col-md-7  ">
                <div class="card bg-white shadow-sm rounded border-3">
                    <div class="card-header bg-transparent">
                        <div class="text-center mt-2">
                            <div class="mt-3 text-center ">
                                <img src="{{ asset('assets/img/lanna-removebg-preview.png') }}" width="150px" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-lg-5 py-lg-3">
                        <div class=" text-center mb-4  ">
                            <div class="text-lanna ">ระบบจองคิวรถ</div>
                        </div>

                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Email') }}" type="email" name="email"
                                        value="{{ old('email') }}" value="admin@argon.com" required autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" placeholder="{{ __('Password') }}" type="password" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span class="text-muted">{{ __('Remember me') }}</span>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success my-4">{{ __('เข้าสู่ระบบ') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="row mt-3">
                    <div class="col-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-light">
                                <small>{{ __('Forgot password?') }}</small>
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('register') }}" class="text-light">
                            <small>{{ __('Create new account') }}</small>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
