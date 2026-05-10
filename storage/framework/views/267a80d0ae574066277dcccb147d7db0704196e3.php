<div class="modal fade" id="updateCampainsModal" tabindex="-1" aria-labelledby="updateCampainsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCampainsModalLabel">Update Campaigns</h5>
                <button type="button" class="btn-close closeUpdateCampainsModal"></button>
            </div>
            <form class="from" action="<?php echo e(route('admin.campaign.update')); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo method_field('PUT'); ?>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="campaign_id" id="update_campaignID" />
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="banner" class="form-label optional">Banner</label>
                            <input type="file" class="form-control" id="banner" name="banner">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="update_campaignName" class="form-label required">Name</label>
                            <input type="text" class="form-control" required id="update_campaignName" name="name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="update_startDateTime" class="form-label required">Start Date &
                                Time</label>
                            <input type="datetime-local" class="form-control" id="update_startDateTime"
                                name="start_date_time" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="update_endDateTime" class="form-label required">End Date & Time</label>
                            <input type="datetime-local" class="form-control" id="update_endDateTime"
                                name="end_date_time" required>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="update_campaignAmount" class="form-label required">Amount</label>
                            <input type="number" class="form-control" required id="update_campaignAmount"
                                name="amount">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="updateCampaignGame" class="form-label required">Select a Game</label>
                            <select class="form-select" name="game_id" id="updateCampaignGame" required>
                                <option value="0" selected disabled>Select a Game</option>
                                <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($game->id); ?>"><?php echo e($game->title); ?>

                                        (<?php echo e($game->keyword); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="updateCampaignStatus" class="form-label optional">Status</label>
                            <select class="form-select" name="status" id="updateCampaignStatus" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeUpdateCampainsModal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/campaign/update.blade.php ENDPATH**/ ?>