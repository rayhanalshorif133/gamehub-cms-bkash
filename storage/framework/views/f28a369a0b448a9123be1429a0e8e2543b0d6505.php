<?php $__env->startSection('head'); ?>
    <style>
        .paymentHistory {
            max-height: 500px;
            overflow-y: auto;
        }

        .paymentHistory thead {
            position: sticky;
            top: 0;
            background-color: #F02941;
            z-index: 1;
        }

        .paymentHistory::-webkit-scrollbar {
            width: 5px;
        }

        .paymentHistory::-webkit-scrollbar-thumb {
            background-color: #F02941;
            border-radius: 10px;
        }

        .paymentHistory::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .single-game-box-status {
            position: absolute;
            top: 1rem;
            right: 0;
            background: #F02941;
            padding: 5px;
            color: #f1f1f1;
            font-weight: 700;
            font-size: 12px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="section_one" class="overflow-hidden">
        <div class="card mx-auto" style="max-width: 100%;background: #55c1ff2b;">
            <?php if(auth()->guard()->guest()): ?>
                <div>
                    You are a GUEST user
                </div>
            <?php else: ?>
                <div class="card-body info-container d-flex">
                    <img src="<?php echo e(asset($profile_image)); ?>" alt="avatar" class="rounded-circle mb-3"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <div>
                        <h5 class="card-title"><?php echo e(Auth::user()->name); ?></h5>
                        <p class="card-text">
                            <strong>Phone:</strong> <?php echo e(Auth::user()->phone); ?>

                            <input type="hidden" id="auth_phone_number" value="<?php echo e(Auth::user()->phone); ?>" />
                        </p>
                    </div>
                </div>
                <div class="card-body text-left form-container d-none">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="form-group py-2">
                            <div class="image-preview d-flex justify-items-center" id="image-preview">
                                <img src="<?php echo e(asset($profile_image)); ?>" alt="avatar" class="rounded-circle profile-image mb-3"
                                    style="width: 150px; height: 150px; object-fit: cover;margin:auto;">
                            </div>
                        </div>
                        <div class="form-group py-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="auth_name" value="<?php echo e(Auth::user()->name); ?>"
                                class="form-control">
                        </div>
                        <div class="form-group py-2">
                            <label for="image" class="custom-file-label">Profile Picture</label>
                            <div class="custom-file-input-wrapper">
                                <input type="file" name="image" id="image" class="custom-file-input" accept="image/*">
                                <span class="custom-file-button">Choose File</span>
                                <span class="custom-file-name" id="file-name">No file chosen</span>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-outline-success btn-sm checkBtn d-none"><i
                                class="fa-solid fa-check"></i>
                            Update</button>
                        <button type="button" class="btn btn-outline-danger btn-sm cancelBtn d-none">
                            <i class="fa-solid fa-xmark"></i>
                            Cancel</button>
                    </form>


                </div>
                <div class="w-fit text-center d-none">
                    <a class="btn btn-sm btn-danger mb-3" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                        <?php echo e(__('Logout')); ?>

                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                    <br />
                </div>
            <?php endif; ?>
        </div>
        <div class="col-12">
            <h1 class="section-title mx-2">Current Tournament</h1>
            <div class="card mx-2">
                <div class="row" style="padding-bottom: 1rem;">
                    <?php $__currentLoopData = $payLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($item->is_active): ?>
                            <div class="col-6 col-md-4">
                                <div class="single-game-box gameDetailsAccountPage" data-campid="<?php echo e($item->campaign->id); ?>">
                                    <img src="<?php echo e(asset($item->game->icon)); ?>" alt="icon" />
                                    <div class="single-game-box-text"
                                        style="background-color: <?php echo e($item->game->bg_color); ?>">
                                        <p><?php echo e($item->game->title); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
        </div>
        <div class="col-12" style="margin-bottom: 8rem;">
            <h1 class="section-title mx-2">Payment History</h1>
            <div class="card paymentHistory mx-2">
                <table class="table">
                    <thead>
                        <tr style="background-color: #F02941; color: white;">
                            <th scope="col">Tournament Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Entry Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($payLogs) && count($payLogs) > 0): ?>
                            <?php $__currentLoopData = $payLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($log->campaign->name); ?></td>
                                    <td><?php echo e(date('d M, Y', strtotime($log->charge_date))); ?></td>
                                    <td>

                                        <?php if($log->status == 'success'): ?>
                                            <span class="badge text-bg-success"><?php echo e($log->amount); ?> ৳</span>
                                            <span><i class="fa-solid fa-check"></i></span>
                                        <?php else: ?>
                                            <span class="badge text-bg-danger"><?php echo e($log->amount); ?> ৳</span>
                                            <span><i class="fa-solid fa-xmark text-danger"></i></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="font-bold text-center text-danger py-2">No payment history found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <button id="bKash_button" class="d-none"></button>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerPart'); ?>
    <?php
        $type = 'account';
    ?>
    <div
        style="position: fixed;left: 0;bottom: 50px;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%;width: 100%;height: 50px;text-align: left;z-index: 9999;">
        <div class="row">
            <div class="col-md-12">
                <footer id="footer-menu-panel">
                    <nav class="navbar-expand fixed-bottom">
                        <ul class="navbar footer-body"
                            style="padding:12px 20px 22px 20px !important;position: relative;bottom: 44px;">
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
                                    <a class="nav-link <?php if($type == 'account'): ?> active <?php endif; ?>"
                                        aria-current="page" href="<?php echo e(route('account')); ?>">
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

    <button id="bkash_btn" type="button" onclick="window.webViewJSBridge.goBackHome('Tickets')"
        style="position: fixed;left: 0;bottom: 0;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%; 
color: white!important;width: 100%;height: 50px;text-align: left;background-color: #E2136E;border-color: #E2136E;z-index: 9999;">
        Back to bKash App Home<img src="https://capp-cdn.labs.bka.sh/images/arrow.svg"
            style="float: right;margin-top: 1%; 
padding-right: 1%;"></button>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.web', ['type' => 'account'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/web/account.blade.php ENDPATH**/ ?>