@extends('Template::layouts.master')
@section('content')
    <div class="table-section">
        <div class="table-area">
            <table class="table table--custom table-responsive--xl">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Delivery Time')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($favServices as $service)
                        <tr>
                            <td>
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="{{ poster(@$service->service->image ? getFilePath('service') . '/' . @$service->service->image : 'assets/images/default.png', false) }}"
                                            alt="@lang('Service Image')">
                                    </div>
                                    <div class="content text-start" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __($service->service->name) }}">
                                        {{ __(strLimit($service->service->name, 30)) }}
                                    </div>

                                </div>
                            </td>
                            <td>{{ __($service->service->category->name) }}</td>
                            <td><span class="text-nowrap">{{ showAmount($service->service->price) }}</span></td>
                            <td>{{ $service->service->delivery_time }} @lang('Days')</td>
                            <td>
                                <a class="btn btn--base text-white btn-sm ms-1 details-btn" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    href="{{ route('service.details', [slug($service->service->name), $service->service->id]) }}"
                                    aria-label="@lang('Details')" title="@lang('Details')">
                                    <i class="las la-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">
                                @include('Template::partials.empty', [
                                    'message' => 'Favorite service not found!',
                                ])
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            @if ($favServices->hasPages())
                {{ paginateLinks($favServices) }}
            @endif
        </div>
    </div>
@endsection
