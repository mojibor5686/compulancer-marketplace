@extends('Template::layouts.master')
@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="show-filter  text-end">
                <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i>
                    @lang('Filter')</button>
            </div>
            <div class="card responsive-filter-card custom--card mt-4 mt-md-0">
                <div class="card-body p-3">
                    <form>
                        <div class="d-flex flex-wrap row-gap-3 column-gap-4">
                            <div class="flex-grow-1">
                                <label class="form-label form--label">@lang('Trx Number')</label>
                                <input class="form-control form--control" type="text" name="search"
                                    value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="flex-grow-1 min-w-120">
                                <label class="form-label form--label">@lang('Type')</label>

                                <select name="trx_type" class="form-select form--select select2-basic"
                                    data-minimum-results-for-search="-1">
                                    <option value="">@lang('All')</option>
                                    <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                                    <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                                </select>

                            </div>
                            <div class="flex-grow-1 min-w-120">
                                <label class="form-label form--label">@lang('Remark')</label>

                                <select class="form-select form--select select2-basic" data-minimum-results-for-search="-1"
                                    name="remark">
                                    <option value="">@lang('All')</option>
                                    @foreach ($remarks as $remark)
                                        <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                            {{ __(keyToTitle($remark->remark)) }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--base w-100 h-100 h-50"><i class="las la-filter"></i>
                                    @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            @include('Template::partials.transaction')
        </div>
    </div>
@endsection

@push('style')
    <style>
        .min-w-120 {
            min-width: 120px;
        }
    </style>
@endpush
