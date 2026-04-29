<!-- Offcanvas Bottom -->
<div class="offcanvas offcanvas-bottom custom-offcanvas" tabindex="-1" id="tournament-offcanvas"
    aria-labelledby="offcanvasBottomLabel" data-type="tournament">
    <div class="game-info text-center mb-4 pt-4">
        <div class="game-image text-center mb-3">
            <img src="assets/images/game1.jpg" alt="Game Image"
                class="img-fluid rounded shadow-sm gameDetailsCampaignModalImage"
                style="max-height: 180px; object-fit: cover;">
        </div>

        <!-- Alert -->
        <div class="alert alert-danger payment-alert d-none mt-2" role="alert">
            <strong>Payment Canceled!</strong> Your transaction has been successfully canceled.
        </div>

        <!-- Game Info -->
        <div class="game-info text-center mb-4 pt-3">
            <h4 class="fw-bold mb-1 game-name">Game Name</h4>
            <p class="text-muted mb-0 game-description">Game Description</p>
        </div>

        <div class="modal-content">
            <div class="content-upper" style="--height: auto;">
                <div class="btnContainer mb-3 text-center">
                    <div class="game-buttons game-buttons-container"></div>
                </div>
                <!-- Tournament Rules Section -->
                <div class="btnContainer mb-3" style="--margin-bottom: -9px;">
                    <button class="d-flex align-items-center tournamentRulesBtn">
                        Tournament Rules <i class="fa-solid fa-angle-down mx-2 rotate-icon"></i>
                    </button>
                    <div class="dropdown-container hidden tournamentRulesBtn-container p-3 rounded bg-light shadow-sm" style="padding: 12px;">
                        <div class="item mb-2">
                            <p class="mb-0">1.গেমস খেলে প্রতিদিন পুরস্কার পেতে বিডি গেমার্স এ সাবস্ক্রাইব করুন।</p>
                        </div>

                        <div class="item mb-2">
                            <p class="mb-0" id="subs_validity">2. সাবস্ক্রিপশন চার্জ ১০ টাকা মেয়াদ সর্বোচ্য ৩ দিন।</p>
                        </div>

                        <div class="item mb-2">
                            <p class="mb-0" id="prize_description">3. টুর্নামেন্ট শেষে শীর্ষ ৩ জন পাবে ১ম স্থান অধিকারি ৳১০০ ২য় স্থান অধিকারি ৳৭৫ ও ৩য় স্থান অধিকারি ৳৫০। </p> 
                        </div>
                        <div class="item mb-2">
                            <p class="mb-0">4.পুরষ্কার ঘোষণার ৭২ ঘণ্টার মধ্যে গ্রাহকের বিকাশ নাম্বারে তাদের পুরস্কারের
                                অর্থ পাঠিয়ে দেওয়া হবে।</p>
                        </div>

                        <div class="item mb-2">
                            <p class="mb-0">5.অংশগ্রহণকারীরা প্রোফাইলে যে সকল টুর্নামেন্টে অংশ নিয়েছেন এবং অবস্থান
                                দেখতে পারবে, এছাড়াও টুর্নামেন্ট চলাকালে গেমসের পেইজে, লিডারবোর্ডে, ক্যাম্পেইনের ফলাফল ও
                                বিজয়ীদের তালিকা দেখতে পারবে।</p>
                        </div>
                        <div class="item mb-2">
                            <p class="mb-0" style="flex-direction:column;">
                                6. এছাড়াও বিস্তারিত জানতে হলে উল্লেখিত ঠিকানায় ই-মেইল অথবা সরাসরি কল করতে পারবে।
                                <br />
                                <span class="d-flex">a. <a href="mailto:cservice@b2m-tech.com" class="mx-1">
                                        cservice@b2m-tech.com</a></span> <br />
                                <span class="d-flex">b. <a href="tel:+8801680388774" class="mx-1">8801680388774</a>,
                                    <a href="tel:+8801725298711" class="mx-1">8801725298711</a></span>
                            </p>
                        </div>
                        <div class="item mb-2">
                            <p class="mb-0">
                                বি দ্রঃ টুর্নামেন্টে অংশগ্রহনকারি যদি কোন ধরনের অসুদপায় অবলম্বনের চেষ্টা করে বলে
                                প্রমাণিত হয় সে ক্ষেত্রে তার পুর্ববর্তি সকল স্কোর বাতিল বলে গণ্য হবে এবং তাকে টুর্নামেন্ট
                                থেকে বহিষ্কার করা হবে।
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Price Section -->
                <div class="btnContainer mb-3" style="--margin-bottom: -9px;">
                    <button class="d-flex align-items-center priceBtn">
                        Weekly Prize <i class="fa-solid fa-angle-down mx-2 rotate-icon"></i>
                    </button>
                   
                    <div class="dropdown-container hidden priceBtn-container p-3 rounded bg-light shadow-sm">
                        <div class="item mb-2 d-flex justify-content-between">
                            <p class="mb-0">1st scorer</p>
                            <div class="price"><span>1500 tk</span></div>
                        </div>

                        <div class="item mb-2 d-flex justify-content-between">
                            <p class="mb-0">2nd scorer</p>
                            <div class="price"><span>1000 tk</span></div>
                        </div>

                        <div class="item mb-2 d-flex justify-content-between">
                            <p class="mb-0">3rd scorer</p>
                            <div class="price"><span>750 tk</span></div>
                        </div>

                        <div class="item mb-2 d-flex justify-content-between">
                            <p class="mb-0">4th scorer</p>
                            <div class="price"><span>500 tk</span></div>
                        </div>

                        <div class="item mb-2 d-flex justify-content-between">
                            <p class="mb-0">5th – 8th scorer (Each)</p>
                            <div class="price"><span>250 tk</span></div>
                        </div>

                        <div class="item mb-2 d-flex justify-content-between">
                            <p class="mb-0">9th – 25th scorer (Each)</p>
                            <div class="price"><span>150 tk</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="append_leaderboard custom-sticky"></div>
            <div class="content leaderboard-content" style="--height: auto;"></div>
        </div>



    </div>
</div>



<div class="offcanvas offcanvas-bottom custom-offcanvas" style="--bs-offcanvas-bottom:-45%" tabindex="-1"
    id="game-offcanvas" aria-labelledby="offcanvasBottomLabel">
    <div class="game-info text-center mb-4 pt-4">
        <div class="game-image text-center mb-3">
            <img src="assets/images/game1.jpg" alt="Game Image"
                class="img-fluid rounded shadow-sm gameDetailsModalImage"
                style="max-height: 180px; object-fit: cover;">
        </div>

        <!-- Game Info -->
        <div class="game-info text-center mb-4 pt-3">
            <h4 class="fw-bold mb-1 game-name">Game Name</h4>
            <p class="text-muted mb-0 game-description">Game Description</p>
        </div>

        <div class="modal-content">
            <div class="content-upper" style="--height: auto;">
                <div class="btnContainer mb-3 text-center">
                    <div class="game-buttons game-buttons-container" style="--grid-template-rows:repeat(1, 1fr)">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Payment Modal --}}


<div class="offcanvas offcanvas-bottom custom-offcanvas" tabindex="-1" id="payment-offcanvas"
    aria-labelledby="offcanvasBottomLabel">
    <div class="game-info text-center mb-4 pt-4">
        <div class="game-image text-center mb-3">

            <img src="assets/images/game1.jpg" alt="Game Image"
                class="img-fluid rounded shadow-sm gameDetailsModalImage"
                style="max-height: 180px; object-fit: cover;">
        </div>

        <!-- Game Info -->
        <div class="game-info text-center mb-4 pt-3">
            <h4 class="fw-bold mb-1 game-name">Game Name</h4>
            <p class="text-muted mb-0 game-description">Game Description</p>
        </div>

        <div class="modal-content">
            <div class="content-upper" style="--height: auto;">
                <div class="btnContainer mb-3 text-center">
                    <div class="game-buttons game-buttons-container" style="--grid-template-rows:repeat(1, 1fr)">
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>



{{-- Coin Success Notify --}}
<div class="offcanvas offcanvas-bottom custom-offcanvas" style="--bs-offcanvas-bottom:-50%" tabindex="-1"
    id="coinsuccess-offcanvas" aria-labelledby="offcanvasBottomLabel">
    <div class="game-info text-center mb-4 pt-4">
        <div class="game-image text-center mb-3 modal-header d-flex" style="background-color: azure;">
            <img src="{{ asset('assets/images/coin.png') }}" alt="coin symbol" class="shake" />
        </div>
        <style>
            .success-wrapper {
                border-radius: 12px;
                padding: 30px;
                max-width: 500px;
                margin: auto;
            }
        </style>

        <!-- Game Info -->
        <div class="success-wrapper text-center py-5">
            <div class="success-icon mb-3">
                <svg width="64" height="64" fill="#28a745" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM7 11l5-5-1.4-1.4L7 8.2 5.4 6.6 4 8l3 3z" />
                </svg>
            </div>
            <h4 class="fw-bold text-success">Purchase Successful!</h4>
            <p class="text-muted">You’ve successfully purchased <span class="fw-bold"><span id="set_coins">100</span>
                    Coins</span>.</p>

            <div style="margin-top: 2rem;">
                <button type="button" class="custom_button" style="--bg-color:#FE8702"
                    data-bs-dismiss="offcanvas">OK</button>
            </div>
        </div>
        <div class="failure-wrapper hidden text-center py-5">
            <div class="failure-icon mb-3">
                <svg width="64" height="64" fill="#dc3545" viewBox="0 0 16 16">
                    <path
                        d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0zm3.536 10.95L10.95 11.536 8 8.586l-2.95 2.95-0.586-0.586L7.414 8 4.464 5.05l0.586-0.586L8 7.414l2.95-2.95 0.586 0.586L8.586 8l2.95 2.95z" />
                </svg>
            </div>
            <h4 class="fw-bold text-danger">Purchase Failed!</h4>
            <p class="text-muted" id="failedMessage">Something went wrong. You were unable to purchase the coins.</p>

            <div style="margin-top: 2rem;">
                <button type="button" class="custom_button" style="--bg-color:#dc3545"
                    data-bs-dismiss="offcanvas">Try Again</button>
            </div>
        </div>
    </div>
</div>



{{-- Claim Reward --}}
<div class="modal modelAnimationUp" id="rewardModal" tabindex="-1" role="dialog" aria-labelledby="rewardModal"
    aria-hidden="true" data-animation-in="fadeInLeft" data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <img src="{{ asset('assets/images/coin.png') }}" alt="coin symbol"
                    style="height: 10rem;margin: auto;display: flex;" />
                <div class="game-info rewardModalInfo">
                    <h5 id="setRewardCoin"></h5>
                </div>
                <button type="button" class="claimRewardBtn m-auto d-flex" data-dismiss="modal">
                    Claim Reward
                </button>
            </div>
        </div>
    </div>
</div>


{{-- Reacharge Coin --}}

<div class="offcanvas offcanvas-bottom custom-offcanvas" tabindex="-1" id="recharge-offcanvas"
    aria-labelledby="offcanvasBottomLabel" style="--bs-offcanvas-bottom:-45%">
    <div class="game-info text-center mb-4 pt-4">
        <div class="game-image text-center mb-3 modal-header d-flex" style="background-color: azure;">
            <img src="{{ asset('assets/images/coin.png') }}" alt="coin symbol" class="shake" />
        </div>

        <!-- Game Info -->
        <div class="game-info text-center mb-4 pt-3">
            <div class="alert alert-danger payment-alert hidden" role="alert">
                <div>
                    <strong>Payment Canceled!</strong> Your transaction has been successfully canceled.
                </div>
            </div>
            <div>
                <div class="d-flex coin-input-container">
                    <button type="button" class="btn" id="coin-decrement"><i
                            class="fa-solid fa-minus"></i></button>
                    <input type="number" readonly value="0" class="form-control" placeholder="Enter Coin"
                        id="set-coin" />
                    <button type="button" class="btn" id="coin-increment"><i
                            class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <button id="bKash_button" class="custom_button pay-now" type="button" data-amount="1"
                data-redirect_url="coins">
                Pay Now (<span id="set-coin-tk" class="mx-1">0</span> tk)
            </button>
            <button type="button" class="cancelBtn custom_button" data-bs-dismiss="offcanvas">
                Cancel
            </button>

        </div>


    </div>
</div>

<div class="modal modelAnimationUp" id="rechargeModalPrev" tabindex="-1" role="dialog"
    aria-labelledby="rechargeModal" aria-hidden="true" data-animation-in="fadeInLeft"
    data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content recharge-modal-container">
            <div class="modal-header d-flex">
                <img src="{{ asset('assets/images/coin.png') }}" alt="coin symbol" />
                <p class="text-center m-auto">Reacharge Coin</p>
                <img src="{{ asset('assets/images/coin.png') }}" alt="coin symbol" />
            </div>
            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <div class="alert alert-danger payment-alert hidden" role="alert">
                    <div>
                        <strong>Payment Canceled!</strong> Your transaction has been successfully canceled.
                    </div>
                </div>
                <div>
                    <div class="d-flex coin-input-container">
                        <button type="button" class="btn" id="coin-decrement"><i
                                class="fa-solid fa-minus"></i></button>
                        <input type="number" readonly value="0" class="form-control" placeholder="Enter Coin"
                            id="set-coin" />
                        <button type="button" class="btn" id="coin-increment"><i
                                class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <button type="button" class="paynow-coin d-flex btn" data-amount="1" data-redirect_url="coins"
                    id="bKash_button">
                    Pay Now (<span id="set-coin-tk" class="mx-1">0</span> tk)
                </button>

                <button type="button" class="cancelBtn m-auto d-flex btn" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>





{{-- login --}}
<div class="modal modelAnimationUp" id="loginModel" tabindex="-1" role="dialog" aria-labelledby="loginModel"
    aria-hidden="true" data-animation-in="fadeInLeft" data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="height:auto;overflow-y:inherit;">
            <!-- Modal Header -->
            <div class="modal-header bg-red">
                <div class="game-image">
                    <img src="{{ asset('assets/images/user.png') }}" alt="Game Image" class="img-fluid">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-login-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-login" type="button" role="tab" aria-controls="nav-login"
                            aria-selected="true" style="width: 50%">Login</button>
                        <button class="nav-link" id="nav-register-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-register" type="button" role="tab"
                            aria-controls="nav-register" aria-selected="false" style="width: 50%">Register</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="alert" role="alert" style="padding: 10px">
                        <strong id="loginMessage"></strong>
                    </div>
                    <div class="tab-pane fade show active" id="nav-login" role="tabpanel"
                        aria-labelledby="nav-login-tab">
                        <h5 class="text-center mt-3" id="loginModalTitle">Login Your Account</h5>

                        <form method="POST" action="{{ route('player.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="login_phone" class="form-label">{{ __('Phone Number') }}</label>
                                <input id="login_phone" type="number"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="login_password" class="form-label">{{ __('Password') }}</label>
                                <input id="login_password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                        <h5 class="text-center mt-3" id="loginModalTitle">Create a New Account</h5>

                        {{-- {{ route('player.register') }} --}}
                        <form method="POST" action="#" class="regFrom">
                            @csrf
                            <div class="mb-3">
                                <label for="reg_name" class="form-label">{{ __('Name') }}</label>
                                <input id="reg_name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="reg_phone" class="form-label">{{ __('Phone Number') }}</label>
                                <input id="reg_phone" type="number"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="reg_password" class="form-label">{{ __('Password') }}</label>
                                <input id="reg_password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary btn-block regFromSubmitBtn">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>



<div class="modal modelAnimationUp" id="gameDetailsAccountPageModal" tabindex="-1" role="dialog"
    aria-labelledby="gameDetailsAccountPageModal" aria-hidden="true" data-animation-in="fadeInLeft"
    data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="game-image">
                    <img src="assets/images/game1.jpg" alt="Game Image"
                        class="img-fluid gameDetailsAccountPageModalImage">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <div class="game-info gameDetailsAccountPageModalInfo">
                    <h2>Game Name</h2>
                    <p>Game Description</p>
                </div>
                <div class="game-buttons">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
