@extends('Template::layouts.master')
@section('content')
    <!-- Favorite Softwares Table Section -->
    <div class="table-section">
        <div class="table-area">
            <table class="table table--custom table-responsive--xl">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($favSoftwares as $software)
                        <tr>
                            <td class="text-start">
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="{{ poster(@$software->software->image ? getFilePath('software') . '/' . @$software->software->image : 'assets/images/default.png', false) }}"
                                            alt="@lang('Software Image')">
                                    </div>
                                    <div class="content" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __($software->software->name) }}">
                                        {{ __(strLimit($software->software->name, 30)) }}
                                    </div>
                                </div>
                            </td>
                            <td>{{ __($software->software->category->name) }}</td>
                            <td><span class="text-nowrap">{{ showAmount($software->software->price) }}</span></td>
                            <td>
                                <a class="btn btn--base text-white btn-sm ms-1 details-btn" data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    href="{{ route('software.details', [slug($software->software->name), $software->software->id]) }}"
                                    aria-label="@lang('Details')" title="@lang('Details')">
                                    <i class="las la-desktop"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">
                                @include('Template::partials.empty', [
                                    'message' => 'Favorite software not found!',
                                ])
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            @if ($favSoftwares->hasPages())
                {{ paginateLinks($favSoftwares) }}
            @endif
        </div>
    </div>
@endsection
