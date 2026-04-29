@extends('layouts.web', ['type' => 'account'])

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: sans-serif;
        }

        .app-container {
            margin: 20px auto;
            background: #fff;
            min-height: 100vh;
            padding: 15px;
        }

        /* Carousel */
        .carousel-item {
            border-radius: 20px;
            overflow: hidden;
            height: 180px;
            background: #0b1a27;
            position: relative;
        }

        .play-btn {
            background-color: #d90404;
            border: none;
            width: 100%;
            border-radius: 10px;
            font-weight: bold;
            margin-top: 10px;
        }

        .carousel-indicators [data-bs-target] {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin: 0 5px;
        }

        /* Cards */
        .history-card {
            border-radius: 15px;
            border: 1px solid #eee;
            margin-bottom: 12px;
            padding: 12px;
            position: relative;
        }

        .trophy-icon {
            position: absolute;
            top: 17px;
            right: 3.5rem;
        }

        .rank-badge {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 4px 12px;
            font-weight: bold;
            font-size: 0.85rem;
            width: 5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rank-badge img {
            vertical-align: middle;
        }



        .payment-status {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .price-badge {
            background: #f0f0f0;
            border-radius: 10px;
            padding: 5px 15px;
            font-weight: bold;
        }

        .section-title {
            font-weight: 800;
            font-size: 1.2rem;
            margin: 20px 0 15px 0;
        }
    </style>
@endsection

@section('content')
    <div class="app-container">
        <div id="campaignCarousel" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-indicators" style="margin: -4px;">
                @foreach ($campaigns as $key => $campaign)
                    <button type="button" data-bs-target="#campaignCarousel" data-bs-slide-to="{{ $key }}"
                        class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}">
                    </button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach ($campaigns as $key => $campaign)
                    <div class="carousel-item gameDetailsCampaignModal {{ $key == 0 ? 'active' : '' }}"
                        data-campid="{{ $campaign->id }}"
                        style="background: url('{{ $campaign['banner'] }}') no-repeat center; background-size: cover; border-radius: 10px; min-height: 200px;">

                        <div class="p-3 text-white h-100 justify-content-center position-relative"
                            style="background: rgba(0, 0, 0, 0.5); border-radius: 10px; min-height: 200px;">

                            <h5 class="fw-bold">{{ $campaign['name'] }}</h5>

                            <div class="gap-3 mx-auto position-absolute bottom-0 start-50 translate-middle-x mb-3"
                                style="width: 90%">
                                <div class="d-flex align-items-center gap-4 w-100 py-2 justify-content-center">
                                    <div class="d-flex align-items-center bg-dark bg-opacity-25 px-2 py-1 rounded">
                                        <img src="{{ asset('images/rank.png') }}" class="me-1" style="width: 12px;">
                                        <span class="fw-semibold">
                                            {{ $campaign->position ? $campaign->position : 'N/A' }}
                                        </span>
                                    </div>

                                    <div class="d-flex align-items-center bg-dark bg-opacity-25 px-2 py-1 rounded">
                                        <i class="bi bi-stopwatch text-info me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($campaign['end_date'])->diffForHumans(null, true) }}
                                            left</span>
                                    </div>
                                </div>
                                <button class="btn btn-danger play-btn mt-3" style="width: 100%;">Play Now</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <h6 class="section-title">Tournament History</h6>
        @if (isset($payLogs) && count($payLogs) > 0)
            @foreach ($payLogs as $log)
                <div class="history-card d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <span class="fs-3">🏆</span>
                        <div>
                            <div class="fw-bold small">{{ $log->campaign->name }}</div>
                            <div style="font-size: 0.7rem;" class="text-muted">
                                {{ date('d M, Y', strtotime($log->charge_date)) }}</div>
                        </div>
                    </div>
                    <div style="width: 12px;" class="trophy-icon">
                        <img src="{{ asset('images/rank.png') }}" style="width: 14px; height: auto;">
                    </div>
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="fw-bold small">
                                {{ $log->position ? $log->position : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="list-group-item d-flex align-items-center justify-content-center py-5">
                <div class="text-muted">No tournament history found.</div>
            </div>
        @endif

        <!-- Payment History -->
        <h6 class="section-title">Payment History</h6>
        <div class="list-group list-group-flush border rounded-4 overflow-hidden">
            @if (isset($payLogs) && count($payLogs) > 0)
                @foreach ($payLogs as $log)
                    <div class="list-group-item d-flex align-items-center justify-content-between py-3">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-patch-check-fill text-success fs-4"></i>
                            <div>
                                <div class="fw-bold small">{{ $log->campaign->name }}</div>
                                <div class="payment-status">{{ date('d M, Y', strtotime($log->charge_date)) }}</div>
                            </div>
                        </div>
                        <div class="price-badge">{{ $log->amount }} TK</div>
                    </div>
                @endforeach
            @else
                <div class="list-group-item d-flex align-items-center justify-content-center py-5">
                    <div class="text-muted">No payment history found.</div>
                </div>
            @endif

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const myCarousel = new bootstrap.Carousel(document.getElementById('campaignCarousel'), {
            interval: 35000,
            wrap: true // This enables the loop
        });
    </script>
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
            $(".editBtn").click(function() {
                $(".editBtn").addClass('d-none');
                $(".checkBtn").removeClass('d-none');
                $(".cancelBtn").removeClass('d-none');
                $(".info-container").addClass('d-none');
                $(".form-container").removeClass('d-none');
            });

            $(".cancelBtn").click(function() {
                $(".editBtn").removeClass('d-none');
                $(".checkBtn").addClass('d-none');
                $(".cancelBtn").addClass('d-none');
                $(".info-container").removeClass('d-none');
                $(".form-container").addClass('d-none');
            });

            $(".gameDetailsAccountPage").click(function() {
                const id = $(this).attr("data-campid");
                tournamentOffcanvas(id);
            });



        });


        $(document).on('click', '.bKashButton', function(e) {
            const button = $(this);
            button.text('Processing ...');
            button.attr('disabled', true);
            const camp_id = $(this).attr('data-campid');
            $("#bKash_button").attr("data-campid", camp_id);
            setTimeout(() => {
                $("#bKash_button").click();
            }, 200);
        });
    </script>
@endpush
