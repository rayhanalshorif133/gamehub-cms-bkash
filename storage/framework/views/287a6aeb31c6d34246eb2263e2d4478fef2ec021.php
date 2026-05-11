<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Category</title>
    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Custom styles for this template -->
    <link href="assets/dist/animate/animate.min.css" rel="stylesheet">

    <link href="assets/dist/ionicons/css/ionicons.css" rel="stylesheet">
    <link href="assets/dist/owlcarousel/assets/owl.carousel.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/css/lucide.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
    <link href="<?php echo e(asset('assets/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/category.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/modal.css')); ?>" rel="stylesheet">

    <script type="text/javascript" src="https://cdn.capp.bka.sh/scripts/webview_bridge.js"></script>


    <style>
        .absolute {
            position: absolute;
            bottom: 5px;
            right: 10px;
            justify-content: center;
            align-items: center;
            background: #FF0000;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px 10px;
        }

        .relative {
            position: relative;
        }

        .play_container:hover .absolute {
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 2rem;
            cursor: pointer;
            padding: 0;
            bottom: 0;
            right: 0;
        }
    </style>

</head>

<body>

    <div class="container mt-3" id="search">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <input type="text" id="game_search" class="form-control" placeholder="Search Game ...">
            </div>
        </div>
    </div>


    <main role="main">
        <section id="category-part">
            <div class="container">
                <div class="row">
                    <div class="col-12 popular-games">
                        <h1 class="section-title">Popular Games</h1>
                        <?php echo $__env->make('_partials.flashMessage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="custom-nav">
                            <button class="custom-prev"><i class="fas fa-chevron-left"></i></button>
                            <button class="custom-next"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="owl-carousel owl-theme one-by-one">
                            <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(Auth::check()): ?>
                                    <div class="item gameDetailsModal" data-bs-toggle="offcanvas"
                                        data-bs-target="#game-offcanvas" aria-controls="game-offcanvas"
                                        data-gameid="<?php echo e($item->id); ?>">
                                        <div class="play_container relative">
                                            <img src="<?php echo e(asset($item->banner)); ?>" alt=""
                                                class="img img-fluid" />
                                            <div class="absolute">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="item gameDetailsModal loginModalBtn">
                                        <div class="play_container relative">
                                            <img src="<?php echo e(asset($item->banner)); ?>" alt=""
                                                class="img img-fluid" />
                                            <div class="absolute">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--/ All Game   /-->
        <section id="section_two" class="mb-4">
            <div class="container">
                <div class="row" style="margin-bottom: 7rem;">
                    <div class="col-12">
                        <h1 class="section-title">All Games</h1>
                        <?php if(Auth::check()): ?>
                            <input type="hidden" id="auth_phone_number" value="<?php echo e(Auth::user()->phone); ?>" />
                        <?php endif; ?>

                    </div>

                    <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-md-4">
                            <?php if(Auth::check()): ?>
                                <div class="single-game-box gameDetailsModal" data-bs-toggle="offcanvas"
                                    data-bs-target="#game-offcanvas" aria-controls="game-offcanvas"
                                    data-gameid="<?php echo e($game->id); ?>">
                                    <img src="<?php echo e(asset($game->icon)); ?>" alt="icon" />
                                    <div class="single-game-box-text" style="background-color: <?php echo e($game->bg_color); ?>">
                                        <p><?php echo e($game->title); ?></p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="single-game-box loginModalBtn">
                                    <img src="<?php echo e(asset($game->icon)); ?>" alt="icon" />
                                    <div class="single-game-box-text" style="background-color: <?php echo e($game->bg_color); ?>">
                                        <p><?php echo e($game->title); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>

    </main>

    <?php echo $__env->make('_partials.web_footer', ['type' => 'category'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
    <?php echo $__env->make('_partials.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <div
        style="position: fixed;left: 0;bottom: 50px;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%;width: 100%;height: 50px;text-align: left;z-index: 9999;">
        <div class="row">
            <div class="col-md-12">
                <footer id="footer-menu-panel">
                    <nav class="navbar-expand fixed-bottom">
                        <ul class="navbar footer-body"
                            style="padding:12px 20px 22px 20px !important;position: relative;bottom: 44px;">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                    href="<?php echo e(route('category')); ?>">
                                    <i class="fa-solid fa-layer-group fa-2x"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?php echo e(route('home')); ?>">
                                    <i class="fas fa-home fa-2x"></i>
                                </a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <?php if(Auth::check()): ?>
                                    <a class="nav-link"
                                        aria-current="page" href="<?php echo e(route('account')); ?>">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                <?php else: ?>
                                    <a class="nav-link loginModalBtn"
                                        aria-current="page" href="#" data-toggle="modal"
                                        data-target="#loginModel">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>

                </footer>
            </div>
        </div>
    </div>

        <button id="bkash_btn" type="button" onclick="window.webViewJSBridge.goBackHome('Tickets')"
        style="position: fixed;left: 0;bottom: 0;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%; 
color: white!important;width: 100%;height: 50px;text-align: left;background-color: #E2136E;border-color: #E2136E;">
        Back to bKash App Home<img src="https://capp-cdn.labs.bka.sh/images/arrow.svg"
            style="float: right;margin-top: 1%; 
padding-right: 1%;"></button>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> -->

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="<?php echo e(asset('assets/dist/owlcarousel/owl.carousel.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dist/scrollreveal/scrollreveal.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/main.js')); ?>"></script>

    <script type="text/javascript">
        $(".loginModalBtn").click(() => {
            var loginModal = new bootstrap.Modal(document.getElementById('loginModel'));
            loginModal.show();
        });


        $(() => {



            $("#game_search").keyup(function() {
                const search = $(this).val();
                $(".single-game-box").each(function() {
                    $(this).parent().hide();
                    const title = $(this).find("p").text();
                    if (title.toLowerCase().includes(search.toLowerCase())) {
                        $(this).parent().show();
                    }
                });

                if (search === '') {
                    $(".popular-games").show();
                } else {
                    $(".popular-games").hide();
                }
            });

            $(".gameDetailsModal").click(function() {
                const id = $(this).attr("data-gameid");
                const msisdn = $("#auth_phone_number").val();

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
        });

        $(document).ready(function() {
            const owl = $('.one-by-one');
            owl.owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    700: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });

            // Custom Navigation
            $('.custom-prev').click(function() {
                owl.trigger('prev.owl.carousel');
            });

            $('.custom-next').click(function() {
                owl.trigger('next.owl.carousel');
            });
        });


        $(document).on('click', '.trial-play-btn button', function(e) {
            const id = $(this).data('gameid');
            const url = $(this).data('url');
            axios.get(`/api/set-attend?game_id=${id}&camp_id=free&user_id=2`);

            axios.get(`/game/${id}/fetch?type=attend`)
                .then(function(response) {
                    window.location.href = url;
                });
        });
    </script>


</body>

</html>
<?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/web/category.blade.php ENDPATH**/ ?>