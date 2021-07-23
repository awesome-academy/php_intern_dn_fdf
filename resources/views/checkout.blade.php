@extends('layouts.app')

@section('content')
    <!-- Start All Pages -->
    <div class="all-page-title page-breadcrumb">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-12">
                    <h1>@lang('homepage.checkout')</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-1">
        <div class="row">
            <div class="col-xl-8 ftco-animate bg-dark">
                <form id="form_check_out" class="billing-form ftco-bg-dark p-3 p-md-5">
                    @csrf
                    <h3 class="mb-4 billing-heading text-light">@lang('checkout.bill_detail')</h3>
                    <div class="row align-items-end">
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">@lang('users.fullname')</label>
                                <input id="nameInputCheckout" name="name" type="text" value="{{ $user->name }}" class="form-control" placeholder="@lang('users.fullname')">
                                <span class="invalid-feedback" role="alert" id="nameErrorCheckout">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">@lang('users.phone_number')</label>
                                <input id="phoneInputCheckout" name="phone" value="{{ $user->phone == '' ? '' : $user->phone }}" type="text" class="form-control" placeholder="@lang('users.phone_number')">
                                <span class="invalid-feedback" role="alert" id="phoneErrorCheckout">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">@lang('homepage.email_address')</label>
                                <input id="emailInputCheckout" name="email" type="text" value="{{ $user->email }}" class="form-control" placeholder="@lang('homepage.email_address')">
                                <span class="invalid-feedback" role="alert" id="emailErrorCheckout">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country">@lang('users.city')</label>
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select id="cityInputCheckout" name="city" class="form-control">
                                        <option class="text-dark" value="">@lang('checkout.not_chose')</option>
                                        @foreach ($cities as $city)
                                            <option class="text-dark" value="{{ $city->name }}"
                                                {{ $city->name == $user->city ? 'selected' : '' }}>{{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="invalid-feedback" role="alert" id="cityErrorCheckout">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="streetaddress">@lang('users.address')</label>
                                <input id="addressInputCheckout" name="address" type="text" value="{{ $user->address == '' ? '' : $user->address }}" class="form-control" placeholder="@lang('users.address')">
                                <span class="invalid-feedback" role="alert" id="addressErrorCheckout">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <div class="w-100"></div>
                    </div>
                    <div class="row mt-5 pt-3 d-flex">
                        <div class="col-md-6 d-flex">
                            <div class="cart-detail cart-total ftco-bg-dark p-3 p-md-4">
                                <h3 class="billing-heading mb-4 text-light">@lang('checkout.cart_total')</h3>
                                <p class="d-flex justify-content-between">
                                    <span class="text-light">@lang('checkout.sub_total') </span>
                                    <span class="text-light">{{ $cart->totalPrice }}</span>
                                </p>
                                <p class="d-flex justify-content-between">
                                    <span class="text-light">@lang('checkout.delivery') </span>
                                    <span class="text-light">$0.00</span>
                                </p>
                                <p class="d-flex justify-content-between">
                                    <span class="text-light">@lang('checkout.discount') </span>
                                    <span class="text-light">$0.00</span>
                                </p>
                                <hr>
                                <p class="d-flex justify-content-between total-price">
                                    <span class="text-light">@lang('checkout.total')</span>
                                    <span class="text-light">{{ $cart->totalPrice }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="cart-detail ftco-bg-dark p-3 p-md-4">
                                <h3 class="billing-heading mb-4 text-light">@lang('checkout.payment_method')</h3>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label><input type="radio" name="optradio" class="mr-2">COD</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label><input type="radio" name="optradio" class="mr-2">VNPay</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label><input type="radio" name="optradio" class="mr-2">Momo</label>
                                        </div>
                                    </div>
                                </div>
                                <button id="check_out" type="submit"
                                    class="btn btn-primary py-3 px-4 text-decoration-none text-dark"
                                    style="cursor: pointer">@lang('checkout.order')</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-primary alert-checkout d-none" role="alert">
                                <strong></strong>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
