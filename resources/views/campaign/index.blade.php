@extends('layouts.app')

@section('content')
    <div class="px-3 container-p-y">
        <div class="row p-1rem">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent py-3">
                    <h5 class="mb-0">Campaigns List</h5>
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm" id="filterByGame" style="min-width: 200px;">
                            <option value="0" selected disabled>Filter by Game</option>
                            @foreach ($games as $game)
                                <option value="{{ $game->id }}" data-title="{{ $game->title }}">
                                    {{ $game->title }} ({{ $game->keyword }})
                                </option>
                            @endforeach
                            <option value="active-next-camp">Active And Upcoming Campaigns</option>
                        </select>

                        <select class="form-select form-select-sm" id="filterByDate" style="min-width: 200px;">
                            <option value="0" selected disabled>Filter by Date</option>
                            @foreach ($campaignDates as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
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




        @include('campaign.create')
        @include('campaign.update')
        @include('campaign.show')

    </div>

    <form id="deleteCampaignForm" class="d-none" action="#" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="d-none" id="deleteCampaignBtnSubmit"></button>
    </form>
@endsection

@push('scripts')
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
                                <button type="button" class="btn btn-sm btn-success" title="Show" onClick="showCampaign(${row.id})">
                                    <i class='bx bx-show'></i>
                                </button>
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

        const showCampaignModal = new bootstrap.Modal(document.getElementById('showCampaignModal'));
        const showCampaign = (id) => {
            axios.get(`/campaign/${id}/fetch`)
                .then((response) => {
                    const data = response.data.data;
                    console.log(data);
                    $('#show_campaignName').text(data.name);
                    $('#show_campaignAmount').text(data.amount);
                    $('#show_campaignDescription').text(data.description);

                    const startDateTime = moment(data.start_date).format('DD-MM-YYYY');
                    $('#show_startDateTime').text(startDateTime);

                    const endDateTime = moment(data.end_date).format('DD-MM-YYYY');
                    $('#show_endDateTime').text(endDateTime);

                    $('#show_campaignStatus').text(data.status == 1 ? 'Active' : 'Inactive');
                    $('#show_campaignGame').text(data.game ? data.game.title : 'N/A');

                    // Populate levels
                    let levelsHtml = '';
                    if (data.levels && data.levels.length > 0) {
                        data.levels.forEach(level => {
                            levelsHtml += `
                                <div class="border p-2 mb-2 col-md-3">
                                    <strong>Level ${level.level_number}</strong><br>
                                    Game: ${level.game_title ? level.game_title : 'N/A'}<br>
                                    Prize: ${level.prize ? level.prize.title : 'N/A'}<br>
                                    Start: ${moment(level.start_date).format('DD-MM-YYYY')}<br>
                                    End: ${moment(level.end_date).format('DD-MM-YYYY')}
                                </div>
                            `;
                        });
                    } else {
                        levelsHtml = '<p>No levels found.</p>';
                    }
                    $('#show_campaignLevels').html(levelsHtml);
                })
                .catch(error => console.error('Error fetching campaign:', error));

            showCampaignModal.show();
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

        $(".closeShowCampainsModal").click(() => {
            showCampaignModal.hide();
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
@endpush
