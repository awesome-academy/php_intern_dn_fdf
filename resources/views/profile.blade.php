@extends('layouts.app')

@section('content')
    <div class="container bootstrap snippet">
        <div class="row p-3">
            <div class="col-sm-10">
                <h1>{{ $user->name }}</h1>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-sm-4">
                <!--left col-->
                <div class="text-center">
                    <form id="form_add_image" action="{{ route('profile.avatar') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label for="avatar" class="cursor"><img src="/storage/{{ $user->avatar }}"
                                class="avatar img-circle img-thumbnail" alt="avatar"></label>
                        <h6>@lang('users.upload_ava')</h6>
                        <input id="avatar" class="d-none" type="file" name="avatar" onchange="this.form.submit()" />
                    </form>
                </div>
                </hr><br>

                <ul class="list-group">
                    <li class="list-group-item text-muted">@lang('users.activity') <i class="fa fa-dashboard fa-1x"></i>
                    </li>
                    <li class="list-group-item text-right d-flex justify-content-between"><span
                            class="pull-left"><strong>@lang('users.num_order')</strong></span>{{ $user->orders->count() }}
                    </li>
                    <li class="list-group-item text-right d-flex justify-content-between"><span
                            class="pull-left"><strong>@lang('users.num_suggest')</strong></span>{{ $user->suggestProducts->count() }}
                    </li>
                    <li class="list-group-item text-right d-flex justify-content-between"><span
                            class="pull-left"><strong>@lang('users.num_favorite')</strong></span>{{ $user->favoriteProducts->count() }}
                    </li>
                </ul>
            </div>
            <div class="col-sm-7">
                <ul class="nav nav-tabs">
                    <li class="active"><a class="btn btn-outline-success" data-toggle="tab"
                            href="#home">@lang('homepage.home')</a></li>
                    @if ($user->is_login_oauth == false)
                        <li><a class="btn btn-outline-primary" data-toggle="tab" href="#password">@lang('auth.password')</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="home">
                        <form class="form" action="{{ route('profile.info') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="name">
                                        <h4>@lang('users.fullname')</h4>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ $user->name }}" name="name" placeholder="@lang('users.fullname')">


                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="phone">
                                        <h4>@lang('users.phone_number')</h4>
                                    </label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ $user->phone == '' ? '' : $user->phone }}" name="phone"
                                        placeholder="@lang('users.phone_number')">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="city">
                                        <h4>@lang('users.city')</h4>
                                    </label>
                                    <select name="city" id="city" class="form-control">
                                        <option value="">@lang('users.no_choise')</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->name }}"
                                                {{ $city->name == $user->city ? 'selected' : '' }}>{{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="address">
                                        <h4>@lang('users.address')</h4>
                                    </label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        value="{{ $user->address == '' ? '' : $user->address }}" name="address"
                                        placeholder="@lang('users.address')">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-lg btn-success" type="submit">
                                        <i class="glyphicon glyphicon-ok-sign"></i> @lang('products.update')
                                    </button>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                    <!--/tab-pane-->
                    @if ($user->is_login_oauth == false)
                        <div class="tab-pane" id="password">
                            <form class="form" action="{{ route('profile.password') }}" method="post" id="changePasswordForm">
                                @csrf
                                @method('PUT')
                                <div class="alert alert-primary alert-password d-none" role="alert">
                                    <strong></strong>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="old-password">
                                            <h4>@lang('users.old-pass')</h4>
                                        </label>
                                        <input type="password" id="oldpasswordInput" class="form-control"
                                            name="oldpassword" placeholder="@lang('users.old-pass')">
                                        <span class="invalid-feedback" role="alert" id="oldpasswordError">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="password">
                                            <h4>@lang('auth.password')</h4>
                                        </label>
                                        <input id="passwordInput" type="password" class="form-control @error('address') is-invalid @enderror"
                                            name="password" placeholder="@lang('auth.password')">
                                        <span class="invalid-feedback" role="alert" id="passwordError">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <label for="password-confirmation">
                                            <h4>@lang('auth.password-confirm')</h4>
                                        </label>
                                        <input id="password_confirmation" type="password" class="form-control"
                                            name="password_confirmation" placeholder="@lang('auth.password-confirm')">
                                        <span class="invalid-feedback" role="alert" id="password_confirmationConfirmError">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <br>
                                        <button class="btn btn-lg btn-success" type="submit">
                                            <i class="glyphicon glyphicon-ok-sign"></i> @lang('products.update')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
