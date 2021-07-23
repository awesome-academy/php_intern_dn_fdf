<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLogin">@lang('auth.login')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="loginForm">
                    @csrf
                    <div class="form-group row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-right">@lang('homepage.email_address')</label>

                        <div class="col-md-6">
                            <input id="emailInput" type="email" class="form-control"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            <span class="invalid-feedback" role="alert" id="emailError">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="passwordInput"
                            class="col-md-4 col-form-label text-md-right">@lang('auth.password')</label>

                        <div class="col-md-6">
                            <input id="passwordInput" type="password" class="form-control" name="password" required autocomplete="new-password">

                            <span class="invalid-feedback" role="alert" id="passwordError">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 d-flex flex-column justify-content-center m-auto">
                            <button type="submit" class="btn btn-primary">
                                @lang('auth.login')
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link cursor" data-dismiss="modal" data-toggle="modal" data-target="#modalForgotPass">
                                    @lang('auth.forgot_password')
                                </a>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 d-flex flex-column justify-content-center m-auto">
                            <a class="btn btn-primary cursor" href="{{ route('social.facebook.callback', 'facebook') }}">
                                @lang('auth.login_fb')
                            </a>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" data-dismiss="modal" data-toggle="modal" data-target="#modalRegister">
                                    @lang('auth.dont_have_account')
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
