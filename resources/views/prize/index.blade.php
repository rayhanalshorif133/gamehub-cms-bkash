@extends('layouts.app')

@section('content')
    <div class="px-3 container-p-y">
        <div class="row p-1rem">
            <div class="card">
                <div class="d-flex justify-content-between px-2">
                    <h5 class="card-header">Prize List</h5>
                    <button class="btn btn-primary btn-sm d-block d-flex my-2 addCampaignBtn" data-bs-toggle="modal"
                        data-bs-target="#createPrizeModal">Add Prize</button>
                </div>
                <div class="table-responsive overflow-x">
                    <table class="table" id="prizeTableId">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Prize Title</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Total Ranks</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="createPrizeModal" tabindex="-1" aria-labelledby="createPrizeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('admin.prize.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Create New Prize Pool</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-8">
                                    <label class="form-label required">Prize Pool Title</label>
                                    <input type="text" name="title" class="form-control"
                                        placeholder="e.g. 4700 TK Prize Pool" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label required">Total Amount</label>
                                    <input type="number" name="total_amount" class="form-control" placeholder="4700"
                                        required>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="2" placeholder="Optional details..."></textarea>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Rank Distributions</h5>
                                    <button type="button" id="add-rank" class="btn btn-success btn-sm">+ Add Row</button>
                                </div>

                                <div id="rank-rows">
                                    <div class="row g-2 mb-2 rank-item align-items-end">
                                        <div class="col-md-2">
                                            <label class="small">Min Rank</label>
                                            <input type="number" name="rank_min[]" class="form-control" placeholder="1"
                                                required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="small">Max Rank</label>
                                            <input type="number" name="rank_max[]" class="form-control" placeholder="1"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small">Amount</label>
                                            <input type="number" name="amount[]" class="form-control" placeholder="Taka"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small">Prize Level</label>
                                            <input type="text" name="prize_label[]" class="form-control"
                                                placeholder="e.g. Winner/Gold" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger w-100 remove-row">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Prize Pool</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showDistributionsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Prize Distributions for: <span id="modalPrizeTitle"
                                class="fw-bold"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-light">
                                    <th>Rank (Min - Max)</th>
                                    <th>Prize Level</th>
                                    <th>Amount (Per Person)</th>
                                </tr>
                            </thead>
                            <tbody id="distributionDetails">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            handleDataTable();
        });


        const handleDataTable = () => {
            $('#prizeTableId').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.prize.index') }}", // Apnar route er naam
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        render: function(data) {
                            return parseFloat(data).toLocaleString() + ' TK';
                        }
                    },
                    {
                        data: 'total_ranks',
                        name: 'total_ranks',
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            // Date format korar jonno (optional)
                            return new Date(data).toLocaleDateString();
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        };


        document.getElementById('add-rank').addEventListener('click', function() {
            const wrapper = document.getElementById('rank-rows');
            const newRow = `
        <div class="row g-2 mb-2 rank-item align-items-end">
            <div class="col-md-2">
                <input type="number" name="rank_min[]" class="form-control" placeholder="Min" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="rank_max[]" class="form-control" placeholder="Max" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="amount[]" class="form-control" placeholder="Amount" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="prize_label[]" class="form-control" placeholder="Prize Level" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger w-100 remove-row">Delete</button>
            </div>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.rank-item').remove();
            }
        });

        $(document).on('click', '.show-distributions', function() {
            let prizeId = $(this).data('id');

            // UI reset kora
            $('#distributionDetails').html(
                '<tr><td colspan="3" class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...</td></tr>'
                );
            $('#showDistributionsModal').modal('show');

            axios.get(`/admin/prize/${prizeId}/fetch`)
                .then(function(response) {
                    const prize = response.data;
                    $('#modalPrizeTitle').text(prize.title);

                    let rows = '';
                    if (prize.distributions && prize.distributions.length > 0) {
                        prize.distributions.forEach(item => {
                            rows += `
                        <tr>
                            <td class="text-center">Rank ${item.rank_min} - ${item.rank_max}</td>
                            <td><span class="badge bg-label-primary">${item.prize_label}</span></td>
                            <td class="text-end fw-bold">${parseFloat(item.amount).toLocaleString()} TK</td>
                        </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="3" class="text-center">No distributions found.</td></tr>';
                    }

                    $('#distributionDetails').html(rows);
                })
                .catch(function(error) {
                    console.error(error);
                    $('#distributionDetails').html(
                        '<tr><td colspan="3" class="text-center text-danger">Error loading data!</td></tr>');
                });
        });
    </script>
@endpush
