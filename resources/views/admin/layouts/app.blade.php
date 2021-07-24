<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Locale Session-->
    <meta name="locale" content="{{ session()->get('locale') }}">

    <!-- Locale Session-->
    <meta name="id_user" content="{{ Auth::guard('admin')->user()->id ?? '' }}">

    <title>@lang('auth.title-admin')</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-green sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
                <div class="sidebar-brand-text mx-3">@lang('auth.title_admin')</div>
            </a>
            <hr class="sidebar-divider my-0">
            @auth('admin')
                <li class="nav-item active">
                        <a class="nav-link" href="{{ route('admin.home') }}" style="text-align: center"><span>@lang('auth.title_admin')</span></a>
                </li>

                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users fa-sm fa-fw mr-2 text-gray-400"></i><span>@lang('users.users')</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.products.index') }}"><i class="fas fa-hamburger fa-sm fa-fw mr-2 text-gray-400"></i><span>@lang('products.products')</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}"><i class="fa fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i><span>@lang('categories.categories')</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}"><i class="fa fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i><span>@lang('order.orders')</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.suggests.index') }}"><i class="fa fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i><span>@lang('suggest.suggests')</span></a>
                </li>

                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.notifications.index') }}"><i class="fa fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i><span>@lang('notification.notifications')</span> <span class="badge badge-success ml-2" id="nav_count_noti">{{ Auth::guard('admin')->user()->count_notify_unread }}</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="btn_login"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i><span>@lang('auth.logout')</span></a>
                </li>
            @endauth

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        @auth('admin')
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span><strong>{{ Auth::guard('admin')->user()->fullname }} ( {{ Auth::guard('admin')->user()->role }} )</strong></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <form id="admin-logout-form" method="POST">
                                        @csrf
                                        <button style="cursor: pointer" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            @lang('auth.logout')
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </nav>
                <div class="container">
                    @yield('content')
                </div>
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>@lang('auth.copyright') &copy; DPK3</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    @include('admin.partials.toast-order')
    @include('admin.partials.toast-noti')

    <script src="{{ asset('js/client/jquery.min.js') }}"></script>
    <script src="{{ asset('js/client/bootstrap.min.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('js/admin/pusher.js') }}"></script>
    <script src="{{ asset('js/admin/home.js') }}"></script>
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>

    <script src="{{ asset('js/admin/chart.js') }}"></script>

</body>
</html>
