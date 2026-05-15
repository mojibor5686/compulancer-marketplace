@extends('Template::layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="table-section">
                <div class="table-area">
                    <table class="table table--custom table-responsive--xl">
                        <thead>
                            <tr>
                                <th class="text-start">@lang('Sender')</th>
                                <th>@lang('Subject')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inboxes as $inbox)
                                @php
                                    $user = $inbox->sender_id == auth()->id() ? $inbox->receiver : $inbox->sender;
                                @endphp
                                <tr>
                                    <td class="text-start">
                                        <div class="author-info">
                                            <div class="thumb">
                                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$user->image, isAvatar: true) }}"
                                                    alt="{{ __($user->username) }}">
                                            </div>

                                            <div class="content">{{ $user->username }}</div>
                                        </div>
                                    </td>
                                    <td>{{ strLimit($inbox->subject, 30) }}</td>
                                    <td>
                                        <a class="btn btn--base btn--sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-offset="0,8"
                                            href="{{ route('user.inbox.messages', $inbox->unique_id) }}"
                                            title="@lang('Conversation')">
                                            <i class="las la-comments"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">
                                        @include('Template::partials.empty', [
                                            'message' => 'No conversations!',
                                        ])
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination Links -->
                    @if ($inboxes->hasPages())
                        {{ paginateLinks($inboxes) }}
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
