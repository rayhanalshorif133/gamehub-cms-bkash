

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Day-wise Score Log</h4>

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-uppercase">Select Campaign</label>
                        <select id="campaign_select" class="form-select">
                            <option value="">-- Choose Campaign --</option>
                            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($campaign->id); ?>" data-start="<?php echo e($campaign->start_date); ?>"
                                    data-end="<?php echo e($campaign->end_date); ?>" data-keyword="<?php echo e($campaign->game_keyword); ?>">
                                    <?php echo e($loop->iteration); ?>. <?php echo e($campaign->name); ?>

                                    (<?php echo e(date('d M, Y', strtotime($campaign->start_date))); ?> -
                                    <?php echo e(date('d M, Y', strtotime($campaign->end_date))); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-uppercase">MSISDN (Optional)</label>
                        <input type="text" id="msisdn_input" class="form-control" placeholder="17xxxxxxxx">
                    </div>
                    <div class="col-md-3">
                        <button id="fetch_report" class="btn btn-primary w-100">
                            <i class="bx bx-search-alt me-1"></i> Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>MSISDN</th>
                            <th class="text-end pe-4">Total Score</th>
                        </tr>
                    </thead>
                    <tbody id="report_body">
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Please select a campaign and click
                                Generate</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {

            const urlParams = new URLSearchParams(window.location.search);
            const campId = urlParams.get('camp_id');
            const msisdn = urlParams.get('msisdn');

            $('#fetch_report').on('click', function() {
                const campaign = $('#campaign_select').val();
                const msisdn = $('#msisdn_input').val();
                const selectedOption = $('#campaign_select option:selected');

                if (!campaign) {
                    alert('Please select a campaign first');
                    return;
                }

                const startDate = selectedOption.data('start');
                const endDate = selectedOption.data('end');
                const keyword = selectedOption.data('keyword');

                // Loading state
                $('#report_body').html(
                    '<tr><td colspan="4" class="text-center py-4">Loading data...</td></tr>');

                $.ajax({
                    url: '/admin/report/day-based-score-log',
                    method: 'GET',
                    data: {
                        campaign_keyword: keyword,
                        msisdn: msisdn,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        let html = '';

                        if (response.data && response.data.length > 0) {
                            var totalScore = 0;
                            response.data.forEach(item => {
                                totalScore += parseInt(item.total_score);
                                html += `
                            <tr>
                                <td class="ps-4 fw-medium">${item.date}</td>
                                <td>${item.msisdn.replace(/^88/, '') || 'N/A'}</td>
                                <td class="text-end pe-4 fw-bold text-primary">${item.total_score}</td>
                            </tr>`;
                            });

                            html += `
                            <tr class="table-secondary">
                                <td colspan="2" class="ps-4 fw-bold text-uppercase">Total Score</td>
                                <td class="text-end pe-4 fw-bold text-primary">${totalScore}</td>
                            </tr>`;
                        } else {
                            html =
                                '<tr><td colspan="4" class="text-center py-4">No data found for this period.</td></tr>';
                        }

                        $('#report_body').html(html);
                    },
                    error: function() {
                        $('#report_body').html(
                            '<tr><td colspan="4" class="text-center text-danger py-4">Error fetching data.</td></tr>'
                        );
                    }
                });
            });


            if (campId) {
                $('#campaign_select').val(campId).trigger('change');
            }

            if (msisdn) {
                $('#msisdn_input').val(msisdn);
            }

            if (campId || msisdn) {
                $('#fetch_report').trigger('click');
            }


        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/report/day-based-score-log.blade.php ENDPATH**/ ?>