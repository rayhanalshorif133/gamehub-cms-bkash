<?php $__env->startSection('content'); ?>
    <div class="px-3 container-p-y">
        <div class="row p-1rem">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent py-3">
                    <h5 class="mb-0">Campaigns List</h5>
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm" id="filterByGame" style="min-width: 200px;">
                            <option value="0" selected disabled>Filter by Game</option>
                            <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($game->id); ?>" data-title="<?php echo e($game->title); ?>">
                                    <?php echo e($game->title); ?> (<?php echo e($game->keyword); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <option value="active-next-camp">Active And Upcoming Campaigns</option>
                        </select>

                        <select class="form-select form-select-sm" id="filterByDate" style="min-width: 200px;">
                            <option value="0" selected disabled>Filter by Date</option>
                            <?php $__currentLoopData = $campaignDates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($date); ?>"><?php echo e($date); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <button class="btn btn-primary btn-sm px-3 addCampaignBtn" data-bs-toggle="modal"
                            data-bs-target="#createCampainsModal" style="min-width: 200px;">
                            <i class="bx bx-plus me-1"></i> Add Campaign
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="campaignsTableId">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Name</th>
                                    <th>Amount (Pay Count)</th>
                                    <th>Start Date & Time</th>
                                    <th>End Date & Time</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="createCampainsModal" tabindex="-1" aria-labelledby="createCampainsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCampainsModalLabel">Add New Campaigns</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="from" action="<?php echo e(route('admin.campaign.create')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="create_select_game" class="form-label required">Select a Game</label>
                                    <select class="form-select" name="game_id" id="create_select_game" required>
                                        <option value="0" selected disabled>Select a Game</option>
                                        <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($game->id); ?>" data-title="<?php echo e($game->title); ?>">
                                                <?php echo e($game->title); ?> (<?php echo e($game->keyword); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="create_campaignName" class="form-label required">Name</label>
                                    <input type="text" class="form-control" required id="create_campaignName"
                                        name="name">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="create_startDateTime" class="form-label required">Start Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="create_startDateTime"
                                        name="start_date_time" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="create_endDateTime" class="form-label required">End Date & Time</label>
                                    <input type="datetime-local" class="form-control" id="create_endDateTime"
                                        name="end_date_time" required>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <div class="mb-3">
                                        <label for="campaign_join_amount" class="form-label required">Campaign Join
                                            Amount</label>
                                        <input type="number" step="0.01" class="form-control" name="amount"
                                            id="campaign_join_amount" placeholder="Enter amount" required>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="create_select_prize" class="form-label required">Select a prize</label>
                                    <select class="form-select" name="prize_id" id="create_select_prize" required>
                                        <option value="0" selected disabled>Select a prize</option>
                                        <?php $__currentLoopData = $prizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prize): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($prize->id); ?>">
                                                <?php echo e($prize->title); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="createCampaignStatus" class="form-label optional">Status</label>
                                    <select class="form-select" id="createCampaignStatus" required>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


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
                                    <input type="text" class="form-control" required id="update_campaignName"
                                        name="name">
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

    </div>

    <form id="deleteCampaignForm" class="d-none" action="#" method="POST">
        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="d-none" id="deleteCampaignBtnSubmit"></button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            url = '/admin/campaign';
            handleDataTable(url);
        });

        $("#filterByGame").on('change', function() {
            const gameId = $(this).val();
            $('#campaignsTableId').DataTable().destroy();
            url = `/admin/campaign?game_id=${gameId}`;
            handleDataTable(url);
        });

        $("#filterByDate").on('change', function() {
            const date = $(this).val();
            $('#campaignsTableId').DataTable().destroy();
            url = `/admin/campaign?date=${date}`;
            handleDataTable(url);
        });


        const handleDataTable = (url) => {
            table = $('#campaignsTableId').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: url,
                order: [
                    [0, 'desc']
                ],
                pageLength: 50, 
                lengthMenu: [
                    [50, 100, 500], 
                    [50, 100, 500] 
                ],
                columns: [{
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
                        },
                        targets: 0,
                        className: 'fit-content' // Add a custom class
                    },
                    {
                        render: function(data, type, row) {
                            return `
                                <div class="d-flex align-items-center">
                                    ${row.name}
                                    <a href="/admin/report/weekly-winner-list?camp_id=${row.id}" class="mx-1 fa-xs">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </div>
                            `;
                        },
                        targets: 0,
                        className: 'fit-content' // Add a custom class
                    },
                    {
                        render: function(data, type, row) {
                            if (row.pay_count == 0) {
                                return `${row.amount}/= (Upcoming)`;
                            }
                            return `${row.amount}/= (${row.pay_count})`;
                        },
                        targets: 0,
                        className: 'fit-content' // Add a custom class
                    },
                    {
                        render: function(data, type, row) {
                            const date = moment(row.start_date).format(
                                "DD-MM-YYYY");
                            let time = moment(row.start_time, "HH:mm:ss.SSSSSS").format("HH:mm:ss");

                            const customeDate = moment(row.start_date).format("DD_MM_YYYY");
                            return `<span class="get_date_time ${customeDate}">${date} ${time}</span>`;
                        },
                        targets: 0,
                        className: 'fit-content' // Add a custom class
                    },
                    {
                        render: function(data, type, row) {
                            const date = moment(row.end_date).format(
                                "DD-MM-YYYY");
                            let time = moment(row.end_time, "HH:mm:ss.SSSSSS").format("HH:mm:ss");
                            return `<span>${date} ${time}</span>`;
                        },
                        targets: 0,
                        className: 'fit-content' // Add a custom class
                    },
                    {
                        render: function(data, type, row) {
                            const status = row.status;
                            if (status == 1) {
                                return `<span class="badge bg-label-success cursor-pointer " onClick="handleStatus(${row.id})">Active</span>`; // Customize the style as needed
                            } else {
                                return `<span class="badge bg-label-danger cursor-pointer" onClick="handleStatus(${row.id})">Inactive</span>`; // Or any other status representation
                            }
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                    {
                        render: function(data, type, row) {
                            const btns =
                                `
                                <button type="button" class="btn btn-sm btn-info" title="Clone" onClick="cloneCampaign(${row.id})">
                                    <i class='bx bx-copy'></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" onClick="updateCampaign(${row.id})"><i class='bx bx-edit'></i></button>
                                <button type="button" class="btn btn-sm btn-danger" onClick="deleteCampaign(${row.id})"><i class='bx bx-trash'></i></button>`;
                            return btns;
                        },
                        targets: 0,
                        className: 'fit-content'
                    }
                ],
                rowCallback: function(row, data) {
                    if (data.type == 'active') {
                        $(row).css({
                            'background-color': '#e9f7ef',
                            'color': '#155724',
                            'font-weight': 'bold',
                            'border-left': '10px solid #28a745',
                            'transition': 'background-color 0.3s ease'
                        });
                    }
                }
            });





        };


        const deleteCampaign = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this campaign..!!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#deleteCampaignForm").attr('action', `/admin/campaign/${id}/delete`);
                    setTimeout(() => {
                        $("#deleteCampaignBtnSubmit").click();
                    }, 100);
                }
            });
        };

        const updateCampains = new bootstrap.Modal(document.getElementById('updateCampainsModal'));
        const updateCampaign = (id) => {

            const form = document.getElementById('updateCampaignForm');
            axios.get(`/campaign/${id}/fetch`)
                .then((response) => {
                    const data = response.data.data;
                    $('#update_campaignID').val(data.id);
                    $('#update_campaignName').val(data.name);
                    $('#update_campaignAmount').val(data.amount);
                    $('#update_campaignDescription').val(data.description);

                    // Auto Selected Start Date & Time
                    data.start_date = data.start_date.split('T')[0];
                    const start_date_time = data.start_date + "T" + data.start_time.substring(0, 5);
                    $("#update_startDateTime").val(start_date_time);

                    // Auto Selected End Date & Time
                    data.end_date = data.end_date.split('T')[0];
                    const end_date_time = data.end_date + "T" + data.end_time.substring(0, 5);
                    $("#update_endDateTime").val(end_date_time);
                    $("#updateCampaignGame").val(data.game_id);
                    $("#updateCampaignStatus").val(data.status);


                });

            updateCampains.show();
        };

        const cloneCampaign = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to create a duplicate of this campaign?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6', // Blue is better for cloning
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, clone it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = `/admin/campaign/${id}/clone`;
                } else {
                    Swal.fire({
                        title: 'Cancelled',
                        text: 'Your campaign was not cloned.',
                        icon: 'error',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        };


        $(".closeUpdateCampainsModal").click(() => {
            updateCampains.hide();
        });


        $("#create_select_game").on('change', function() {
            const selectedGameTitle = $(this).find(':selected').data('title');
            $("#create_campaignName").val(selectedGameTitle);
        });



        $(".addCampaignBtn").click(function(event) {

            const start_date = moment();
            const start_time = "10:01:00";

            const end_date = moment().add(7, 'days');
            const end_time = "22:00:00";

            const start_date_time = start_date.format('YYYY-MM-DD') + " " + start_time;
            const end_date_time = end_date.format('YYYY-MM-DD') + " " + end_time;

            // ৪. ইনপুট ফিল্ডে ভ্যালু সেট করা
            $("#create_startDateTime").val(start_date_time);
            $("#create_endDateTime").val(end_date_time);
        });


        const handleSubmit = () => {
            const updatedData = {
                id: $('#update_campaignID').val(),
                name: $('#update_campaignName').val(),
                amount: $('#update_campaignAmount').val(),
                description: $('#update_campaignDescription').val(),
                start_date_time: $('#update_startDateTime').val(),
                end_date_time: $('#update_endDateTime').val(),
            };

            // Send a PUT request to update the campaign
            axios.put(`/admin/campaigns?type=update`, updatedData)
                .then((response) => {
                    if ($.fn.DataTable.isDataTable('#campaignsTableId')) {
                        $('#campaignsTableId').DataTable().destroy(); // Destroy the existing DataTable instance
                        handleDataTable();
                    }

                })
                .catch(error => console.error('Error updating campaign:', error));
        };
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/campaign/index.blade.php ENDPATH**/ ?>