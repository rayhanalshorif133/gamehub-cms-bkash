@extends('layouts.web', ['type' => 'account'])


@section('content')
    <style>
        .game-card-container {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            margin: auto;
        }

        .section-title-toggle {
            font-weight: bold;
            font-size: 1.1rem;
            padding: 10px;
            background: #82c0ff;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
            border: 1px solid #eee;
        }

        .section-title-toggle:hover {
            background: #e9ecef;
        }

        /* Leaderboard Scroll Container */
        .leaderboard-scroll-container {
            max-height: 300px;
            /* Adjust height as needed */
            overflow-y: auto;
            margin-top: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
            background: #fff;
        }

        /* Custom Scrollbar Styling */
        .leaderboard-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .leaderboard-scroll-container::-webkit-scrollbar-thumb {
            background: #e2136e;
            border-radius: 10px;
        }

        .leaderboard-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .prize-table {
            width: 100%;
            border-collapse: collapse;
        }

        .prize-table thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 10;
            padding: 10px;
            font-size: 0.85rem;
            border-bottom: 2px solid #dee2e6;
            color: #333;
        }

        .prize-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }

        .image-container {
            width: 85%;
            margin: 15px auto;
        }

        .game_card_footer_direct_play {
            margin-bottom: 10px;
        }

        .game_card_footer_direct_play a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        /* Toggle Classes */
        .content-hidden {
            display: none;
        }

        /* Leaderboard Section Styling */
        .leaderboard-wrapper {
            margin-top: 20px;
            border-top: 1px solid #f1f1f1;
            padding-top: 20px;
        }

        .leaderboard-toggle-btn {
            width: 100%;
            background: #fff;
            border: 2px solid #f0f0f0;
            padding: 12px 18px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 700;
            color: #444;
        }

        .leaderboard-toggle-btn:hover {
            background: #fdfdfd;
            border-color: #e2136e;
        }

        .leaderboard-scroll-container {
            max-height: 280px;
            overflow-y: auto;
            margin-top: 12px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        /* Table Styling */
        .prize-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            padding: 0 10px;
        }

        .prize-table thead th {
            padding: 10px;
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
            border: none;
        }

        .prize-table tbody tr {
            background: #f8f9fa;
            transition: transform 0.2s;
        }

        .prize-table tbody tr:hover {
            transform: scale(1.01);
            background: #f1f1f1;
        }

        .prize-table td {
            padding: 12px 10px;
            border: none;
            vertical-align: middle;
        }

        /* Rank Styling */
        .rank-box {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 800;
            font-size: 13px;
            background: #eee;
            color: #666;
        }

        /* Top 3 Special Badges */
        tr:nth-child(1) .rank-box {
            background: #FFD700;
            color: #fff;
            box-shadow: 0 3px 8px rgba(255, 215, 0, 0.3);
        }

        tr:nth-child(2) .rank-box {
            background: #C0C0C0;
            color: #fff;
            box-shadow: 0 3px 8px rgba(192, 192, 192, 0.3);
        }

        tr:nth-child(3) .rank-box {
            background: #CD7F32;
            color: #fff;
            box-shadow: 0 3px 8px rgba(205, 127, 50, 0.3);
        }

        /* MSISDN and Score */
        .user-phone {
            font-weight: 600;
            color: #444;
            font-size: 14px;
        }

        .user-score {
            font-weight: 800;
            color: #e2136e;
            font-size: 15px;
        }

        /* Scrollbar Customization */
        .leaderboard-scroll-container::-webkit-scrollbar {
            width: 5px;
        }

        .leaderboard-scroll-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .game-card-container {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            margin: auto;
        }



        .rules-list-container {
            list-style: none;
            padding: 15px 10px;
            margin: 0;
            text-align: left;
        }

        .prize-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .prize-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            font-size: 0.9rem;
        }

        .image-container {
            width: 85%;
            margin: 15px auto;
        }

        .gift_announcement_card {
            position: absolute;
            bottom: 0;
            background: #ff0000;
            color: #ffffff;
            width: 100%;
            border-radius: 0 0 10px 10px;
        }

        .input-group-custom {
            display: flex;
            border: 1px solid #ced4da;
            border-radius: 8px;
            overflow: hidden;
            margin: 15px 0;
            width: stretch;
            position: relative;
        }

        .input-group-custom input {
            border: none;
            padding: 10px;
            flex: 1;
            outline: none;
            width: inherit;
        }

        .input-group-custom button {
            background: #e2136e;
            color: white;
            border: none;
            padding: 0 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            position: absolute;
            right: 0;
            height: 100%;
            font-size: 12px;
        }

        /* Toggle Classes */
        .content-hidden {
            display: none;
        }

        .rotate-icon {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        /* New styling for "Your Rank" element based on reference image */
        .user-rank-banner {
            background: #ffffff;
            border-radius: 8px;
            /* Slightly rounded edges like in reference */
            padding: 12px 20px;
            margin: 15px auto;
            /* Centered with top/bottom margin */
            max-width: 90%;
            /* Standard mobile width within container */
            display: inline-flex;
            /* To mimic the 'badge' look of reference */
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
            /* Soft shadow */
            border: 1px solid #f1f1f1;
            /* Fine border line */
            position: relative;
            /* Necessary for the corner cut effect */
        }

        /* The pseudo-elements below create the inward corner cut look like a ribbon or badge */
        .user-rank-banner::before,
        .user-rank-banner::after {
            content: '';
            position: absolute;
            top: 0;
            width: 0;
            height: 0;
            border-style: solid;
        }

        /* Top-left corner cut */
        .user-rank-banner::before {
            left: 0;
            border-width: 15px 15px 0 0;
            border-color: #f1f1f1 transparent transparent transparent;
            /* Match light background or border color */
        }

        /* Bottom-right corner cut */
        .user-rank-banner::after {
            right: 0;
            bottom: 0;
            top: auto;
            /* Override default 'top: 0' from before */
            border-width: 0 0 15px 15px;
            border-color: transparent transparent #f1f1f1 transparent;
            /* Match light background or border color */
        }

        /* Actual text inside the banner */
        .user-rank-banner .rank-text {
            color: #333333;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            line-height: 1;
            /* Match reference design */
        }

        .score_active_container {
            background-color: #e2136e;
            color: white;
            position: absolute;
            top: 0;
            width: 100%;
        }

        .score_active_container p {
            margin: 0;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: auto;
        }

        /* Container Styles */
        .boost-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .boost-title {
            margin-top: 0;
            margin-bottom: 20px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Card Styles */
        .boost-card {
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 12px;
            border: 1px solid #eee;
            transition: transform 0.2s ease;
        }

        .boost-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Info Section (Icon + Text) */
        .boost-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .boost-icon {
            font-size: 24px;
            background: #f0f2f5;
            width: 45px;
            height: 45px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }

        .boost-name {
            margin: 0;
            font-weight: bold;
            font-size: 16px;
            color: #1a1a1a;
        }

        .boost-info small {
            color: #666;
            display: block;
        }

        /* Button Styles */
        .boost-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
        }

        .boost-btn:hover {
            background-color: #0056b3;
        }

        .boost-btn:active {
            transform: scale(0.95);
        }

        /* Specific colors for multipliers (Optional) */
        .boost-btn[data-multiplier="3"] {
            background-color: #ff4757;
        }

        .boost-btn[data-multiplier="3"]:hover {
            background-color: #e04050;
        }

        .game_boost_image {
            width: 120px;
            height: 120px;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .game_boost_image:hover {
            transform: scale(1.05);
        }

        .game_boost_image_container {
            position: relative;
            display: flex;
            justify-content: center;
            border-radius: 20px;
            margin: 20px 0;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .game_boost_title {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            font-size: 1.5rem;
            align-items: center;
            font-weight: 700;
            margin: 0 10px;
            color: #333;
        }
    </style>
    <section id="section_one" class="overflow-hidden">

        <input type="hidden" id="camp_id" value="{{ $camp_id }}" />
        <input type="hidden" id="keyword" value="{{ $game->keyword }}" />
        <div class="container" style="margin-bottom: 10rem;margin-top: 2rem;">
            <div class="game-card game_over_card" style="padding: 2rem" data-campid="{{ $camp_id }}">
                <div class="game_card_text">
                    <h1 class="game_over">
                        PREMIUM BOOSTS!!!
                    </h1>
                </div>
                <div class="game_boost_image_container">
                    <img src="{{ $game->icon }}" alt="Stick Monkey" class="game_boost_image">
                    <h2 class="game_boost_title">{{ $game->title }}</h2>
                </div>
                <div class="boost-container">
                    @if ($boostIsActive)
                        <div class="boost-alert">
                            <div style="display: flex; align-items: center;">
                                <span style="font-size: 24px; margin-right: 12px;">🚀</span>
                                <div>
                                    <h4 style="margin: 0; color: #166534; font-weight: bold;">Boost is Active!</h4>
                                    <p style="margin: 4px 0 0; color: #15803d; font-size: 14px;">
                                        Enjoy your gaming session. Check back later for more exciting boosts!
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <h4 class="boost-title">⚡ Boost Your Score</h4>

                        @foreach ($boosts as $boost)
                            <div class="boost-card">
                                <div class="boost-info">
                                    <span class="boost-icon">🚀</span>
                                    <div>
                                        <p class="boost-name">{{ $boost->name }}</p>
                                        <small>{{ $boost->desc }}</small>
                                    </div>
                                </div>
                                <button class="boost-btn" data-boost_id="{{ $boost->id }}"
                                    data-amount="{{ $boost->amount }}">
                                    Buy ৳{{ $boost->amount }}
                                </button>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="d-flex justify-content-center">
                    <div class="game_card_footer_direct_play">
                        <a href="/">
                            Back to Home
                        </a>
                    </div>
                    <div class="game_card_footer_direct_play">
                        <a href="{{ $gameURL }}" id="game_url">Play Again</a>
                    </div>

                </div>
            </div>
        </div>


        <button id="bKash_button" class="d-none"></button>
    </section>
@endsection

@section('footerPart')
    @php
        $type = 'account';
    @endphp
    <div
        style="position: fixed;left: 0;bottom: 50px;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%;width: 100%;height: 50px;text-align: left;z-index: 9999;">
        <div class="row">
            <div class="col-md-12">
                <footer id="footer-menu-panel">
                    <nav class="navbar-expand fixed-bottom">
                        <ul class="navbar footer-body"
                            style="padding:12px 20px 22px 20px !important;position: relative;bottom: 44px;">
                            <li class="nav-item">
                                <a class="nav-link @if ($type == 'category') active @endif" aria-current="page"
                                    href="{{ route('category') }}">
                                    <i class="fa-solid fa-layer-group fa-2x"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if ($type == 'home') active @endif"
                                    href="{{ route('home') }}">
                                    <i class="fas fa-home fa-2x"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                @if (Auth::check())
                                    <a class="nav-link @if ($type == 'account') active @endif" aria-current="page"
                                        href="{{ route('account') }}">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                @else
                                    <a class="nav-link @if ($type == 'category') loginModalBtn @endif @if ($type == 'account') active @endif"
                                        aria-current="page" href="#" data-toggle="modal" data-target="#loginModel">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </nav>

                </footer>
            </div>
        </div>
    </div>

    <button id="bkash_btn" type="button" onclick="window.webViewJSBridge.goBackHome('Tickets')"
        style="position: fixed;left: 0;bottom: 0;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%; 
color: white!important;width: 100%;height: 50px;text-align: left;background-color: #E2136E;border-color: #E2136E;z-index: 9999;">
        Back to bKash App Home<img src="https://capp-cdn.labs.bka.sh/images/arrow.svg"
            style="float: right;margin-top: 1%; 
padding-right: 1%;"></button>
@endsection


@push('scripts')
    <script>
        $(() => {
            $('.boost-btn').click(function() {
                var boost_id = $(this).data('boost_id');
                const amount = $(this).data('amount');
                const camp_id = $('#camp_id').val();
                const keyword = $('#keyword').val();

                $(this).attr('disabled', true).text('Processing...');

                $('#bKash_button').attr('data-boost_id', boost_id);
                $('#bKash_button').attr('data-campid', camp_id);
                $('#bKash_button').attr('data-keyword', keyword);
                $('#bKash_button').attr('data-amount', amount);
                $('#bKash_button').attr('data-type', 'boost');
                $('#bKash_button').click();
            });
        });
    </script>
@endpush
