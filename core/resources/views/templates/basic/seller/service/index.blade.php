@extends('Template::layouts.master')
@section('content')
    <!-- Dashboard Top Section -->
    <div class="dashboard-top mb-4">
        <form class="search-form" method="GET">
            <div class="input-group">
                <input class="form-control form--control bg-white" type="text" name="search"
                    value="{{ request()->search ?? '' }}" placeholder="@lang('Search')...">
                <button class="btn btn--base" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <a href="{{ route('user.seller.service.basic') }}" class="btn btn--base btn--lg" role="button">
            <i class="fas fa-plus"></i>
            <span>@lang('Create Service')</span>
        </a>
    </div>

    <!-- Services Table Section -->
    <div class="table-section">
        <div class="table-area">
            <table class="table table--custom table-responsive--xl">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Delivery Time')</th>
                        <th>@lang('Step')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Last Update')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="{{ poster(@$service->image ? getFilePath('service') . '/' . @$service->image : 'assets/images/default.png', false) }}"
                                            alt="@lang('Service Image')">
                                    </div>
                                    <div class="content text-start" data-bs-toggle="tooltip"
                                        title="{{ __($service->name) }}">
                                        {{ __(strLimit($service->name, 30)) }}
                                    </div>
                                </div>
                            </td>
                            <td>{{ __($service->category->name) }}</td>
                            <td><span class="text-nowrap">{{ showAmount($service->price) }}</span></td>
                            <td>{{ $service->delivery_time }} @lang('Days')</td>
                            <td>@php echo $service->stepBadge @endphp</td>
                            <td>
                                <div>@php echo $service->customStatusBadge @endphp</div>
                            </td>
                            <td>
                                <small>
                                    {{ showDateTime($service->updated_at) }}
                                    <br>
                                    {{ diffforhumans($service->updated_at) }}
                                </small>
                            </td>
                            <td>
                                <a class="btn btn--base text-white btn-sm ms-1"
                                    href="{{ route('user.seller.service.basic', $service->id) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-offset="0,8" title="@lang('Edit')">
                                    <i class="las la-pencil-alt"></i>
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">
                                @include('Template::partials.empty', [
                                    'message' => 'No service created yet!',
                                ])
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            @if ($services->hasPages())
                {{ paginateLinks($services) }}
            @endif
        </div>
    </div>
@endsection
