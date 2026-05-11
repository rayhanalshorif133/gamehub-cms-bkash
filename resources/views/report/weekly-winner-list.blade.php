@extends('layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header border-bottom py-3">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bx bxs-trophy text-warning fs-3 me-2"></i>
                            <h5 class="mb-0 fw-bold">Weekly Winner List</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Select Game</label>
                                <select id="game_filter" class="form-select form-select-sm">
                                    <option value="" selected disabled>Please Select a Game</option>
                                    @foreach ($games as $game)
                                        <option value="{{ $game->keyword }}">{{ $game->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-uppercase">Select Campaign</label>
                                <select id="campaign_by_keyword" class="form-select form-select-sm">
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->game_keyword }}"
                                            @if ($activeCampaign && $activeCampaign->id == $campaign->id) selected @endif
                                            data-camp_id="{{ $campaign->id }}"
                                            data-start="{{ date('Y-m-d', strtotime($campaign->start_date)) }}"
                                            data-end="{{ date('Y-m-d', strtotime($campaign->end_date)) }}">
                                            {{ $loop->iteration }}. {{ $campaign->name }}
                                            ({{ date('Y-m-d', strtotime($campaign->start_date)) }} -
                                            {{ date('Y-m-d', strtotime($campaign->end_date)) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-bold text-uppercase">Date From</label>
                                <input type="date" class="form-control form-control-sm" id="date_from"
                                    value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small fw-bold text-uppercase">Date To</label>
                                <input type="date" class="form-control form-control-sm" id="date_to"
                                    value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button id="filterBtn" class="btn btn-sm btn-primary w-100">
                                    <i class="bx bx-search-alt"></i> Search
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-header bg-white border-bottom-0 py-1 d-none" id="selectedLevelTab">

                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="weeklyWinnerTableId" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3"># Rank</th>
                                        <th>Msisdn</th>
                                        <th>Campaign</th>
                                        <th>Total Score</th>
                                        <th>Total Played</th>
                                        <th class="pe-4">Duration</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rank-1 {
            background-color: #fffdf2 !important;
        }

        .rank-2 {
            background-color: #fcfcfc !important;
        }

        .rank-3 {
            background-color: #fff9f7 !important;
        }

        .badge-gold {
            background: linear-gradient(45deg, #FFD700, #FFA500);
            color: #000;
            font-weight: bold;
            border: none;
        }

        .badge-silver {
            background: linear-gradient(45deg, #C0C0C0, #808080);
            color: #fff;
            font-weight: bold;
            border: none;
        }

        .badge-bronze {
            background: linear-gradient(45deg, #CD7F32, #8B4513);
            color: #fff;
            font-weight: bold;
            border: none;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var table = null;
        var campId = $('#campaign_by_keyword option:selected').data('camp_id');
        var startDate = null;
        var endDate = null;

        $(document).ready(function() {
            handleWeeklyDataTable();

            const urlParams = new URLSearchParams(window.location.search);
            const campIdFromParams = urlParams.get('camp_id');
            if (campIdFromParams) {
                $('#campaign_by_keyword option').each(function() {
                    if ($(this).data('camp_id') == campIdFromParams) {
                        $(this).prop('selected', true);
                        return false;
                    }
                });
            }
            const allCampaignOptions = $('#campaign_by_keyword option').clone();

            $('#game_filter').on('change', function() {
                const selectedGame = $(this).val();
                const campaignSelect = $('#campaign_by_keyword');

                campaignSelect.empty();


                // Default option
                campaignSelect.append('<option value="">Select Campaign</option>');

                if (selectedGame) {
                    const filteredOptions = allCampaignOptions.filter(function() {
                        return $(this).val() === selectedGame;
                    });

                    campaignSelect.append(filteredOptions);
                    handleNavSelection(campaignSelect);
                } else {
                    campaignSelect.append(allCampaignOptions);
                }

            });

            $('#campaign_by_keyword').select2({
                theme: "bootstrap-5", // Use the Bootstrap 5 theme
                width: '100%',
                placeholder: "Search for a campaign...",
                allowClear: true
            });


            $('#campaign_by_keyword').on('change', function() {
                startDate = $(this).find(':selected').data('start');
                endDate = $(this).find(':selected').data('end');

                if (startDate) $('#date_from').val(startDate);
                if (endDate) $('#date_to').val(endDate);

                campId = $(this).find(':selected').data('camp_id');

                table.draw();
            });

            $('#campaign_by_keyword').trigger('change');

        });

        const handleNavSelection = (campaignSelect) => {
            const today = new Date().toISOString().split('T')[0];
            $("#selectedLevelTab").removeClass('d-none');
            $("#selectedLevelTab").html('');
            table.clear().draw();

            let currentOption = null;

            campaignSelect.find('option').each(function() {
                const start = $(this).data('start');
                const end = $(this).data('end');

                if (start && end && today >= start && today <= end) {
                    $(this).prop('selected', true);
                    currentOption = $(this);
                    campaignSelect.trigger('change');
                    return false;
                }
            });

            const activeOpt = currentOption || campaignSelect.find('option:selected');
            const prev1 = activeOpt.prev('option');
            const prev2 = prev1.prev('option');

            // 3. Extract names/labels for the buttons (Optional, but makes the UI better)
            const labelCurrent = activeOpt.text().split('.')[1]?.trim() || "Current";
            const labelPrev1 = prev1.length ? (prev1.text().split('.')[1]?.trim() || "Prev 1") : "N/A";
            const labelPrev2 = prev2.length ? (prev2.text().split('.')[1]?.trim() || "Prev 2") : "N/A";

            const HTML = `
        <ul class="nav nav-pills nav-fill bg-light p-1 rounded" id="levelTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded ${prev2.length ? '' : 'disabled'}" id="level3-tab"
                    data-camp-id="${prev2.data('camp_id')}" data-bs-toggle="pill" type="button" role="tab">
                    ${labelPrev2}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded ${prev1.length ? '' : 'disabled'}" id="level2-tab"
                    data-camp-id="${prev1.data('camp_id')}" data-bs-toggle="pill" type="button" role="tab">
                    ${labelPrev1}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded" id="level1-tab"
                    data-camp-id="${activeOpt.data('camp_id')}" data-bs-toggle="pill" type="button" role="tab">
                    ${labelCurrent}
                </button>
            </li>


        </ul>
    `;

            if(labelPrev1 == 'N/A'){
                HTML = '';
            }

            $("#selectedLevelTab").html(HTML);

            $('#levelTab button').on('click', function() {
                const campId = $(this).data('camp-id');
                if (campId) {
                    campaignSelect.find(`option[data-camp_id="${campId}"]`).prop('selected', true);
                    campaignSelect.trigger('change');
                }
            });
        };

        const handleWeeklyDataTable = () => {

            // get selected campaign id

            table = $('#weeklyWinnerTableId').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                dom: '<"d-flex justify-content-between align-items-center mx-3 mt-3"l f>rt<"d-flex justify-content-between align-items-center mx-3 mb-3"i p>',

                ajax: {
                    url: '/admin/report/weekly-winner-list',
                    data: function(d) {
                        d.campaign_by_keyword = $('#campaign_by_keyword').val();
                        d.camp_id = campId;
                        d.date_from = $('#date_from').val();
                        d.date_to = $('#date_to').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'ps-4 py-3',
                        render: function(data) {
                            if (data == 1)
                                return `<span class="badge badge-gold shadow-sm px-3"><i class="bx bxs-crown me-1"></i> 1st</span>`;
                            if (data == 2)
                                return `<span class="badge badge-silver shadow-sm px-3"><i class="bx bxs-medal me-1"></i> 2nd</span>`;
                            if (data == 3)
                                return `<span class="badge badge-bronze shadow-sm px-3"><i class="bx bxs-award me-1"></i> 3rd</span>`;
                            return `<span class="text-muted fw-bold ms-2">#${data}</span>`;
                        }
                    },
                    {
                        data: 'msisdn',
                        name: 'msisdn',
                        render: function(data, type, row) {
                            const redirectUrl =
                                `/admin/report/score-log?camp_id=${campId}&msisdn=${data}&start_date=${$('#date_from').val()}&end_date=${$('#date_to').val()}`;
                            return row.DT_RowIndex <= 3 ?
                                `<a href="${redirectUrl}"><strong>${data.replace(/^88/, '')}</strong></a>` :
                                `<a href="${redirectUrl}">${data.replace(/^88/, '')}</a>`;
                        }
                    },
                    {
                        data: 'campaign_name',
                        name: 'campaign_name'
                    },
                    {
                        data: 'total_score',
                        name: 'total_score',
                        className: 'fw-bold text-primary',
                        render: function(data, type, row) {
                            let url =
                                `/admin/report/day-based-score-log?camp_id=${campId}&msisdn=${row.msisdn}`;

                            return `
                                <strong>${data}</strong>
                                <a href="${url}" class="ms-2" title="Show Details">
                                    <i class='bx bx-show text-info' style="font-size: 1.2rem; cursor: pointer;"></i>
                                    </a>`;
                        }
                    },
                    {
                        data: 'total_played',
                        name: 'total_played',
                        className: 'fw-bold text-primary',
                        render: function(data, type, row) {

                            return row.total_played;
                        }
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                        render: function(data, type, row) {
                            return `<small class="text-muted">${$('#date_from').val()} to ${$('#date_to').val()}</small>`;
                        }
                    }
                ],
                createdRow: function(row, data) {
                    if (data.DT_RowIndex == 1) $(row).addClass('rank-1');
                    if (data.DT_RowIndex == 2) $(row).addClass('rank-2');
                    if (data.DT_RowIndex == 3) $(row).addClass('rank-3');
                },
                order: [
                    [3, 'desc']
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search msisdn..."
                }
            });

            $('#filterBtn').on('click', function() {
                table.draw();
            });
        };
    </script>
@endpush
