<?php $__env->startSection('content'); ?>
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
    </style>
    <?php if(!Auth::check()): ?>
        <div class="main_logo">
            <img class="logo_image" src="./images/logo.png" />
        </div>
    <?php endif; ?>
    <section id="section_one">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="min-h-screen" style="margin-top:1rem;">
                        <?php echo $__env->make('_partials.flashMessage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div style="border-radius: 20px;width: auto;padding-top:10px;padding-bottom: 10px;gap: 10px;">
                            <div id="campaignSlider" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                            <?php if(Auth::check()): ?>
                                                <div class="game-card gameDetailsCampaignModal"
                                                    data-campid="<?php echo e($campaign->id); ?>"
                                                    style="background: linear-gradient(135deg, #fce4ec 0%, <?php echo e($campaign->bg_color); ?> 100%)">
                                                <?php else: ?>
                                                    <div class="game-card" data-toggle="modal" data-target="#loginModel">
                                            <?php endif; ?>
                                            <div class="game_card_text">
                                                <h1>Play & Win</h1>
                                                <h2><?php echo e($campaign->name); ?></h2>
                                            </div>
                                            <div class="image-container">
                                                <img src="<?php echo e(asset($campaign->banner)); ?>" alt="<?php echo e($campaign->name); ?>"
                                                    class="d-block w-100">
                                                <div class="gift_announcement_card">
                                                    <p>মোট পুরস্কার ৳ <?php echo e($campaign->gift_amount); ?></p>
                                                </div>
                                                <div class="active_boost_container">
                                                    <i class="fas fa-user"></i>
                                                    <span><?php echo e($campaign->count_player); ?></span>
                                                </div>


                                            </div>
                                            <div class="game_card_footer mb-3">
                                                <?php if(Auth::check() && isset($campaign->has_charge_log) && $campaign->has_charge_log): ?>
                                                    <button>Play Now</button>
                                                <?php else: ?>
                                                    <div class="btn_container">
                                                        <button><?php echo e($campaign->amount); ?> TK</button>
                                                        <button class="mt-1 trial_play" style="background: #495057">Trial
                                                            Play</button>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="game_card_footer_time">
                                                    <p>Start:
                                                        <?php echo e(\Carbon\Carbon::parse($campaign->start_date)->format('d M Y')); ?>

                                                    </p>
                                                    <p>End:
                                                        <?php echo e(\Carbon\Carbon::parse($campaign->end_date)->format('d M Y')); ?>

                                                    </p>
                                                </div>
                                            </div>
                                            <?php if($campaign->block): ?>
                                                <div class="user_block_msg">
                                                    <span class="black_msg_close_btn" data-campid="<?php echo e($campaign->id); ?>">&times;</span>
                                                    <p><?php echo e($campaign->block->message); ?></p>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            
                            <?php if(count($campaigns) > 1): ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#campaignSlider"
                                    data-bs-slide="prev">
                                    <i class="fa-solid fa-chevron-left" style="color: #ffffff; font-size: 24px;"></i>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#campaignSlider"
                                    data-bs-slide="next">
                                    <i class="fa-solid fa-chevron-right" style="color: #ffffff; font-size: 24px;"></i>
                                </button>
                            <?php endif; ?>
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

                    <?php if(count($games) == 0): ?>
                        <div class="alert alert-danger" role="alert">
                            No games found. Please check back later
                        </div>
                    <?php endif; ?>
                </div>


                <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-4 col-lg-3">
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
                            <div class="single-game-box" data-toggle="modal" data-target="#loginModel">
                                <img src="<?php echo e(asset($game->icon)); ?>" alt="icon" />
                                <div class="single-game-box-text" style="background-color: <?php echo e($game->bg_color); ?>">
                                    <p><?php echo e($game->title); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="view_all_games">
                    <a href="<?php echo e(route('category')); ?>">View All Games</a>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerPart'); ?>
    <?php
        $type = 'home';
    ?>
    <div
        style="position: fixed;left: 0;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%;width: 100%;height: 50px;text-align: left;z-index: 9999;">
        <div class="row">
            <div class="col-md-12">
                <footer id="footer-menu-panel">
                    <nav class="navbar-expand fixed-bottom">
                        <ul class="navbar footer-body" style="padding:12px 20px 22px 20px !important;position: relative;">
                            <li class="nav-item">
                                <a class="nav-link <?php if($type == 'category'): ?> active <?php endif; ?>" aria-current="page"
                                    href="<?php echo e(route('category')); ?>">
                                    <i class="fa-solid fa-layer-group fa-2x"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if($type == 'home'): ?> active <?php endif; ?>"
                                    href="<?php echo e(route('home')); ?>">
                                    <i class="fas fa-home fa-2x"></i>
                                </a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <?php if(Auth::check()): ?>
                                    <a class="nav-link <?php if($type == 'account'): ?> active <?php endif; ?>" aria-current="page"
                                        href="<?php echo e(route('account')); ?>">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                <?php else: ?>
                                    <a class="nav-link <?php if($type == 'category'): ?> loginModalBtn <?php endif; ?> <?php if($type == 'account'): ?> active <?php endif; ?>"
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web', ['type' => 'home'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/home.blade.php ENDPATH**/ ?>