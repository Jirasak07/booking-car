<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark  " id="navbar-main" style="max-height: 60px">
    <div class="container-fluid d-flex justify-content-between">
        <!-- Brand -->

        <!-- Form -->
        <div class="text-capitalize h1 text-test mx-4 d-md-flex d-none pt-3 fw-200"
            style="color:#EAEAEA;">
            <label id="name-head">@yield('title')</label>
        </div>
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var path = window.location.pathname;

                if (path == "/index.php/admin/request") {
                    document.getElementById('name-head').innerHTML = 'Booking Request';
                } else if (path == "/index.php/admin/dashboard") {
                    document.getElementById('name-head').innerHTML = 'Dashboard';
                }

            })
        </script> --}}

        <!-- User -->
        <ul class="navbar-nav  align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class=" pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center ">
                        <span class="avatar avatar-sm rounded-circle  bg-dark">
                            {{-- <img alt="Image placeholder" src="{{ asset('assets/img/lanna-removebg-preview.png') }}"> --}}
                            <i class="fa-solid fa-user-tie" style="font-size: 1.5rem"></i>

                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{-- {{ auth()->user()->name }} --}}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ Auth::user()->name }}</h6>
                    </div>
                   
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                    <a href="{{}}"></a>
                </div>
            </li>
        </ul>
    </div>
</nav>
