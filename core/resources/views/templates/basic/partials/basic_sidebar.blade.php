<li class="offcanvas-sidebar-menu__item">
    <i class="fas fa-th-large smart-icons"></i>
    <span class="offcanvas-sidebar-menu__title">@lang('Basic')</span>
</li>
<ul id="sidebar-main-menu" class="offcanvas-sidebar-menu">
    <li class="offcanvas-sidebar-menu__item {{ menuActive('user.inbox*') }}">
        <a href="{{ route('user.inbox.list') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-inbox smart-icon"></i>
            <span>@lang('Inbox')</span>
        </a>
    </li>
    <li class="offcanvas-sidebar-menu__item {{ menuActive('user.referral.commission') }}">
        <a href="{{ route('user.referral.commission') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-user-friends smart-icon"></i>
            <span>@lang('Referral')</span>
        </a>
    </li>
    <li class="offcanvas-sidebar-menu__item {{ menuActive('user.deposit.index') }}">
        <a href="{{ route('user.deposit.index') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-wallet smart-icon"></i>
            <span>@lang('Deposit Money')</span>
        </a>
    </li>
    <li class="offcanvas-sidebar-menu__item {{ menuActive('user.deposit.history') }}">
        <a href="{{ route('user.deposit.history') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-history smart-icon"></i>
            <span>@lang('Deposit History')</span>
        </a>
    </li>
    <li class="offcanvas-sidebar-menu__item {{ menuActive('user.withdraw') }}">
        <a href="{{ route('user.withdraw') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-money-bill-wave smart-icon"></i>
            <span>@lang('Withdraw Money')</span>
        </a>
    </li>
    <li class="offcanvas-sidebar-menu__item {{ menuActive('user.withdraw.history') }}">
        <a href="{{ route('user.withdraw.history') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-arrow-circle-up smart-icon"></i>
            <span>@lang('Withdraw History')</span>
        </a>
    </li>
    <li class="offcanvas-sidebar-menu__item {{ menuActive('ticket.open') }}">
        <a href="{{ route('ticket.open') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-plus-circle smart-icon"></i>
            <span>@lang('New Ticket')</span>
        </a>
    </li>
    <li class="offcanvas-sidebar-menu__item {{ menuActive(['ticket.index', 'ticket.view']) }}">
        <a href="{{ route('ticket.index') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-ticket-alt smart-icon"></i>
            <span>@lang('My Tickets')</span>
        </a>
    </li>

    <li class="offcanvas-sidebar-menu__item {{ menuActive('user.transactions') }}">
        <a href="{{ route('user.transactions') }}" class="offcanvas-sidebar-menu__link">
            <i class="fas fa-exchange-alt smart-icon"></i>
            <span>@lang('Transaction History')</span>
        </a>
    </li>
</ul>

@push('style')
    <style>
        .smart-icon {
            font-size: 16px;
            margin-right: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            color: #6c757d;
        }
    </style>
@endpush
