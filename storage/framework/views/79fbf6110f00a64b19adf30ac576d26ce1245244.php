

<?php $__env->startPush('styles'); ?>
    <style>
        /* Custom refinements for a modern feel */
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #5c607b;
        }

        .filter-section {
            background-color: #ffffff;
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .form-select-sm,
        .form-control-sm {
            border-radius: 6px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d9dee3;
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
        }

        .badge-score {
            background: rgba(105, 108, 255, 0.1);
            color: #696cff;
            padding: 0.5em 0.8em;
            border-radius: 6px;
            font-weight: 700;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">
                    Score Log
                </h4>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">Game Title</label>
                        <select id="game_keyword" class="form-select border-light-subtle shadow-none">
                            <option value="">All Games</option>
                            <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($game_id) && $game_id == $game->id): ?>
                                    <option value="<?php echo e($game->keyword); ?>" selected><?php echo e($game->title); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo e($game->keyword); ?>"><?php echo e($game->title); ?></option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Phone Number (MSISDN)</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-phone"></i></span>
                            <input type="text" class="form-control border-light-subtle shadow-none" id="msisdn"
                                placeholder="17xxxxxxxx">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">Start Date</label>
                        <input type="date" class="form-control border-light-subtle shadow-none" id="start_date">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">End Date</label>
                        <input type="date" class="form-control border-light-subtle shadow-none" id="end_date">
                    </div>

                    <div class="col-md-3">
                        <button id="filterBtn"
                            class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                            <i class="bx bx-filter-alt me-2"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom bg-transparent py-3">
                <h5 class="card-title mb-0 d-flex align-items-center">
                    <i class="bx bx-data text-primary me-2"></i> Log Details
                </h5>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bx bxs-file-pdf me-2"></i>PDF</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bx bx-spreadsheet me-2"></i>Excel</a></li>
                    </ul>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover align-middle mb-0" id="dailyScoreLogTableId">
                        <thead>
                            <tr>
                                <th class="ps-4">SL</th>
                                <th>Msisdn</th>
                                <th>Game Keyword</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th class="text-end pe-4">Score</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);

            // 2. Access specific keys
            const msisdn = urlParams.get('msisdn');
            const startDate = urlParams.get('start_date');
            const endDate = urlParams.get('end_date');

            if(msisdn) {
                $('#msisdn').val(msisdn);
            }

            if(startDate) {
                $('#start_date').val(startDate);
            }

            if(endDate) {
                $('#end_date').val(endDate);
            }

            if(msisdn || startDate || endDate) {
                $('#filterBtn').trigger('click');
            }

            handleDataTable();
        });

        const handleDataTable = () => {
            let table = $('#dailyScoreLogTableId').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, 500, 1000],
                    [10, 25, 50, 100, 500, 1000]
                ],
                dom: '<"row mx-2"<"col-md-6"l><"col-md-6"f>>rt<"row mx-2"<"col-md-6"i><"col-md-6"p>>',
                ajax: {
                    url: '/admin/report/score-log',
                    data: function(d) {
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                        d.msisdn = $('#msisdn').val();
                        d.game_keyword = $('#game_keyword').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'ps-4'
                    },
                    {
                        data: 'msisdn',
                        render: (data) =>
                            `<div class="d-flex align-items-center"></div><span class="fw-medium text-heading">${data.replace(/^88/, '')}</span></div>`
                    },
                    {
                        data: 'game_keyword',
                        render: (data) =>
                            `<span class="badge bg-label-info text-capitalize">${data.replace('_', ' ')}</span>`
                    },
                    {
                        data: 'date',
                        render: (data) =>
                            `<span><i class="bx bx-calendar me-1 text-muted"></i> ${data}</span>`
                    },
                    {
                        data: 'time',
                        render: (data) =>
                            `<span class="text-muted small"><i class="bx bx-time-five me-1"></i> ${data}</span>`
                    },
                    {
                        data: 'score',
                        className: 'text-end pe-4',
                        render: (data) => `<span class="badge-score">${data.toLocaleString()}</span>`
                    }
                ],
                order: [
                    [3, 'desc']
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search logs...",
                    paginate: {
                        next: '<i class="bx bx-chevron-right"></i>',
                        previous: '<i class="bx bx-chevron-left"></i>'
                    }
                }
            });

            $('#filterBtn').on('click', function() {
                table.draw();
            });
        };
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/report/score-log.blade.php ENDPATH**/ ?>