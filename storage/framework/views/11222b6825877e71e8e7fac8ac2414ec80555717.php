<?php $__env->startSection('content'); ?>
    <section id="section_one">
        <div class="card mx-auto" style="max-width: 100%;background: #55c1ff2b;">
            <?php if(auth()->guard()->guest()): ?>
                <div>
                    You are a GUEST user
                </div>
            <?php else: ?>
                <input type="hidden" id="auth_phone_number" value="<?php echo e(Auth::user()->phone); ?>" />
                <div class="card-body d-flex coin-container">
                    <a href="<?php echo e(route('home')); ?>" style="position: absolute;left: 0px;"><i class="fa-solid fa-arrow-left-long"></i></a>
                    <div class="coin">
                        <img src="<?php echo e(asset('/assets/images/coin.png')); ?>" alt="coin symbol">
                        <p>
                            <?php echo e(Auth::user()->point); ?>

                        </p>
                        <div class="buttons d-none">
                            <button class="btn custom_button mx-1">Exchange</button>
                            <button class="btn custom_button mx-1" data-bs-toggle="offcanvas" data-bs-target="#recharge-offcanvas">
                                Recharge
                            </button>
                            
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-12" style="margin-bottom: 4rem;">
            <h1 class="section-title">Point History</h1>
            <div class="card paymentHistory">
                <table class="table">
                    <thead>
                        <tr style="background-color: #F02941; color: white;">
                            <th scope="col">Date</th>
                            <th scope="col">Details</th>
                            <th scope="col">Status</th>
                            <th scope="col">Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(\Carbon\Carbon::parse($item->date)->format('d M, Y')); ?></td>
                                <td><?php echo e($item->message); ?></td>
                                <td>
                                    <?php if($item->status == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif($item->status == 'success'): ?>
                                        <span class="badge bg-success text-white">success</span>
                                    <?php elseif($item->status == 'rejected'): ?>
                                        <span class="badge bg-danger text-white">Rejected</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?php echo e(ucfirst($item->status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($item->point); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(count($points) == 0): ?>
                            <tr>
                                <td colspan="4" class="text-center">History is empty</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script>
        $(() => {
            $("#coin-decrement").click(() => {
                var coin = parseInt($("#set-coin").val());
                coin = coin - 100;
                if (coin < 0) coin = 0;
                var taka = coin / 100;
                if (coin == 0) taka = 0;
                $("#set-coin").val(coin);
                $("#bKash_button").text(`Pay Now (${taka} tk)`);
                $("#bKash_button").attr('data-amount', taka);
            });
            $("#coin-increment").click(function() {
                var coin = parseInt($("#set-coin").val());
                coin = coin + 100;
                $("#set-coin").val(coin);
                var taka = coin / 100;
                $("#bKash_button").text(`Pay Now (${taka} tk)`);
                $("#bKash_button").attr('data-amount', taka);
            });


        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.web', ['type' => 'Points'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/web/points.blade.php ENDPATH**/ ?>