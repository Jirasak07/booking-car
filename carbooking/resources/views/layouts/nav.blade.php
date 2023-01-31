<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark  " id="navbar-main" style="max-height: 60px;min-width:375px">
    <div class="container-fluid d-flex justify-content-between">
        <!-- Brand -->

        <!-- Form -->
        <div class="text-capitalize h1 text-test mx-4 d-md-flex d-none pt-3 fw-200" style="color:#EAEAEA;">
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
                        <span class="avatar avatar-sm rounded-circle " style="background-color:#F5A65B;">
                            {{-- <img alt="Image placeholder" src="{{ asset('assets/img/lanna-removebg-preview.png') }}"> --}}
                            <i class="fa-solid fa-user-tie" style="font-size: 1.5rem"></i>

                        </span>
                        <h4 class="text-overflow m-0 text-light px-2">{{ Auth::user()->name }}</h4>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{-- {{ auth()->user()->name }} --}}</span>
                        </div>
                    </div>
                </a>

            </li>
        </ul>
    </div>
</nav>
