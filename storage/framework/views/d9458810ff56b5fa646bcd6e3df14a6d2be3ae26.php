

<?php $__env->startSection('content'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="bx bxs-trophy text-warning fs-3 me-2"></i>
                        <h5 class="mb-0 fw-bold">Daily Winner List</h5>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bx bx-calendar"></i>
                            </span>
                            <input type="date" class="form-control border-start-0" id="date" value="<?php echo e(date('Y-m-d')); ?>">
                            <button id="filterBtn" class="btn btn-primary px-3">
                                <i class="bx bx-filter-alt"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="dailyScoreLogTableId" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 150px;"># Rank</th>
                                    <th>Msisdn</th>
                                    <th>Score</th>
                                    <th class="pe-4">Date</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ১-৩ র‍্যাঙ্কের জন্য বিশেষ স্টাইল */
    .rank-1 { background-color: #fff9e6 !important; font-weight: bold; }
    .rank-2 { background-color: #f8f9fa !important; }
    .rank-3 { background-color: #fff5f2 !important; }
    .badge-gold { background-color: #FFD700; color: #000; box-shadow: 0 2px 4px rgba(255, 215, 0, 0.3); }
    .badge-silver { background-color: #C0C0C0; color: #000; box-shadow: 0 2px 4px rgba(192, 192, 192, 0.3); }
    .badge-bronze { background-color: #CD7F32; color: #fff; box-shadow: 0 2px 4px rgba(205, 127, 50, 0.3); }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        handleDataTable();
    });

    const handleDataTable = () => {
        let table = $('#dailyScoreLogTableId').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 50,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            dom: '<"d-flex justify-content-between align-items-center mx-3 mt-3"l f>rt<"d-flex justify-content-between align-items-center mx-3 mb-3"i p>',
            ajax: {
                url: '/admin/report/daily-winner-list',
                data: function(d) {
                    d.date = $('#date').val();
                }
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'ps-4 py-3',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return `<span class="badge badge-gold px-3 pt-2 pb-2"><i class="bx bxs-crown me-1"></i> 1st Winner</span>`;
                        } else if (data == 2) {
                            return `<span class="badge badge-silver px-3 pt-2 pb-2"><i class="bx bxs-medal me-1"></i> 2nd Place</span>`;
                        } else if (data == 3) {
                            return `<span class="badge badge-bronze px-3 pt-2 pb-2"><i class="bx bxs-award me-1"></i> 3rd Place</span>`;
                        }
                        return `<span class="text-muted ms-2 fw-semibold">#${data}</span>`;
                    }
                },
                {
                    data: 'msisdn',
                    name: 'msisdn',
                    render: function(data, type, row) {
                        return row.DT_RowIndex <= 3 ? `<span class="fw-bold text-dark">${data.replace(/^88/, '')}</span>` : `<span class="text-secondary">${data.replace(/^88/, '')}</span>`;
                    }
                },
                {
                    data: 'total_score',
                    name: 'total_score',
                    render: function(data, type, row) {
                        let colorClass = 'bg-label-primary';
                        if (row.DT_RowIndex == 1) colorClass = 'bg-success';
                        return `<span class="badge ${colorClass} rounded-pill fw-bold fs-6">${data}</span>`;
                    }
                },
                {
                    data: 'date',
                    name: 'date',
                    className: 'pe-4 text-muted small'
                }
            ],
            // Row styling based on rank
            createdRow: function(row, data, dataIndex) {
                if (data.DT_RowIndex == 1) $(row).addClass('rank-1');
                if (data.DT_RowIndex == 2) $(row).addClass('rank-2');
                if (data.DT_RowIndex == 3) $(row).addClass('rank-3');
            },
            order: [[2, 'desc']],
            language: {
                search: "",
                searchPlaceholder: "Search winner...",
                lengthMenu: "_MENU_"
            }
        });

        $('#filterBtn').on('click', function() {
            table.draw();
        });
    };
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/report/daily-winner-list.blade.php ENDPATH**/ ?>