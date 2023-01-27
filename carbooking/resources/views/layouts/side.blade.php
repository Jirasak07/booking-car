<style>
    .active-nav {
        border-left: 0.75vh solid #540375;
        background-color: #EAEAEA;
        color: rgb(0, 0, 0)
    }
   
</style>
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white shadow-box-login " id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="">
            <img src="{{ asset('assets/img/lanna-removebg-preview.png') }}" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="  nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle  bg-dark">
                            {{-- <img alt="Image placeholder" src="{{ asset('assets/img/lanna-removebg-preview.png') }}"> --}}
                            <i class="fa-solid fa-user-tie" style="font-size: 1.5rem"></i>

                        </span>
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
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse  navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none w-md-100">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/lanna-removebg-preview.png') }}" class="navbar-brand-img"
                                alt="...">
                        </a>
                    </div>
                    <div class="col-6 collapse-close ">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended"
                        placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            @if (Auth::user()->role_user == '2')
                <ul class="navbar-nav  ">
                    <li class="{{ 'users/dashboard' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                        <a class="{{ 'users/dashboard' == request()->path() ? 'nav-link text-darker' : 'nav-link ' }}"
                            style="font-weight: 600;font-size:1rem" href="{{ route('users.dashboard') }}">
                            <i class="fa-solid fa-gauge-high"></i> {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="{{ 'users/booking' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                        <a class="{{ 'users/booking' == request()->path() ? 'nav-link text-darker' : 'nav-link ' }}"
                            style="font-weight: 600;font-size:1rem"
                            href="{{ route('users.view-booking', Auth::user()->id) }}">
                            <i class="fa-solid fa-calendar-days"></i> {{ __('ข้อมูลการจอง') }}
                        </a>
                    </li>
                </ul>
            @endif
            @if (Auth::user()->role_user == '1')
                <ul class="navbar-nav  ">
                    <li class="{{ 'admin/dashboard' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                        <a class="{{ 'admin/dashboard' == request()->path() ? 'nav-link text-darker  ' : 'nav-link ' }}"
                            style="font-weight: 600;font-size:1rem" href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-gauge-high "></i> {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li class="{{ 'admin/request' == request()->path()||'admin/history' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                        <a class="{{ 'admin/request' == request()->path()||'admin/history' == request()->path() ? 'nav-link text-darker' : 'nav-link ' }}" style="font-weight: 600;font-size:1rem"
                            href="{{ route('admin.booking_request') }}">
                            <i class="fa-solid fa-calendar-days"></i> {{ __('ข้อมูลการจอง') }} </a>
                        <ul class="sub-menu py-2 ">
                            <li class="nav-item">
                                <a class="{{ 'admin/request' == request()->path() ? 'nav-link-sub text-primary' : 'nav-link-sub  ' }}"
                                    style="font-weight: 600;font-size:0.9rem" href="{{ route('admin.booking_request') }}">
                                    <i class="fa-sharp fa-solid fa-circle-dot" style="font-size: 50%"></i>
                                    {{ __('รายการจองรถ') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="{{ 'admin/history' == request()->path() ? 'nav-link-sub text-primary ' : 'nav-link-sub ' }}"
                                    style="font-weight: 600;font-size:0.9rem" href="{{ route('admin.booking_history') }}">
                                    <i class="fa-sharp fa-solid fa-circle-dot" style="font-size: 50%"></i>
                                    {{ __('ประวัติรายการ') }}
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="{{ 'admin/manage-car' == request()->path()||'admin/manage-driver' == request()->path()||'admin/manage-user' == request()->path() ? 'nav-item active-nav ' : 'nav-item ' }}">
                        <a class="{{ 'admin/manage-car' == request()->path()||'admin/manage-driver' == request()->path()||'admin/manage-user' == request()->path() ? 'nav-link text-darker' : 'nav-link ' }}" style="font-weight: 600;font-size:0.9rem"
                            href="{{ route('admin.manage-car') }}">
                            <i class="fa-regular fa-calendar"></i> {{ __('จัดการข้อมูลพื้นฐาน') }} </a>
                        <ul class="sub-menu py-2 ">
                            <li class="nav-item">
                                <a class="{{ 'admin/manage-car' == request()->path() ? 'nav-link-sub text-primary ' : 'nav-link-sub text-default  ' }}"
                                    style="font-weight: 600;font-size:0.85rem" href="{{ route('admin.manage-car') }}">
                                    <i class="fa-sharp fa-solid fa-circle-dot" style="font-size: 50%"></i>
                                    {{ __('จัดการข้อมูลรถภายใน') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ 'admin/manage-driver' == request()->path() ? 'nav-link-sub text-primary ' : 'nav-link-sub text-default ' }}"
                                    style="font-weight: 600;font-size:0.85rem" href="{{ route('admin.manage-driver') }}">
                                    <i class="fa-sharp fa-solid fa-circle-dot" style="font-size: 50%"></i>
                                    {{ __('จัดการข้อมูลพนักงานขับ') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ 'admin/manage-user' == request()->path() ? 'nav-link-sub text-primary ' : 'nav-link-sub text-default ' }}"
                                    style="font-weight: 600;font-size:0.85rem" href="{{ route('admin.manage-user') }}">
                                    <i class="fa-sharp fa-solid fa-circle-dot" style="font-size: 50%"></i>
                                    {{ __('จัดการข้อมูลผู้ใช้') }}
                                </a>
                            </li>
                        </ul>

                        {{-- {{ Request::routeIs('admin/manage-driver')? 'nav-link-sub text-white' : 'nav-link-sub active' }} --}}
                    </li>
            @endif

            {{-- <li class="nav-item">
                    <a class="nav-link " href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Laravel Examples') }}</span>
                    </a>

                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    {{ __('User profile') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="">
                                    {{ __('User Management') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

            </ul>
        </div>
    </div>

</nav>
