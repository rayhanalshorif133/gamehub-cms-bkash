@extends('layouts.web', ['type' => 'home'])

@section('content')
    <style>
        .gift_announcement_card {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translate(-50%, 50%);
            background: #E6E6E6;
            width: max-content;
            border-top: 10px;
            border-radius: 10px 10px 0 0;
        }

        .gift_announcement_card p {
            font-weight: bold;
            font-size: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            color: #DD1726;
            padding: 5px 10px;
        }

        .announcement {
            background: #caeeff;
            border-radius: 10px;
            padding: 15px;
            text-align: justify;
            width: 95%;
            display: flex;
            justify-content: center;
            margin: auto;
        }

        .active_boost_container {
            position: absolute;
            top: 25px;
            right: 0px;
            background: #ff000099;
            color: #fff;
            padding: 5px 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            border-radius: 10px 0 0 10px;
        }

        .user_block_msg {
            position: absolute;
            bottom: 40%;
            left: 5%;
            background: #ff1c1c;
            margin: auto;
            text-align: center;
            width: 90%;
            border-top: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            margin: auto;
            font-size: 14px;
            padding: 10px;
            color: #fff;
        }

        .user_block_msg .black_msg_close_btn {
            position: absolute;
            top: -5px;
            right: -2px;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
            background: #fff;
            color: black;
            border-radius: 50%;
            height: 24px;
            width: 24px;
        }

        .user_block_msg .black_msg_close_btn:hover {
            color: #eeeeee;
            transform: scale(1.1);
        }



        .carousel-control-prev,
        .carousel-control-next {
            width: 35px;
            height: 35px;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .active_boost_container {
            position: absolute;
            top: 25px;
            right: 0px;
            background: #ff0000;
            color: #fff;
            padding: 5px 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            border-radius: 10px 0 0 10px;
        }

        .active_boost_container i {
            font-size: 11px;
            margin: 0 3px;
        }

        .active_boost_container span {
            font-size: 12px;
            margin: 3px 0;
        }

        .btn_container {
            display: flex;
            justify-content: space-between;
        }

        .level_progress_overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 12px 12px 14px;
            background: rgba(10, 20, 10, 0.45);
            backdrop-filter: blur(6px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            z-index: 5;
        }

        .level_bar_label {
            font-size: 10px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
            text-align: center;
        }

        .level_nodes {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .level_node {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .level_icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid transparent;
        }

        .level_icon.done {
            background: radial-gradient(circle at 35% 35%, #ffe066, #f5a623);
            border-color: #fff;
            box-shadow: 0 0 0 2px #f5a623, 0 4px 12px rgba(245, 166, 35, 0.6);
        }

        .level_icon.locked {
            background: radial-gradient(circle at 35% 35%, #888, #444);
            border-color: #aaa;
        }

        .level_icon.boss {
            background: radial-gradient(circle at 35% 35%, #ff6b6b, #c0392b);
            border-color: #fff;
            width: 50px;
            height: 50px;
            font-size: 22px;
            box-shadow: 0 0 0 2px #e74c3c, 0 4px 14px rgba(231, 76, 60, 0.7);
        }

        .level_connector {
            height: 5px;
            width: 36px;
            margin-bottom: 16px;
            border-radius: 3px;
            flex-shrink: 0;
        }

        .level_connector.done {
            background: linear-gradient(90deg, #f5a623, #ffe066);
        }

        .level_connector.locked {
            background: #555;
        }

        .level_name {
            font-size: 9px;
            font-weight: 800;
            margin-top: 4px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .level_name.done {
            color: #ffe066;
        }

        .level_name.locked {
            color: #aaa;
        }

        .level_name.boss {
            color: #ff9999;
        }

        .boss_badge {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: #c0392b;
            color: #fff;
            font-size: 7px;
            font-weight: 900;
            padding: 2px 6px;
            border-radius: 4px;
            letter-spacing: 1px;
            white-space: nowrap;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 2px #f5a623, 0 4px 12px rgba(245, 166, 35, 0.6);
            }

            50% {
                box-shadow: 0 0 0 4px #f5a623, 0 4px 18px rgba(245, 166, 35, 0.9);
            }
        }
    </style>





    @if (!Auth::check())
        <div class="main_logo">
            <img class="logo_image" src="./images/logo.png" />
        </div>
    @endif
    <section id="section_one">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="min-h-screen" style="margin-top:1rem;">
                        @include('_partials.flashMessage')
                        <div style="border-radius: 20px;width: auto;padding-top:10px;padding-bottom: 10px;gap: 10px;">
                            <div id="campaignSlider" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($campaigns as $key => $campaign)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            @if (Auth::check())
                                                <div class="game-card gameDetailsCampaignModal"
                                                    data-campid="{{ $campaign->id }}"
                                                    style="background: linear-gradient(135deg, #fce4ec 0%, {{ $campaign->bg_color }} 100%)">
                                                @else
                                                    <div class="game-card" data-toggle="modal" data-target="#loginModel">
                                            @endif
                                            <div class="game_card_text">
                                                <h1>Play & Win</h1>
                                                <h2>{{ $campaign->name }}</h2>
                                            </div>
                                            <div class="image-container">
                                                <img src="{{ asset($campaign->banner) }}" alt="{{ $campaign->name }}"
                                                    class="d-block w-100">
                                                {{-- @if ($campaign->hasLevel) @endif --}}
                                                <div class="gift_announcement_card">
                                                    <p>মোট পুরস্কার ৳ {{ $campaign->gift_amount }}</p>
                                                </div>
                                                <div class="active_boost_container">
                                                    <i class="fas fa-user"></i>
                                                    <span>{{ $campaign->count_player }}</span>
                                                </div>


                                            </div>
                                            <div class="game_card_footer mb-3">
                                                @if (Auth::check() && isset($campaign->has_charge_log) && $campaign->has_charge_log)
                                                    <button>Play Now</button>
                                                @else
                                                    <div class="btn_container">
                                                        <button>{{ $campaign->amount }} TK</button>
                                                        <button class="mt-1 trial_play" style="background: #495057">Trial
                                                            Play</button>
                                                    </div>
                                                @endif

                                                <div class="game_card_footer_time">
                                                    <p>Start:
                                                        {{ \Carbon\Carbon::parse($campaign->start_date)->format('d M Y') }}
                                                    </p>
                                                    <p>End:
                                                        {{ \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if ($campaign->block)
                                                <div class="user_block_msg">
                                                    <span class="black_msg_close_btn"
                                                        data-campid="{{ $campaign->id }}">&times;</span>
                                                    <p>{{ $campaign->block->message }}</p>
                                                </div>
                                            @endif

                                        </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- Slider Controls --}}
                            @if (count($campaigns) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#campaignSlider"
                                    data-bs-slide="prev">
                                    <i class="fa-solid fa-chevron-left" style="color: #ffffff; font-size: 24px;"></i>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#campaignSlider"
                                    data-bs-slide="next">
                                    <i class="fa-solid fa-chevron-right" style="color: #ffffff; font-size: 24px;"></i>
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="announcement d-none">
                    প্রিয় গেমারস, সবাইকে ঈদ মোবারক। বিডি গেমার্স এর সাপ্তাহিক টুর্নামেন্ট যথারীতি চলমান থাকবে। তবে ঈদ
                    উল ফিতর উপলক্ষে যেহেতু বিকাশ ও প্যাক রাশ গেমস পরিচালনাকারী প্রতিষ্ঠান B2M Technologies Ltd বন্ধ
                    থাকবে তাই উক্ত সময়ের বিজয়ীদের পুরষ্কার ২৯ – ৩০ এ মার্চ এর মাঝে যথাযথ ভাবে প্রদান করা হবে। বিডি
                    গেমার্স এর সাথে থাকার জন্য ধন্যবাদ।
                </div>
            </div>
        </div>
        </div>
    </section>
    <section id="section_last" style="margin-bottom: 4rem;">
        <div class="container" style="background-color: #efefef; margin-top: 1rem;">
            <div class="row" style="padding-bottom: 1rem;">
                <div class="col-12">
                    <h1 class="section-title">All Games</h1>

                    @if (count($games) == 0)
                        <div class="alert alert-danger" role="alert">
                            No games found. Please check back later
                        </div>
                    @endif
                </div>


                @foreach ($games as $key => $game)
                    <div class="col-6 col-md-4 col-lg-3">
                        @if (Auth::check())
                            <div class="single-game-box gameDetailsModal" data-bs-toggle="offcanvas"
                                data-bs-target="#game-offcanvas" aria-controls="game-offcanvas"
                                data-gameid="{{ $game->id }}">
                                <img src="{{ asset($game->icon) }}" alt="icon" />
                                <div class="single-game-box-text" style="background-color: {{ $game->bg_color }}">
                                    <p>{{ $game->title }}</p>
                                </div>
                            </div>
                        @else
                            <div class="single-game-box" data-toggle="modal" data-target="#loginModel">
                                <img src="{{ asset($game->icon) }}" alt="icon" />
                                <div class="single-game-box-text" style="background-color: {{ $game->bg_color }}">
                                    <p>{{ $game->title }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
                <div class="view_all_games">
                    <a href="{{ route('category') }}">View All Games</a>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('footerPart')
    @php
        $type = 'home';
    @endphp
    <div
        style="position: fixed;left: 0;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%;width: 100%;height: 50px;text-align: left;z-index: 9999;">
        <div class="row">
            <div class="col-md-12">
                <footer id="footer-menu-panel">
                    <nav class="navbar-expand fixed-bottom">
                        <ul class="navbar footer-body" style="padding:12px 20px 22px 20px !important;position: relative;">
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
                            </li>
                            <li class="nav-item">
                                @if (Auth::check())
                                    <a class="nav-link @if ($type == 'account') active @endif"
                                        aria-current="page" href="{{ route('account') }}">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                @else
                                    <a class="nav-link @if ($type == 'category') loginModalBtn @endif @if ($type == 'account') active @endif"
                                        aria-current="page" href="#" data-toggle="modal"
                                        data-target="#loginModel">
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
@endsection
