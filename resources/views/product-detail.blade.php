@extends('layouts.app')

@section('content')
    <!-- Start All Pages -->
    <div class="all-page-title page-breadcrumb">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12">
                    <h1>@lang('homepage.product_detail')</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-1">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <div class="c-product-container__element c-product-container__element--images">
                    <div class="c-product-image-viewer">
                        <div class="c-product-image-viewer__carousel">
                            <div class="o-slider-image-viewer">
                                <ul class="o-slider-image-viewer__inner js-sliderImageViewer">
                                    @foreach ($product->images as $image)
                                        <li class="o-slider-image-viewer__slide">
                                            <img class="c-product-image-viewer__image"
                                                src="/storage/{{ $image->image_path }}">
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="o-slider-image-viewer__nav js-imageViewerNav">
                                    @foreach ($product->images as $image)
                                        <span class="o-slider-image-viewer__dot">
                                            <img class="o-slider-image-viewer__dot-image"
                                                src="/storage/{{ $image->image_path }}">
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <h3>{{ $product->name }}</h3>
                <p class="price"><span>${{ $product->price }}</span></p>
                <p>{{ $product->description }}</p>
                </p>
                <div class="row mt-4">
                    <div class="w-100"></div>
                    <div class="input-group col-md-8 d-flex mb-3">
                        <span class="input-group-btn mr-2">
                            <button type="button" id="btn_minus" class="btn-minus quantity-left-minus btn" data-type="minus"
                                data-field="">
                                <i class="fas fa-minus"></i>
                            </button>
                        </span>
                        <input type="text" id="quantity" disabled name="quantity" class="form-control input-number"
                            value="1">
                        <span class="input-group-btn ml-2">
                            <button type="button" class="btn-plus quantity-right-plus btn" data-type="plus" data-field="">
                                <i class="fas fa-plus"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <a class="btn btn-primary py-3 px-5 cursor text-decaration-none text-dark" id="add_to_cart"
                    data-product-id="{{ $product->id }}">@lang('homepage.add_to_cart')</a>
            </div>
        </div>

        @include('partials.form-rating', [
            'product' => $product
        ])

        @include('partials.show-rating')

        <div class="row">
            <div class="col-sm-12">
                <hr />
                <div id="list_ratings">
                    @foreach ($product->ratings as $rating)
                        <div class="review-block">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                                    <div class="review-block-name">{{ $rating->name }}</div>
                                    <div class="review-block-date">
                                        {{ date('d-m-Y', strtotime($rating->pivot->created_at)) }}<br />{{ $rating->pivot->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="review-block-rate">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating->pivot->num_rated)
                                                <button
                                                type="button" class="btn btn-warning btn-xs"
                                                aria-label="Left Align">
                                                <i class="fas fa-star"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-default btn-grey
                                                btn-xs" aria-label="Left Align">
                                                <i class="fas fa-star"></i>
                                                </button>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="review-block-title">{{ $rating->pivot->content }}</div>
                                </div>
                            </div>
                            <hr />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
