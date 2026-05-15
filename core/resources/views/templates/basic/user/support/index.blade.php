@extends('Template::layouts.master')
@section('content')
    <div class="row gy-3">
        <div class="col-12">
            <div class="table-section">
                <div class="table-area">
                    <table class="table table--custom table-responsive--sm">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $support)
                                <tr>
                                    <td>
                                        <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}">
                                            [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}
                                        </a>
                                    </td>
                                    <td>@php echo $support->statusBadge; @endphp</td>
                                    <td>
                                        @php echo $support->priorityBadge; @endphp
                                    </td>
                                    <td>{{ diffForHumans($support->last_reply) }}</td>
                                    <td>
                                        <a class="btn btn--base text-white btn-sm ms-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-offset="0,8" href="{{ route('ticket.view', $support->ticket) }}"
                                            aria-label="Details" title="@lang('Details')">
                                            <i class="las la-desktop"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">
                                        @include('Template::partials.empty', [
                                            'message' => 'No support ticket created yet!',
                                        ])
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($supports->hasPages())
                        {{ paginateLinks($supports) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
