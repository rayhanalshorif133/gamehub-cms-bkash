<div class="modal fade" id="createCampainsModal" tabindex="-1" aria-labelledby="createCampainsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Multi-Level Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.campaign.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row border-bottom mb-4 pb-3">
                        <!-- Campaign Name -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label required">Campaign Name</label>
                            <input type="text" class="form-control" name="name" required
                                placeholder="Main Campaign Name">
                        </div>

                        <!-- Join Amount -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label required">Join Amount</label>
                            <input type="number" step="0.01" class="form-control" name="amount" required
                                placeholder="0.00">
                        </div>

                        <!-- Banner Image Add Kora Hoyeche -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label required">Campaign Banner</label>
                            <input type="file" class="form-control" name="banner" accept="image/*" required>
                            <div class="form-text">Format: JPG, PNG (Recommended: 1200x600)</div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div id="levels-container">
                        <h6 class="fw-bold mb-3">Campaign Levels</h6>
                        <!-- Level 1 (Static) -->
                        <div class="level-card border rounded p-3 mb-3 bg-light position-relative">
                            <h6 class="text-primary mb-3 font-weight-bold">Level 1</h6>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label required">Select a Game</label>
                                    <select class="form-select" name="levels[0][game_id]" required>
                                        <option value="" selected disabled>Select a Game</option>
                                        @foreach ($games as $game)
                                            <option value="{{ $game->id }}">{{ $game->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label required">Select a Prize</label>
                                    <select class="form-select" name="levels[0][prize_id]" required>
                                        <option value="" selected disabled>Select a prize</option>
                                        @foreach ($prizes as $prize)
                                            <option value="{{ $prize->id }}">{{ $prize->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label required">Start Date</label>
                                    <input type="date" class="form-control" name="levels[0][start_date]" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label required">End Date</label>
                                    <input type="date" class="form-control" name="levels[0][end_date]" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-level-btn">
                        <i class="bi bi-plus-circle"></i> Add New Level
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Campaign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let levelCount = 1;

    document.getElementById('add-level-btn').addEventListener('click', function() {
        const container = document.getElementById('levels-container');

        // Level Template using type="date"
        const levelHtml = `
        <div class="level-card border rounded p-3 mb-3 bg-light position-relative shadow-sm mt-3">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-level" aria-label="Remove"></button>
            <h6 class="text-primary mb-3 font-weight-bold">Level ${levelCount + 1}</h6>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label required">Select a Game</label>
                    <select class="form-select" name="levels[${levelCount}][game_id]" required>
                        <option value="" selected disabled>Select a Game</option>
                        @foreach ($games as $game)
                            <option value="{{ $game->id }}">{{ $game->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label required">Select a Prize</label>
                    <select class="form-select" name="levels[${levelCount}][prize_id]" required>
                        <option value="" selected disabled>Select a prize</option>
                        @foreach ($prizes as $prize)
                            <option value="{{ $prize->id }}">{{ $prize->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label required">Start Date</label>
                    <input type="date" class="form-control" name="levels[${levelCount}][start_date]" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label required">End Date</label>
                    <input type="date" class="form-control" name="levels[${levelCount}][end_date]" required>
                </div>
            </div>
        </div>`;

        container.insertAdjacentHTML('beforeend', levelHtml);
        levelCount++;
    });

    // Remove Level Logic
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-level')) {
            e.target.closest('.level-card').remove();

            // Re-label remaining levels and update array indices
            const levelCards = document.querySelectorAll('.level-card');
            levelCount = levelCards.length;

            levelCards.forEach((card, index) => {
                card.querySelector('h6').textContent = `Level ${index + 1}`;

                // Update select and input names to maintain correct array indexing
                card.querySelector('select[name*="[game_id]"]').name = `levels[${index}][game_id]`;
                card.querySelector('select[name*="[prize_id]"]').name = `levels[${index}][prize_id]`;
                card.querySelector('input[name*="[start_date]"]').name = `levels[${index}][start_date]`;
                card.querySelector('input[name*="[end_date]"]').name = `levels[${index}][end_date]`;
            });
        }
    });
</script>
