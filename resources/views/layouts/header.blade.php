<header class="top-navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbars-rs-food" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbars-rs-food">
                <div class="search-chit form-inline my-2 my-lg-0">
                    <div class="form-item-rev">
                    <input id="search" class="form-control form_check mr-sm-2 rounded border border-secondary border-top-0" placeholder="Search name of product">
                    <div class="search-list-item d-none" id="list_search">
                    </div>
                    </div>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ Route::is('home') ? 'active' : '' }}"><a class="nav-link" href="{{ route('home') }}">@lang('homepage.home')</a></li>
                    <li class="nav-item {{ Route::is('menu') ? 'active' : '' }}"><a class="nav-link" href="{{ route('menu') }}">@lang('homepage.menu')</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('suggest.index') }}">@lang('homepage.suggest')</a></li>
                    @guest('web')
                        <li class="nav-item"><a class="nav-link cursor" data-toggle="modal" data-target="#modalLogin">@lang('homepage.login')</a></li>
                        <li class="nav-item"><a class="nav-link cursor" data-toggle="modal" data-target="#modalRegister">@lang('homepage.register')</a></li>
                    @else
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>{{ Auth::guard('web')->user()->name }}</strong></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('order.index') }}">@lang('homepage.order-history')</a>
                                <div class="dropdown-item d-flex justify-content-between align-items-center">
                                    <a class="cursor" id="modalNotifyOpen" data-toggle="modal" data-target="#modalNotify">@lang('homepage.notify')</a>
                                    <div class="badge badge-success ml-2" id="nav_count_noti">{{ Auth::guard('web')->user()->count_notify_unread }}</div>
                                </div>
                                <a class="dropdown-item border-top" href="{{ route('profile.index') }}">@lang('homepage.profile')</a>
                                <form id="logout-form" method="POST">
                                    @csrf
                                    <a class="btn-logout dropdown-item cursor">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        @lang('auth.logout')
                                    </a>
                                </form>
                            </div>
                        </li>
                    @endguest
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @switch(session()->get('locale'))
                                @case('us')
                                <img class="w-50" src="{{asset('storage/img/usa.png')}}">
                                @break
                                @case('vi')
                                <img class="w-50" src="{{asset('storage/img/vn.png')}}">
                                @break
                                @default
                                <img class="w-50" src="{{asset('storage/img/usa.png')}}">
                            @endswitch
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('locale', 'en') }}"><img src="{{asset('storage/img/usa.png')}}" width="23%"> English</a>
                            <a class="dropdown-item" href="{{ route('locale', 'vi') }}"><img src="{{asset('storage/img/vn.png')}}" width="23%"> Việt Nam</a>
                        </div>
                    </li>
                    <li class="nav-item ml-2">
                        <a class="nav-link icon-parent cursor" data-toggle="modal" data-target="#cartModal">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="icon-child badge badge-success ml-2" id="nav_count">{{ session()->get('cart')->totalQuantity ?? '0' }}</span>
                        </a>
                    </li>
                    <li class="nav-item ml-2">
                        <a class="nav-link icon-parent cursor" @auth('web') id="modalFavorite" data-toggle="modal" data-target="#favoriteModal" @else data-toggle="modal" data-target="#modalLogin" @endauth>
                            <i class="fas fa-heart"></i>
                            <span class="icon-child badge badge-success ml-2" id="count_favorite">@auth('web') {{ Auth::guard('web')->user()->count_favorite }} @else 0 @endauth</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
