<!-- Campaign Show Modal -->
<div class="modal fade" id="showCampaignModal" tabindex="-1" aria-labelledby="showCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showCampaignModalLabel">Campaign Details</h5>
                <button type="button" class="btn-close closeShowCampainsModal" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h6>Campaign Information</h6>
                        <hr>
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <p><strong>Name:</strong> <span id="show_campaignName"></span></p>
                                <p><strong>Amount:</strong> <span id="show_campaignAmount"></span></p>
                                <p><strong>Game:</strong> <span id="show_campaignGame"></span></p>
                                <p><strong>Status:</strong> <span id="show_campaignStatus"></span></p>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <p><strong>Start Date & Time:</strong> <span id="show_startDateTime"></span></p>
                                <p><strong>End Date & Time:</strong> <span id="show_endDateTime"></span></p>
                                <p><strong>Description:</strong> <br>
                                    <span id="show_campaignDescription"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h6>Levels</h6>
                        <div id="show_campaignLevels" class="row"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeShowCampainsModal"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/campaign/show.blade.php ENDPATH**/ ?>