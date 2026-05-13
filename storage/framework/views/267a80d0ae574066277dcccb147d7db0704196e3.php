<div class="modal fade" id="updateCampainsModal" tabindex="-1" aria-labelledby="updateCampainsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- modal-lg দেওয়া হয়েছে যেহেতু ডাটা বেশি -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Multi-Level Campaign</h5>
                <button type="button" class="btn-close closeUpdateCampainsModal" aria-label="Close"></button>
            </div>
            <form id="updateCampaignForm" action="<?php echo e(route('admin.campaign.update')); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo method_field('PUT'); ?>
                <?php echo csrf_field(); ?>
                <input type="hidden" name="campaign_id" id="update_campaignID" />

                <div class="modal-body">
                    <!-- Main Campaign Info -->
                    <div class="row border-bottom mb-4 pb-3">
                        <div class="mb-3 col-md-6">
                            <label class="form-label required">Campaign Name</label>
                            <input type="text" class="form-control" required id="update_campaignName" name="name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label required">Join Amount</label>
                            <input type="number" step="0.01" class="form-control" required
                                id="update_campaignAmount" name="amount">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Banner (Optional)</label>
                            <input type="file" class="form-control" name="banner" accept="image/*">
                            <div id="update_banner_preview" class="mt-2"></div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="updateCampaignStatus">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Dynamic Levels Section -->
                    <div id="update-levels-container">
                        <h6 class="fw-bold mb-3">Campaign Levels</h6>
                        <!-- Fetch করা লেভেলগুলো এখানে আসবে -->
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm" id="update-add-level-btn">
                        <i class="bi bi-plus-circle"></i> Add New Level
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeUpdateCampainsModal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

</script>
<?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/campaign/update.blade.php ENDPATH**/ ?>