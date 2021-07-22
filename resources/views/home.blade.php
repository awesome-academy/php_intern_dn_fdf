@extends('layouts.app')

@section('content')
<!-- Start slides -->
<div id="slides" class="cover-slides">
    <ul class="slides-container">
        @for ($i = 1; $i <= 3; $i++)
            <li class="text-left">
                <img src="/storage/img/slider-0{{ $i }}.jpg" alt="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="m-b-20"><strong>@lang('homepage.welcome')</strong></h1>
                            <p class="m-b-40">@lang('homepage.head1')  <br>
                            @lang('homepage.head2')</p>
                            <p><a class="btn btn-lg btn-circle btn-outline-new-white" href="">@lang('homepage.menu')</a></p>
                        </div>
                    </div>
                </div>
            </li>
        @endfor
    </ul>
    <div class="slides-navigation">
        <a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
        <a href="#" class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    </div>
</div>
<!-- End slides -->

<!-- Start About -->
<div class="about-section-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                <div class="inner-column">
                    <h4>@lang('homepage.little_history')</h4>
                    <p>@lang('homepage.thank')</p>
                    <a class="btn btn-lg btn-circle btn-outline-new-white" href="#">@lang('homepage.menu')</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <img src="/storage/img/about-img.jpg" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<!-- End About -->

<!-- Start QT -->
<div class="qt-box qt-background">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ml-auto mr-auto text-center">
                <p class="lead ">
                    " @lang('homepage.slogan') "
                </p>
                <span class="lead">Michael Strahan</span>
            </div>
        </div>
    </div>
</div>
<!-- End QT -->

<!-- Start Menu -->
<div class="menu-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                    <h2>@lang('homepage.special_menu')</h2>
                    <p>@lang('homepage.menu_discription')</p>
                </div>
            </div>
        </div>

        <div class="row inner-menu-box">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">@lang('homepage.all')</a>
                    @foreach ($categories as $cate)
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-{{ $cate->id }}" role="tab" aria-controls="v-pills-{{ $cate->id }}" aria-selected="false">{{ $cate->name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="row">
                            @foreach ($categories as $cate)
                                @foreach ($cate->products as $product)
                                    <div class="col-lg-4 col-md-6 special-grid dinner">
                                        <div class="gallery-single fix">
                                            <img src="/storage/{{ $product->first_image }}" alt="Image" width="254" height="152">
                                            <div class="why-text">
                                                <h4>{{ $product->name }}</h4>
                                                <p>@lang('products.avg_rate'): {{ $product->avg_rating }}* ({{$product->ratings->count()}})</p>
                                                <h5> {{ number_format($product->price, 2) }} vnd</h5>
                                                <div class="d-flex justify-content-around">
                                                    <a href="{{ route('products.show', $product->id) }}"><i class="fas fa-eye cursor"></i></a>
                                                    <a @auth('web') class="add-my-favorite" @else data-toggle="modal" data-target="#modalLogin" @endauth data-product-id="{{ $product->id }}"><i class="fas fa-heart cursor"></i></a>
                                                    <a class="add-to-cart" data-product-id="{{ $product->id }}"><i class="fas fa-shopping-cart cursor"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    @foreach ($categories as $cate)
                        <div class="tab-pane fade" id="v-pills-{{ $cate->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $cate->id }}-tab">
                            <div class="row">
                                @foreach ($cate->products as $product)
                                    <div class="col-lg-4 col-md-6 special-grid drinks">
                                        <div class="gallery-single fix">
                                            <img src="/storage/{{ $product->first_image }}" alt="Image" width="254" height="152">
                                            <div class="why-text">
                                                <h4>{{ $product->name }}</h4>
                                                <p>@lang('products.avg_rate'): {{ $product->avg_rating }}* ({{$product->ratings->count()}})</p>
                                                <h5> {{ number_format($product->price, 2) }} vnd</h5>
                                                <div class="d-flex justify-content-around">
                                                    <a href="{{ route('products.show', $product->id) }}"><i class="fas fa-eye cursor"></i></a>
                                                    <a @auth('web') class="add-my-favorite" @else data-toggle="modal" data-target="#modalLogin" @endauth data-product-id="{{ $product->id }}"><i class="fas fa-heart cursor"></i></a>
                                                    <a class="add-to-cart" data-product-id="{{ $product->id }}"><i class="fas fa-shopping-cart cursor"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Menu -->

<div class="gallery-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                    <h2>@lang('homepage.interest-products')</h2>
                    <p>@lang('homepage.desc-interested')</p>
                </div>
            </div>
        </div>
        <div class="tz-gallery">
            <div class="row">
                @foreach ($product_trend as $product)
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <a class="lightbox" href="{{ route('products.show', $product->id) }}">
                            <img class="img-fluid" src="/storage/{{ $product->first_image }}" alt="Gallery Images">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="gallery-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="heading-title text-center">
                    <h2>@lang('homepage.best-selling')</h2>
                    <p>@lang('homepage.desc-best-selling')</p>
                </div>
            </div>
        </div>
        <div class="tz-gallery">
            <div class="row">
                @foreach ($product_best_selling as $product)
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <a class="lightbox" href="{{ route('products.show', $product->id) }}">
                            <img class="img-fluid" src="/storage/{{ $product->first_image }}" alt="Gallery Images">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
