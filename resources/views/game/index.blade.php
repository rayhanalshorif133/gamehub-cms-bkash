@extends('layouts.app')

@section('content')
    <div class="px-3 container-p-y">
        <div class="row p-1rem">
            <div class="card">
                <div class="d-flex justify-content-between px-2">
                    <h5 class="card-header">Game List</h5>
                    <button class="btn btn-primary btn-sm d-block d-flex my-2" data-bs-toggle="modal"
                        data-bs-target="#createGameModal">Add Game</button>
                </div>
                <div class="table-responsive overflow-x">
                    <table class="table" id="gameTableId">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Banner</th>
                                <th scope="col">Title</th>
                                <th scope="col">Keyword</th>
                                <th scope="col">Url</th>
                                <th scope="col">Status</th>
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
        <div class="modal fade" id="createGameModal" tabindex="-1" aria-labelledby="createGameModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 1px solid #e8e8e8;">
                        <h5 class="modal-title" id="createGameModalLabel">Add New Game</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form enctype="multipart/form-data" action="{{ route('admin.game.create') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="createGametitle" class="form-label required">Title</label>
                                    <input type="text" class="form-control" id="createGametitle"
                                        placeholder="Enter a title" name="title" required>
                                </div>
                                {{-- banner --}}
                                <div class="mb-3 col-md-6">
                                    <label for="createGameBanner" class="form-label required">Banner</label>
                                    <input type="file" class="form-control" id="createGameBanner"
                                        placeholder="Uplaod a banner" name="banner" required>
                                </div>
                                {{-- keyword --}}
                                <div class="mb-3 col-md-6">
                                    <label for="createGameKeyword" class="form-label required">Keyword</label>
                                    <input type="text" class="form-control gameKeyword" data-type="create" placeholder="Enter a keyword"
                                        id="createGameKeyword" name="keyword" required>
                                    <span class="SET_GAME_keyword_Msg"></span>
                                </div>
                                {{-- url --}}
                                <div class="mb-3 col-md-6">
                                    <label for="createGameUrl" class="form-label required">Url</label>
                                    <input type="text" class="form-control" placeholder="Enter a url" id="createGameUrl"
                                        name="url" required>
                                </div>
                                {{-- status --}}
                                <div class="mb-3 col-md-6">
                                    <label for="createGameStatus" class="form-label optional">Status</label>
                                    <select class="form-select" id="createGameStatus" name="status" required>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                {{-- description --}}
                                <div class="mb-3 col-md-6">
                                    <label for="createGameDescription" class="form-label optional">Description</label>
                                    <textarea class="form-control" id="createGameDescription" placeholder="Enter a description" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary gameSubmitBtn">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="updateGameModal" tabindex="-1" aria-labelledby="updateGameModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 1px solid #e8e8e8;">
                        <h5 class="modal-title" id="createGameModalLabel">Update Game</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form enctype="multipart/form-data" action="{{ route('admin.game.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id" id="updateGameID">
                                <div class="mb-3 col-md-6">
                                    <label for="updateGametitle" class="form-label required">Title</label>
                                    <input type="text" class="form-control" id="updateGametitle"
                                        placeholder="Enter a title" name="title" required>
                                </div>
                                {{-- banner --}}
                                <div class="mb-3 col-md-6">
                                    <label for="updateGameBanner" class="form-label optional">Banner</label>
                                    <input type="file" class="form-control" id="updateGameBanner"
                                        placeholder="Uplaod a banner" name="banner">
                                </div>
                                {{-- keyword --}}
                                <div class="mb-3 col-md-6">
                                    <label for="updateGameKeyword" class="form-label required">Keyword</label>
                                    <input type="text" class="form-control gameKeyword" data-type="update" placeholder="Enter a keyword"
                                        id="updateGameKeyword" name="keyword" required>
                                    <span class="SET_GAME_keyword_Msg"></span>
                                </div>
                                {{-- url --}}
                                <div class="mb-3 col-md-6">
                                    <label for="updateGameUrl" class="form-label required">Url</label>
                                    <input type="text" class="form-control" placeholder="Enter a url" id="updateGameUrl"
                                        name="url" required>
                                </div>
                                {{-- status --}}
                                <div class="mb-3 col-md-6">
                                    <label for="updateGameStatus" class="form-label optional">Status</label>
                                    <select class="form-select" id="updateGameStatus" name="status" required>
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                {{-- description --}}
                                <div class="mb-3 col-md-6">
                                    <label for="updateGameDescription" class="form-label optional">Description</label>
                                    <textarea class="form-control" id="updateGameDescription" placeholder="Enter a description" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary gameSubmitBtn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal modalAnimate fade" id="showImage" tabindex="-1" role="dialog" aria-labelledby="showImage"
            aria-hidden="true" data-animation-in="fadeInLeft" data-animation-out="bounceOut">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-custom-body text-center">
                        <img src="" alt="Game Image" id="setImageURL" class="img-fluid">
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
            checkDuplicateKeyword();
        });


        const checkDuplicateKeyword = () => {
            $('.gameKeyword').on('input', function() {
                const keyword = $(this).val();
                const type = $(this).data('type');
                var url = `/game/${keyword}/fetch?type=check-keyword`;
                if(type == 'update'){
                    const id = $('#updateGameID').val();
                    url = `/game/${id}/fetch?type=check-keyword-update&keyword=${keyword}`;
                }

                $('.SET_GAME_keyword_Msg').html(``);
                $('.gameSubmitBtn').prop('disabled', false);
                if(keyword.length < 1) {
                    return false;
                }

                axios.get(url)
                .then((response) => {
                    const status = response.data.status;
                    if (status == false) {
                            $('.gameSubmitBtn').prop('disabled', false);
                            $('.SET_GAME_keyword_Msg').html(`<span class="text-success">Keyword is available</span>`);
                        } else {
                            $('.SET_GAME_keyword_Msg').html(`<span class="text-danger">Keyword already exists</span>`);
                            $('.gameSubmitBtn').prop('disabled', true);
                        }
                    });
            });
        };


        const handleDataTable = () => {
            url = '/admin/game';
            $('#gameTableId').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: url,
                columns: [{
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                    {
                        render: function(data, type, row) {
                            return `<img src="${row.banner}" alt="banner" data-toggle="modal"
                                        data-target="#showImage" class="showImage" style="width: 50px; height: 50px;" />`;
                        },
                        targets: 0,
                        className: 'fit-content'
                    },
                    {
                        render: function(data, type, row) {
                            return row.title;
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
                            const url = row.url;
                            return url;
                        },
                        targets: 0,
                        className: 'fit-content'
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
                            return `<button type="button" class="btn btn-sm btn-primary" onClick="updateCampaign(${row.id})">Edit</button>`;
                        },
                        targets: 0,
                        className: 'fit-content'
                    }
                ],
                rowCallback: function(row, data) {
                    // Add a CSS class to the row based on the `type` attribute
                    if (data.type == 'current') {
                        $(row).css({
                            'background-color': '#e9f7ef', // Light green background
                            'color': '#155724', // Dark green text
                            'font-weight': 'bold', // Bold text
                            'border-left': '10px solid #28a745', // Green border on the left
                            'transition': 'background-color 0.3s ease' // Smooth hover effect
                        });
                    }
                }
            });


            $(document).on('click', '.showImage', function(event) {
                const URL = $(this).attr('src');
                $("#setImageURL").attr('src', URL);
            });
        };


        const handleStatus = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to change this campaign's status..!!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put(`/admin/campaigns/?type=status&id=${id}`)
                        .then(response => {
                            console.log(response.data)
                            const status = response.data.status;
                            const message = response.data.message;
                            if (status == false) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: message,
                                });
                                return false;
                            }
                            Swal.fire(
                                'Updated!',
                                'Campaign has been updated.',
                                'success'
                            );
                            $('#gameTableId').DataTable().ajax.reload();
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });
        };

        const updateCampaign = (id) => {



            const updateGame = new bootstrap.Modal(document.getElementById('updateGameModal'));

            axios.get(`/game/${id}/fetch`)
                .then((response) => {
                    const data = response.data.data;
                    console.log(data);
                    $('#updateGameID').val(data.id);
                    $('#updateGametitle').val(data.title);
                    $('#updateGameKeyword').val(data.keyword);
                    $('#updateGameUrl').val(data.url);
                    $('#updateGameDescription').val(data.description);
                    $('#updateGameStatus').val(data.status);

                });

            updateGame.show();
        };

        const handleCreateSubmit = () => {
            const createData = {
                name: $('#create_campaignName').val(),
                amount: $('#create_campaignAmount').val(),
                start_date_time: $('#create_startDateTime').val(),
                end_date_time: $('#create_endDateTime').val(),
                status: $('#createCampaignStatus').val(),
            };




            // Send a PUT request to update the campaign
            axios.post(`/admin/campaigns`, createData)
                .then((response) => {
                    const status = response.data.status;
                    if (status == false) {
                        console.log(response.data.data);
                    } else {
                        if ($.fn.DataTable.isDataTable('#gameTableId')) {
                            $('#gameTableId').DataTable().destroy(); // Destroy the existing DataTable instance
                            handleDataTable();
                        }
                    }
                })
                .catch(error => console.error('Error create campaign:', error));
        };


        $(".addCampaignBtn").click(function(event) {
            axios.get('/admin/fetch-campaigns?type=last-campaign')
                .then((response) => {
                    const data = response.data.data;
                    const start_time = moment(data.start_time, "HH:mm:ss.SSSSSS").format("HH:mm:ss");
                    const end_time = moment(data.end_time, "HH:mm:ss.SSSSSS").format("HH:mm:ss");
                    const start_date = moment(data.end_date).add(1, 'day');
                    const end_date = moment(data.end_date).add(7, 'day');

                    const start_date_time = start_date.format('YYYY-MM-DD') + " " + start_time;
                    const end_date_time = end_date.format('YYYY-MM-DD') + " " + end_time;

                    $("#create_startDateTime").val(start_date_time);
                    $("#create_endDateTime").val(end_date_time);
                })
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
                    if ($.fn.DataTable.isDataTable('#gameTableId')) {
                        $('#gameTableId').DataTable().destroy(); // Destroy the existing DataTable instance
                        handleDataTable();
                    }

                })
                .catch(error => console.error('Error updating campaign:', error));
        };
    </script>
@endpush
