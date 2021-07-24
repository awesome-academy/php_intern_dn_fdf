<div class="modal fade" id="modalSuggest" tabindex="-1" role="dialog" aria-labelledby="registerModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegister">@lang('suggest.info-suggest')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="suggestForm">
                    @csrf
                    <div class="form-group row">
                        <label for="cateInputSuggest" class="col-md-4 col-form-label text-md-right">@lang('suggest.cate_id')</label>

                        <div class="col-md-6">
                            <input id="cateInputSuggest" readonly="readonly" type="text" class="form-control" name="cate" autocomplete="cate">

                            <span class="invalid-feedback" role="alert" id="cateErrorSuggest">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nameInputSuggest"
                            class="col-md-4 col-form-label text-md-right">@lang('products.name_product')</label>

                        <div class="col-md-6">
                            <input id="nameInputSuggest" readonly="readonly" type="text" class="form-control" name="name" required autocomplete="name">

                            <span class="invalid-feedback" role="alert" id="nameErrorSuggest">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="priceInputSuggest"
                            class="col-md-4 col-form-label text-md-right">@lang('products.price')</label>

                        <div class="col-md-6">
                            <input id="priceInputSuggest" type="number" class="form-control" name="price" required>

                            <span class="invalid-feedback" role="alert" id="priceErrorSuggest">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="descriptionInputSuggest"
                            class="col-md-4 col-form-label text-md-right">@lang('products.description')</label>

                        <div class="col-md-6">
                            <textarea class="form-control" rows="5" id="descriptionInputSuggest" name="description" required autocomplete="description" required>
                            </textarea>

                            <span class="invalid-feedback" role="alert" id="descriptionErrorSuggest">
                                <strong></strong>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                @lang('homepage.register')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
