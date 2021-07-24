@extends('admin.layouts.app')

@section('content')
    <div class="course-container">
        <div class="course-heading">
            <a href="#" class="info-title" style=" font-size: 20px;">
                <i class="fas fa-users-cog fa-lg fa-fw mr-2 text-gray-400"></i>
                <h5 class="title">@lang('categories.hello') {{ Auth::guard('admin')->user()->fullname }}</h5>
            </a>
        </div>
        @include('common.message')
        @include('common.error')
        <div id="message"></div>
        <div class="course-heading-title">
            <div class="row exam-title-color-class">
                <div class="container">
                    <div class="col-sm-12 text-center">
                        <a href="" class="exam-title-class">
                            <i class="fa fa-list-alt"></i>
                            @lang('suggest.suggests')
                        </a>
                    </div>
                    <div class="info-table-course">
                        <table class="table table-st">
                            <thead class="color__theme">
                                <tr>
                                    <th>@lang('users.fullname')</th>
                                    <th>@lang('categories.name_cate')</th>
                                    <th>@lang('products.name_product')</th>
                                    <th>@lang('suggest.status')</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suggests as $suggest)
                                    <tr>
                                        <td>{{ $suggest->user->name }}</td>
                                        <td>{{ $suggest->category->name }}</td>
                                        <td>{{ $suggest->name }}</td>
                                        <td>{{ $suggest->status }}</td>
                                        <td class="d-flex">
                                            @if ($suggest->status === config('app.status_suggest.pending'))
                                                <button class="btn btn-success btn-suggest mr-2" data-id="{{ $suggest->id }}" data-toggle="modal" data-target="#modalSuggest">@lang('suggest.approve')</button>
                                                <form action="{{ route('admin.suggest.refuse', $suggest->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">@lang('suggest.refuse')</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.form-suggest')
@endsection
