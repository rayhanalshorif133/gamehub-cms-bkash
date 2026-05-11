@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ asset('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/images/bkash.png') }}" alt="gp logo" style="height: 28px">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"
                style="text-transform: capitalize;font-size: 24px">Bkash Game</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item @if ($currentRoute == 'admin.dashboard') active open @endif">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-grid-alt @if ($currentRoute == 'admin.dashboard') selectedIconPopup @endif"></i>
                <div class="text-semibold">Dashboard</div>
            </a>
        </li>

        <!-- Campaign -->
        <li class="menu-item @if ($currentRoute == 'admin.prize.index') active open @endif">
            <a href="{{ route('admin.prize.index') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-trophy @if ($currentRoute == 'admin.prize.index') selectedIconPopup @endif"></i>
                <div class="text-semibold">Prize</div>
            </a>
        </li>
        <li class="menu-item @if ($currentRoute == 'admin.campaign.index') active open @endif">
            <a href="{{ route('admin.campaign.index') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-rocket @if ($currentRoute == 'admin.campaign.index') selectedIconPopup @endif"></i>
                <div class="text-semibold">Campaign</div>
            </a>
        </li>

        <!-- Game -->
        <li class="menu-item @if ($currentRoute == 'admin.game.index') active open @endif">
            <a href="{{ route('admin.game.index') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-joystick @if ($currentRoute == 'admin.game.index') selectedIconPopup @endif"></i>
                <div class="text-semibold">Game</div>
            </a>
        </li>

        <!-- Payment Logs -->
        <li class="menu-item @if ($currentRoute == 'admin.report.pay-logs') active open @endif">
            <a href="{{ route('admin.report.pay-logs') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-credit-card-front @if ($currentRoute == 'admin.report.pay-logs') selectedIconPopup @endif"></i>
                <div class="text-semibold">Payment logs</div>
            </a>
        </li>

        <!-- Daily Winner List -->
        {{-- <li class="menu-item @if ($currentRoute == 'admin.report.daily-winner-list') active open @endif">
            <a href="{{ route('admin.report.daily-winner-list') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-trophy @if ($currentRoute == 'admin.report.daily-winner-list') selectedIconPopup @endif"></i>
                <div class="text-semibold">Daily Winner List</div>
            </a>
        </li> --}}

        <!-- Weekly Winner List -->
        <li class="menu-item @if ($currentRoute == 'admin.report.weekly-winner-list') active open @endif">
            <a href="{{ route('admin.report.weekly-winner-list') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-crown @if ($currentRoute == 'admin.report.weekly-winner-list') selectedIconPopup @endif"></i>
                <div class="text-semibold">Weekly Winner List</div>
            </a>
        </li>

        <!-- Score Log -->
        <li class="menu-item @if ($currentRoute == 'admin.report.score-log') active open @endif">
            <a href="{{ route('admin.report.score-log') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-list-ol @if ($currentRoute == 'admin.report.score-log') selectedIconPopup @endif"></i>
                <div class="text-semibold">Score Log</div>
            </a>
        </li>

        <!-- Day Based Score Log -->
        <li class="menu-item @if ($currentRoute == 'admin.report.day-based-score-log') active open @endif">
            <a href="{{ route('admin.report.day-based-score-log') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-calendar-event @if ($currentRoute == 'admin.report.day-based-score-log') selectedIconPopup @endif"></i>
                <div class="text-semibold">Day Based Score Log</div>
            </a>
        </li>

        <!-- Game Play Logs -->
        <li class="menu-item @if ($currentRoute == 'admin.report.play-logs') active open @endif">
            <a href="{{ route('admin.report.play-logs') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-history @if ($currentRoute == 'admin.report.play-logs') selectedIconPopup @endif"></i>
                <div class="text-semibold">Game Play Logs</div>
            </a>
        </li>

    </ul>
</aside>
