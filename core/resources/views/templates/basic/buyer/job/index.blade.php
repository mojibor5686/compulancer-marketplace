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
        <a href="{{ route('user.buyer.job.basic') }}" class="btn btn--base btn--lg" role="button">
            <i class="fas fa-plus"></i>
            <span>@lang('Create Job')</span>
        </a>
    </div>

    <!-- Jobs Table Section -->
    <div class="table-section">
        <div class="table-area">
            <table class="table table--custom table-responsive--xl">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Budget')</th>
                        <th>@lang('Delivery Time')</th>
                        <th>@lang('Step')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Last Update')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        <tr>
                            <td>
                                <div class="author-info">
                                    <div class="thumb">
                                        <img src="{{ poster(@$job->image ? getFilePath('job') . '/' . @$job->image : 'assets/images/default.png', false) }}"
                                            alt="@lang('Job Image')">
                                    </div>
                                    <div class="content text-start" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ __($job->name) }}">
                                        {{ __(strLimit($job->name, 30)) }}
                                    </div>
                                </div>
                            </td>
                            <td>{{ __($job->category->name) }}</td>
                            <td><span class="text-nowrap">{{ showAmount($job->price) }}</span></td>
                            <td>{{ $job->delivery_time }} @lang('Days')</td>
                            <td>@php echo $job->stepBadge @endphp</td>
                            <td>
                                <div>@php echo $job->customStatusBadge @endphp</div>
                            </td>
                            <td>
                                <small>
                                    {{ showDateTime($job->updated_at) }}
                                    <br>
                                    {{ diffforhumans($job->updated_at) }}
                                </small>
                            </td>
                            <td>
                                <div class="dropdown dropdown-custom">
                                    <button class="btn btn--base btn--sm" id="actionButton" data-bs-toggle="dropdown"
                                        data-bs-toggle="tooltip" data-bs-placement="top" aria-label="@lang('Actions')"
                                        title="@lang('Actions')">
                                        <i class="las la-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu p-0">
                                        <!-- Edit Job Option -->
                                        <a href="{{ route('user.buyer.job.basic', $job->id) }}" class="dropdown-item">
                                            <i class="las la-pencil-alt"></i> @lang('Edit')
                                        </a>

                                        <!-- Bidding List Option -->
                                        <a href="{{ route('user.buyer.job.bidding.list', [slug($job->name), $job->id]) }}"
                                            class="dropdown-item">
                                            <i class="las la-list"></i> @lang('Bidding List')
                                        </a>

                                        <!-- Close Job Option (only if job is approved) -->
                                        @if ($job->status == Status::APPROVED)
                                            <button class="dropdown-item confirmationBtn" data-question="@lang('Are you sure to close this job?')"
                                                data-action="{{ route('user.buyer.job.close', $job->id) }}" type="button">
                                                <i class="las la-times"></i> @lang('Close')
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </td>


                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">
                                @include('Template::partials.empty', [
                                    'message' => 'No job created yet!',
                                ])
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            @if ($jobs->hasPages())
                {{ paginateLinks($jobs) }}
            @endif
        </div>
    </div>

    <!-- Confirmation Modal -->
    <x-confirmation-modal class="frontend" />
@endsection
