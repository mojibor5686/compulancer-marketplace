@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Email-Mobile')</th>
                                    <th>@lang('Country')</th>
                                    <th>@lang('Joined At')</th>
                                    <th>@lang('Balance')</th>
                                    @canAny('admin.users.kyc.details', 'admin.users.detail')
                                        <th>@lang('Action')</th>
                                    @endcanAny
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, null, true) }}"
                                                        alt="{{ $user->username }}">
                                                </div>
                                                <div>
                                                    <span class="name fw-bold">{{ $user->fullname }}</span>
                                                    @can('admin.users.detail')
                                                        <br>
                                                        <span class="name small">
                                                            <a
                                                                href="{{ route('admin.users.detail', $user->id) }}"><span>@</span>{{ $user->username }}</a>
                                                        </span>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $user->email }}<br>{{ $user->mobileNumber }}
                                        </td>
                                        <td>
                                            <span class="fw-bold"
                                                title="{{ @$user->country_name }}">{{ $user->country_code }}</span>
                                        </td>



                                        <td>
                                            {{ showDateTime($user->created_at) }} <br>
                                            {{ diffForHumans($user->created_at) }}
                                        </td>


                                        <td>
                                            <span class="fw-bold">

                                                {{ showAmount($user->balance) }}
                                            </span>
                                        </td>

                                        @canAny('admin.users.detail', 'admin.users.kyc.details')
                                            <td>
                                                <div class="button--group">
                                                    @can('admin.users.detail')
                                                        <a href="{{ route('admin.users.detail', $user->id) }}"
                                                            class="btn btn-sm btn-outline--primary">
                                                            <i class="las la-desktop"></i> @lang('Details')
                                                        </a>
                                                    @endcan
                                                    @can('admin.users.kyc.details')
                                                        @if (request()->routeIs('admin.users.kyc.pending'))
                                                            <a href="{{ route('admin.users.kyc.details', $user->id) }}"
                                                                target="_blank" class="btn btn-sm btn-outline--dark">
                                                                <i class="las la-user-check"></i>@lang('KYC Data')
                                                            </a>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </td>
                                        @endcanAny

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($users) }}
                    </div>
                @endif
            </div>
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <x-search-form placeholder="Username / Email" />
@endpush
