<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>WEB | Bkash Game</title>
    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Custom styles for this template -->
    <link href="<?php echo e(asset('assets/dist/animate/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/dist/owlcarousel/assets/owl.carousel.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/css/lucide.css">
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/home.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/modal.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/new_style.css')); ?>" rel="stylesheet">


    
    <script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
    
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    
    <script type="text/javascript" src="https://cdn.capp.bka.sh/scripts/webview_bridge.js"></script>

    <style>

    </style>

    <?php echo $__env->yieldContent('head'); ?>

</head>

<body style="overflow-x: hidden;">

    <?php if(Auth::check()): ?>
        <header class="container">
            <div class="navbar">
                <div class="logo">
                    <img src="<?php echo e(asset('/images/logo.png')); ?>" alt="logo" class="site_logo" style="width:106px;" />
                </div>
                <div class="d-flex">
                    <div class="container coin-container">
                        <a class="coin-container-box" href="<?php echo e(route('player.points')); ?>">
                            <img src="<?php echo e(asset('assets/images/coin.png')); ?>" alt="coin symbol" class="coin_image" />
                            <div class="mx-2 text-white" id="user_coin_container">
                                <?php echo e(Auth::user()->point); ?>

                            </div>
                            <div class="icon">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                    class="icon-style" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"
                                    style="color: rgb(255, 255, 255);">
                                    <path
                                        d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                    </path>
                                </svg>
                            </div>
                        </a>
                    </div>
                    <div class="profile-icon">
                        <a href="<?php echo e(route('account')); ?>">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <main role="main">

        <?php if(Auth::check()): ?>
            <input type="hidden" id="auth_phone_number" value="<?php echo e(Auth::user()->phone); ?>" />
        <?php endif; ?>


        <?php echo $__env->yieldContent('content'); ?>

    </main>


    <?php echo $__env->make('_partials.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





    <?php echo $__env->yieldContent('footerPart'); ?>







    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo e(asset('assets/dist/owlcarousel/owl.carousel.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dist/scrollreveal/scrollreveal.min.js')); ?>"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="<?php echo e(asset('assets/js/payment.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const url = new URL(window.location);
            if (url.pathname.startsWith('/public')) {
                url.pathname = url.pathname.replace('/public', '');
                window.history.replaceState({}, document.title, url);
            }
        });

        $(() => {



            handleLoginAchievement();


            const offcanvasElement = document.getElementById('tournament-offcanvas');
            const offcanvasInstance = new bootstrap.Offcanvas(offcanvasElement);


            $(document).on('click', '.leaderboardBtn', function(e) {

                $(".leaderboardBtn-container").toggleClass('hidden');

                $(this).find('i').toggleClass('rotated');


                // make a for loop

                const campid = $(this).data('campid');
                axios.get(`/leaderboard/${campid}/fetch`)
                    .then(function(response) {


                        $(".leaderboard-container").removeClass('hidden');
                        const {
                            daily,
                            user,
                            weekly
                        } = response.data.data;
                        $(".dailyLeaderBoard").html('');
                        daily.length > 0 && daily.map(function(item, index) {
                            $(".dailyLeaderBoard").append(`
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${item.msisdn}</td>
                                                <td>${item.total_score}</td>
                                            </tr>
                                        `);
                        });

                        weekly.length > 0 && weekly.map(function(item, index) {
                            $(".weeklyLeaderBoard").append(`
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${item.msisdn}</td>
                                                <td>${item.total_score}</td>
                                            </tr>
                                        `);
                        });
                    });
            });


            $(document).on('click', '.priceBtn', function(e) {
                $(".priceBtn-container").toggleClass('hidden');
                $(this).find('i').toggleClass('rotated');
            });

            $(document).on('click', '.tournamentRulesBtn', function(e) {
                $(".tournamentRulesBtn-container").toggleClass('hidden');
                $(this).find('i').toggleClass('rotated');
            });














            $(document).on('click', '.trial-play-btn button', function(e) {
                const id = $(this).data('gameid');
                const userid = $(this).data('userid');
                const url = $(this).data('url');
                axios.get(`/api/set-attend?game_id=${id}&camp_id=free&user_id=${userid}`);

                axios.get(`/game/${id}/fetch?type=attend`)
                    .then(function(response) {
                        window.location.href = url;
                    });
            });

            $(document).on('click', '.playButtonWithCamp', function(e) {
                const gameid = $(this).data('gameid');
                const campid = $(this).data('campid');
                const userid = $(this).data('userid');
                const url = $(this).data('url');
                axios.get(`/api/set-attend?game_id=${gameid}&camp_id=${campid}&user_id=${userid}`);

                axios.get(`/game/${gameid}/fetch?type=attend`)
                    .then(function(response) {
                        window.location.href = url;
                    });
            });

            $(document).on('click', '#leaderboardTab button', function(e) {
                e.preventDefault();
                $(this).tab('show'); // Bootstrap's method to show a tab
            });





        });



        const handleLoginAchievement = () => {
            const hasLoginAchievement = $("#hasLoginAchievement").val();
            if (hasLoginAchievement) {
                $(".loginAchievementShow").click();
                const type = $(".loginAchievementShow").attr('data-type');
                if (type == 'login-reward') {
                    $("#setRewardCoin").text('+ 10');
                }
            }

        };

        $(document).on('click', '.claimRewardBtn', function(e) {
            axios.get(`/player/reward-coin/10/login-reward`);
        });

        var countClick = 0;

        $(document).on('click', "#bKash_button", function() {
            console.log('button');
            countClick++;

            if (countClick == 1) {
                $(this).click();
            }


            const msisdn = $("#auth_phone_number").val();
            console.log(msisdn);

            const keyword = 'APP';
            const campaign_id = $(this).attr("data-campid");
            const amount = $(this).attr("data-amount");
            const type = $(this).attr("data-type")? $(this).attr("data-type") : 'campain';
            var paymentID = '';


            const PAY_URL = 'https://bkpay.b2mwap.com';
            const ROOT_URL = window.location.origin;
            var redirect_url =
                `${ROOT_URL}/api/callback-payment/msisdn/${msisdn}/campaign_id/${campaign_id}/amount/${amount}/`;

            if(type == 'boost'){
                redirect_url = `${ROOT_URL}/api/app-callback-payment-boost/msisdn/${msisdn}/campaign_id/${campaign_id}/amount/${amount}/boost/${$(this).attr("data-boost_id")}`;
            }

            console.log(redirect_url);
            try {
                bKash.init({
                    paymentMode: 'checkout',
                    paymentRequest: {
                        amount: '' + amount,
                        intent: 'sale'
                    },
                    createRequest: async function(request) {
                        try {
                            const response = await axios.get(
                                `${PAY_URL}/api/payment?keyword=${keyword}&msisdn=${msisdn}&amount=${amount}&redirect_url=${redirect_url}`
                            );
                            const data = response.data;

                            if (data && data.paymentID != null) {
                                const paymentID = data.paymentID;
                                window.sessionStorage.setItem('paymentID', paymentID);
                                bKash.create().onSuccess(data);
                            } else {
                                bKash.create().onError();
                            }

                        } catch (error) {
                            $('#bKash_button').html(`<i class="fas fa-play"></i> Play Now!`);
                            console.error('ERROR 1', error);
                        }
                    },
                    executeRequestOnAuthorization: function() {
                        const paymentID = window.sessionStorage.getItem('paymentID');
                        const url = `${PAY_URL}/api/payment-execute/${paymentID}`;

                        setTimeout(() => {
                            window.location.href = url;
                        }, 1000);
                    },
                    onClose: function() {
                        $(".payment-alert").removeClass('hidden');

                        const buttonText = window.sessionStorage.getItem('button-text');
                        $("#bKash_button").text(buttonText);
                        $("#bKash_button").attr('disabled', true);

                        setTimeout(() => {
                            location.reload();
                        }, 5000);
                    }
                });

            } catch (error) {
                toastr.error('Payment Api Fetching Failed');
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            // Switch tabs on button click
            $('#nav-login-tab').on('click', function() {
                $('#nav-login-tab').addClass('active');
                $('#nav-register-tab').removeClass('active');
                $('#nav-login').addClass('show active');
                $('#nav-register').removeClass('show active');
            });

            $('#nav-register-tab').on('click', function() {
                $('#nav-register-tab').addClass('active');
                $('#nav-login-tab').removeClass('active');
                $('#nav-register').addClass('show active');
                $('#nav-login').removeClass('show active');
            });


        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            const owl = $(".home-page-carousel").owlCarousel({
                center: false,
                items: 1.2,
                loop: true,
                margin: 20,
                nav: false,
                dots: false,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    1024: {
                        items: 3
                    }
                }
            });

            $('.custom-prev').click(function() {
                owl.trigger('prev.owl.carousel');
            });

            $('.custom-next').click(function() {
                owl.trigger('next.owl.carousel');
            });


        });

        // Initialize Lucide icons

        // Update all countdown timers



        function modalAnimation(animation) {
            $('.modal .modal-dialog').attr('class', 'modal-dialog  ' + animation + ' animated');
        };
        $('.modal').on('show.bs.modal', function(e) {
            $('.modal .modal-dialog').attr('class', 'modal-dialog  fadeIn  animated');
        })
        $('.modalAnimate').on('hide.bs.modal', function(e) {
            var anim = $(this).attr('data-animation-out');
            modalAnimation(anim);
        });


        $(".gameDetailsModal").click(function() {
            const id = $(this).attr("data-gameid");
            const msisdn = $("#auth_phone_number").val();

            $(".cancelLeaderBoardBtn").click();

            axios.get(`/game/${id}/fetch?msisdn=${msisdn}`)
                .then(function(response) {
                    const data = response.data.data;
                    $(".gameDetailsModalImage").attr("src", data.banner);
                    $(".game-name").text(data.title);
                    $(".game-description").text(data.description);


                    $(".game-buttons").html(`
                                    <div class="trial-play-btn">
                                        <a href="/game-play/${data.id}/free" class="custom_play_button"><i class="fas fa-play"></i> Trial Play</a>
                                    </div>
                                `);
                })
        });


        $(".regFromSubmitBtn").click(function(e) {
            e.preventDefault();

            const name = $("#reg_name").val();
            const phone = $("#reg_phone").val();
            const password = $("#reg_password").val();



            axios.post(`/player/register`, {
                    name: name,
                    phone: phone,
                    password: password,
                })
                .then(function(response) {

                    const data = response.data;
                    if (data.status == 'success') {
                        $("#loginMessage").text(data.message);
                        $("#loginMessage").parent().addClass('alert-success').removeClass('alert-danger');
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {

                        const errors = data.errors;
                        var show_error = '';
                        if (errors.name) show_error = errors.name[0];
                        if (errors.phone) show_error = errors.phone[0];
                        if (errors.password) show_error = errors.password[0];

                        $("#loginMessage").text(show_error);
                        $("#loginMessage").parent().removeClass('alert-success').addClass('alert-danger');
                    }

                    setTimeout(() => {
                        $("#loginMessage").text('');
                        $("#loginMessage").parent().removeClass('alert-success').removeClass(
                            'alert-danger');
                    }, 10000);
                });
        });
    </script>


</body>

</html>
<?php /**PATH /var/www/bdg.b2mwap.com/resources/views/layouts/web.blade.php ENDPATH**/ ?>