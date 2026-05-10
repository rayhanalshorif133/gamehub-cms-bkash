

<?php $__env->startSection('content'); ?>
<div class="container-p-y px-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <!-- Header & Filters -->
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <h5 class="mb-0">Game Play Logs</h5>

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <label for="msisdn" class="mb-0 small fw-bold">Msisdn</label>
                            <input type="text" class="form-control form-control-sm" id="msisdn" placeholder="Search number">
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <label for="from_date" class="mb-0 small fw-bold">From</label>
                            <input type="date" class="form-control form-control-sm" id="from_date">
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <label for="to_date" class="mb-0 small fw-bold">To</label>
                            <input type="date" class="form-control form-control-sm" id="to_date">
                        </div>

                        <button class="btn btn-sm btn-primary px-4" id="filterBtn">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive text-nowrap p-4">
                    <table class="table table-hover" id="playLogTableId">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Msisdn</th>
                                <th>Keyword</th>
                                <th>Timing (Start/End/Duration)</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        const today = new Date().toISOString().split('T')[0];

        let table = $('#playLogTableId').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            ajax: {
                url: '/admin/report/play-logs',
                data: function(d) {
                    d.msisdn = $('#msisdn').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { 
                    data: 'msisdn', 
                    render: data => data ? data.slice(2) : '' 
                },
                { data: 'keyword', name: 'keyword' },
                { 
                    name: 'timing',
                    render: function(data, type, row) {
                        return `
                            <div class="small">
                                <span class="text-success">S:</span> ${row.start_time || 'N/A'}<br>
                                <span class="text-danger">E:</span> ${row.end_time || 'N/A'}<br>
                                <span class="badge bg-label-info">Dur: ${row.durations || '0'}</span>
                            </div>
                        `;
                    }
                },
                { data: 'score', name: 'score' },
                { 
                    data: 'status', 
                    render: data => `<span class="badge bg-label-${data === 'success' ? 'success' : 'secondary'}">${data}</span>`
                },
                { data: 'date', name: 'date' }
            ]
        });

        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/report/play-log.blade.php ENDPATH**/ ?>