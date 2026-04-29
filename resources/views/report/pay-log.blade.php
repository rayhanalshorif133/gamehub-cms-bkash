@extends('layouts.app')

@section('content')
    <div class="px-3 container-p-y">
        <div class="row p-1rem">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center px-2">
                    <h5 class="card-header mb-0">Payment Logs</h5>

                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0">Msisdn</label>
                        <input type="text" class="form-control form-control-sm" id="msisdn"
                            placeholder="Search mobile number">

                        <label class="mb-0">From</label>
                        <input type="date" class="form-control form-control-sm" id="from_date">

                        <label class="mb-0">To</label>
                        <input type="date" class="form-control form-control-sm" id="to_date">

                        <button class="btn btn-sm btn-primary">Filter</button>
                    </div>
                </div>
                <div class="table-responsive overflow-x">
                    <table class="table" id="payLogTableId">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Msisdn</th>
                                <th scope="col">Keyword</th>
                                <th scope="col">Charge Date</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        </tbody>
                    </table>
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


        const handleDataTable2 = () => {
            let table = $('#payLogTableId').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                lengthMenu: [
                    [10, 25, 50, 100, 500],
                    [10, 25, 50, 100, 500]
                ],
                ajax: {
                    url: '/admin/report/pay-logs',
                    data: function(d) {
                        d.msisdn = $('#msisdn').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                columns: [{
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                    {
                        render: function(data, type, row) {
                            return row.msisdn.slice(2);
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                    {
                        render: function(data, type, row) {
                            return row.keyword;
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                    {
                        render: function(data, type, row) {
                            const date = row.charge_date;
                            return date;
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                    {
                        render: function(data, type, row) {
                            const date = row.amount;
                            return date;
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                ]
            });

            $('.btn-primary').on('click', function() {
                table.ajax.reload();
            });
        };

        const handleDataTable = () => {
            // Get today's date in YYYY-MM-DD format
            const today = new Date().toISOString().split('T')[0];

            let table = $('#payLogTableId').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                lengthMenu: [
                    [10, 25, 50, 100, 500],
                    [10, 25, 50, 100, 500]
                ],
                ajax: {
                    url: '/admin/report/pay-logs',
                    data: function(d) {
                        d.msisdn = $('#msisdn').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
                // --- HIGHLIGHT LOGIC START ---
                createdRow: function(row, data, dataIndex) {
                    // Check if charge_date starts with today's date string
                    if (data.charge_date && data.charge_date.includes(today)) {
                        $(row).css('background-color', '#696cff29'); 
                        $(row).css('color', '#696cff'); 
                    }
                },
                // --- HIGHLIGHT LOGIC END ---
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        render: function(data, type, row) {
                            return row.msisdn ? row.msisdn.slice(2) : '';
                        }
                    },
                    {
                        data: 'keyword',
                        name: 'keyword'
                    },
                    {
                        data: 'charge_date',
                        name: 'charge_date'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    }
                ]
            });

            $('.btn-primary').on('click', function() {
                table.ajax.reload();
            });
        };
    </script>
@endpush
