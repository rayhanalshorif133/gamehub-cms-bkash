


<?php $__env->startSection('content'); ?>
    <style>
        .game-card-container {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            margin: auto;
        }

        .section-title-toggle {
            font-weight: bold;
            font-size: 1.1rem;
            padding: 10px;
            background: #82c0ff;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
            border: 1px solid #eee;
        }

        .section-title-toggle:hover {
            background: #e9ecef;
        }

        /* Leaderboard Scroll Container */
        .leaderboard-scroll-container {
            max-height: 300px;
            /* Adjust height as needed */
            overflow-y: auto;
            margin-top: 10px;
            border: 1px solid #eee;
            border-radius: 8px;
            background: #fff;
        }

        /* Custom Scrollbar Styling */
        .leaderboard-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .leaderboard-scroll-container::-webkit-scrollbar-thumb {
            background: #e2136e;
            border-radius: 10px;
        }

        .leaderboard-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .prize-table {
            width: 100%;
            border-collapse: collapse;
        }

        .prize-table thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 10;
            padding: 10px;
            font-size: 0.85rem;
            border-bottom: 2px solid #dee2e6;
            color: #333;
        }

        .prize-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }

        .image-container {
            width: 85%;
            margin: 15px auto;
        }

        .game_card_footer_direct_play {
            margin-bottom: 10px;
        }

        .game_card_footer_direct_play a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        /* Toggle Classes */
        .content-hidden {
            display: none;
        }

        /* Leaderboard Section Styling */
        .leaderboard-wrapper {
            margin-top: 20px;
            border-top: 1px solid #f1f1f1;
            padding-top: 20px;
        }

        .leaderboard-toggle-btn {
            width: 100%;
            background: #fff;
            border: 2px solid #f0f0f0;
            padding: 12px 18px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 700;
            color: #444;
        }

        .leaderboard-toggle-btn:hover {
            background: #fdfdfd;
            border-color: #e2136e;
        }

        .leaderboard-scroll-container {
            max-height: 280px;
            overflow-y: auto;
            margin-top: 12px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        /* Table Styling */
        .prize-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            padding: 0 10px;
        }

        .prize-table thead th {
            padding: 10px;
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
            border: none;
        }

        .prize-table tbody tr {
            background: #f8f9fa;
            transition: transform 0.2s;
        }

        .prize-table tbody tr:hover {
            transform: scale(1.01);
            background: #f1f1f1;
        }

        .prize-table td {
            padding: 12px 10px;
            border: none;
            vertical-align: middle;
        }

        /* Rank Styling */
        .rank-box {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 800;
            font-size: 13px;
            background: #eee;
            color: #666;
        }

        /* Top 3 Special Badges */
        tr:nth-child(1) .rank-box {
            background: #FFD700;
            color: #fff;
            box-shadow: 0 3px 8px rgba(255, 215, 0, 0.3);
        }

        tr:nth-child(2) .rank-box {
            background: #C0C0C0;
            color: #fff;
            box-shadow: 0 3px 8px rgba(192, 192, 192, 0.3);
        }

        tr:nth-child(3) .rank-box {
            background: #CD7F32;
            color: #fff;
            box-shadow: 0 3px 8px rgba(205, 127, 50, 0.3);
        }

        /* MSISDN and Score */
        .user-phone {
            font-weight: 600;
            color: #444;
            font-size: 12px;
        }

        .user-score {
            font-weight: 800;
            color: #e2136e;
            font-size: 12px;
        }

        /* Scrollbar Customization */
        .leaderboard-scroll-container::-webkit-scrollbar {
            width: 5px;
        }

        .leaderboard-scroll-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .game-card-container {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            margin: auto;
        }



        .rules-list-container {
            list-style: none;
            padding: 15px 10px;
            margin: 0;
            text-align: left;
        }

        .prize-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .prize-table td {
            padding: 10px;
            border: 1px solid #dee2e6;
            font-size: 0.9rem;
        }

        .image-container {
            width: 85%;
            margin: 15px auto;
        }

        .gift_announcement_card {
            position: absolute;
            bottom: 0;
            background: #ff0000;
            color: #ffffff;
            width: 100%;
            border-radius: 0 0 10px 10px;
        }

        .input-group-custom {
            display: flex;
            border: 1px solid #ced4da;
            border-radius: 8px;
            overflow: hidden;
            margin: 15px 0;
            width: stretch;
            position: relative;
        }

        .input-group-custom input {
            border: none;
            padding: 10px;
            flex: 1;
            outline: none;
            width: inherit;
        }

        .input-group-custom button {
            background: #e2136e;
            color: white;
            border: none;
            padding: 0 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            position: absolute;
            right: 0;
            height: 100%;
            font-size: 12px;
        }

        /* Toggle Classes */
        .content-hidden {
            display: none;
        }

        .rotate-icon {
            transform: rotate(180deg);
            transition: transform 0.3s ease;
        }

        /* New styling for "Your Rank" element based on reference image */
        .user-rank-banner {
            background: #ffffff;
            border-radius: 8px;
            padding: 12px 20px;
            margin: 15px auto;
            max-width: 90%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f1f1;
            position: relative;
        }

        /* The pseudo-elements below create the inward corner cut look like a ribbon or badge */
        .user-rank-banner::before,
        .user-rank-banner::after {
            content: '';
            position: absolute;
            top: 0;
            width: 0;
            height: 0;
            border-style: solid;
        }

        /* Top-left corner cut */
        .user-rank-banner::before {
            left: 0;
            border-width: 15px 15px 0 0;
            border-color: #f1f1f1 transparent transparent transparent;
        }

        /* Bottom-right corner cut */
        .user-rank-banner::after {
            right: 0;
            bottom: 0;
            top: auto;
            border-width: 0 0 15px 15px;
            border-color: transparent transparent #f1f1f1 transparent;
        }

        /* Actual text inside the banner */
        .user-rank-banner .rank-text {
            color: #333333;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            line-height: 1;
        }

        .score_active_container {
            background-color: #e2136e;
            color: white;
            position: absolute;
            top: 0;
            width: 100%;
        }

	

        .score_active_container p {
            margin: 0;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin: auto;
        }

        .score_container_update {
            background-color: #0191ffbf;
            color: white;
            position: relative;
            bottom: 20px;
            width: 8rem;
            padding: 10px 0;
            border-radius: 10px;
        }

	    

        .score_container_update h1,
        .score_container_update h2,
        .score_container_update h3 {
            text-shadow: #00000073 0px 0px 10px;
            text-align: center;
        }

        .score_container_update h1 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }

        .score_container_update h2 {
            font-size: 28px;
            margin: 5px 0;
            color: #fed800;
            font-weight: 700;
        }

        .score_container_update h3 {
            font-size: 12px;
            font-weight: 600;
            margin: 0;
        }

        .active_boost_container {
            align-items: center;
            background: #e3f2fd;
            color: #1976d2;
            padding: 8px 15px;
            border-radius: 0px 50px 0px 50px;
            font-family: sans-serif;
            border: 1px solid #bbdefb;
            position: absolute;
            bottom: 0;
        }

        .dot {
            height: 8px;
            width: 8px;
            background-color: #1976d2;
            border-radius: 50%;
            margin-right: 10px;
            animation: blink 1.2s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
    <section id="section_one" class="overflow-hidden">


        <input type="hidden" id="camp_id" value="<?php echo e($camp_id); ?>" />
        <input type="hidden" id="keyword" value="<?php echo e($game->keyword); ?>" />
        <input type="hidden" id="score" value="<?php echo e($score); ?>" />
        <div class="container" style="margin-bottom: 10rem">
            <div class="game-card game_over_card" style="padding: 2rem" data-campid="<?php echo e($camp_id); ?>">
                <div class="game_card_text">
                    <h1 class="game_over">Game Over</h1>
                </div>
                <div class="game_over_image-container">
                    <?php
                        $currentTime = now()->format('H:i');
                        $startTime = '10:00';
                        $endTime = '23:59';
                    ?>
                    
                    <img src="<?php echo e($game->icon); ?>" alt="Stick Monkey" class="game_icon">
                    <div class="game_icon_shadow"></div>
                    <div class="score_container">
                        <h2 class="game_over_game_title"><?php echo e($game->title); ?></h2>
                        <div class="score_container_update">
                            <h1>YOUR SCORE:</h1>
                            <h2><?php echo e($score); ?></h2>
                            <h3>Times Played: <b><?php echo e($playTimes); ?></b></h3>
                            

                        </div>
                    </div>
                    <style>

                    </style>
                    <?php if($boost != null): ?>
                        <div class="active_boost_container">
                            <span class="dot"></span>
                            <strong>Boost Active:</strong> <?php echo e($boost->remaining_time); ?> left
                        </div>
                    <?php endif; ?>

                </div>
                <div class="game_card_footer_direct_play">
                    <a href="<?php echo e($gameURL); ?>" id="game_url">Play Again</a>
                </div>
                <div class="game_card_footer_direct_play">
                    <a href="/">
                        Back to Home
                    </a>
                </div>
                
                    <div class="user-rank-banner">
                        <p class="rank-text">Your Rank #<span id="set_your_rank_score">---</span></p>
                    </div>
                
                <?php if($camp_id != 'free' && $leaderboardEnabled): ?>
                    <div class="section-title-toggle btnLeaderBoard">
                        <span><i class="fas fa-trophy me-2 text-warning"></i> Leaderboard</span>
                        <i class="fas fa-chevron-down" id="leaderboardIcon"></i>
                    </div>
                <?php endif; ?>
                <div id="leaderboardContent" class="content-hidden" style="display:none;">
                    <div class="leaderboard-scroll-container">
                        <table class="prize-table">
                            <thead>
                                <tr>
                                    <th class="text-start">Rank</th>
                                    <th class="text-start">Player</th>
                                    <th class="text-start">Prize</th>
                                    <th class="text-end">Score</th>
                                </tr>
                            </thead>
                            <tbody id="leaderboardBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <button id="bKash_button" class="d-none"></button>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerPart'); ?>
    <?php
        $type = 'account';
    ?>
    <div
        style="position: fixed;left: 0;bottom: 50px;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%;width: 100%;height: 50px;text-align: left;z-index: 9999;">
        <div class="row">
            <div class="col-md-12">
                <footer id="footer-menu-panel">
                    <nav class="navbar-expand fixed-bottom">
                        <ul class="navbar footer-body"
                            style="padding:12px 20px 22px 20px !important;position: relative;bottom: 44px;">
                            <li class="nav-item">
                                <a class="nav-link <?php if($type == 'category'): ?> active <?php endif; ?>" aria-current="page"
                                    href="<?php echo e(route('category')); ?>">
                                    <i class="fa-solid fa-layer-group fa-2x"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php if($type == 'home'): ?> active <?php endif; ?>"
                                    href="<?php echo e(route('home')); ?>">
                                    <i class="fas fa-home fa-2x"></i>
                                </a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <?php if(Auth::check()): ?>
                                    <a class="nav-link <?php if($type == 'account'): ?> active <?php endif; ?>" aria-current="page"
                                        href="<?php echo e(route('account')); ?>">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                <?php else: ?>
                                    <a class="nav-link <?php if($type == 'category'): ?> loginModalBtn <?php endif; ?> <?php if($type == 'account'): ?> active <?php endif; ?>"
                                        aria-current="page" href="#" data-toggle="modal" data-target="#loginModel">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>

                </footer>
            </div>
        </div>
    </div>

    <button id="bkash_btn" type="button" onclick="window.webViewJSBridge.goBackHome('Tickets')"
        style="position: fixed;left: 0;bottom: 0;width: 100%;height: 8%;font-size: 18px;border-radius: 0px;margin-top: 2%; 
color: white!important;width: 100%;height: 50px;text-align: left;background-color: #E2136E;border-color: #E2136E;z-index: 9999;">
        Back to bKash App Home<img src="https://capp-cdn.labs.bka.sh/images/arrow.svg"
            style="float: right;margin-top: 1%; 
padding-right: 1%;"></button>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script>
        // Toggle Functionality
        function toggleSection(contentId, iconId) {
            const content = document.getElementById(contentId);
            const icon = document.getElementById(iconId);

            if (content.style.display === "block") {
                content.style.display = "none";
                icon.style.transform = "rotate(0deg)";
            } else {
                content.style.display = "block";
                icon.style.transform = "rotate(180deg)";
            }
        }
        $(() => {
            // 1. Bortoman URL-ti get kora
            let currentUrl = new URL(window.location.href);
            let params = new URLSearchParams(currentUrl.search);
            params.delete('puntaje');
            const camp_id = $("#camp_id").val();
            const score = $("#score").val();
            const keyword = $("#keyword").val();
            params.set('score', score);
            params.set('camp_id', camp_id);
            params.set('keyword', keyword);
            let newUrl = currentUrl.origin + currentUrl.pathname + '?' + params.toString();
            window.history.replaceState({}, '', newUrl);


            const GAMEURL = $("#game_url");
            let currentHref = GAMEURL.attr("href");

            const pattern = /\/game-play\/\d+\/\d+/;

            if (!pattern.test(currentHref)) {
                let parts = currentHref.split('/');
                let dynamicID = parts[2];
                let newHref = `/game-play/${dynamicID}/free`;
                GAMEURL.attr("href", newHref);
            }

            handleFetchLeaderboard();
        });

        function maskMsisdn(number) {

            if (number.startsWith("88")) {
                number = number.substring(2);
            }

            let prefix = number.substring(0, 2);
            let suffix = number.substring(7);

            return prefix + "--" + suffix;
        }

        const handleFetchLeaderboard = () => {

            $('.btnLeaderBoard').on('click', function() {
                const leaderboardContent = document.getElementById('leaderboardContent');
                const leaderboardIcon = document.getElementById('leaderboardIcon');
                toggleSection('leaderboardContent', 'leaderboardIcon');
            });

            const camp_id = $("#camp_id").val();
            const keyword = $("#keyword").val();
            const authMsisdn = $("#auth_phone_number").val();
            if (camp_id !== ' ') {
                axios.get(`/leaderboard/${camp_id}/fetch`)
                    .then(response => {
                        const leaderboardData = response.data.data;
                        leaderboardData.daily.forEach(item => {
                            const row = document.createElement('tr');

                            if (authMsisdn && authMsisdn === item.msisdn) {
                                row.style.backgroundColor = '#d4bfff';
                                $("#set_your_rank_score").html(`${item.rank} (${item.total_score})`);
                            }

                            row.innerHTML = `
                            <td class="text-start">
                                <div class="rank-box">${item.rank}</div>
                            </td>
                            <td class="text-start">
                                <span class="user-phone">${maskMsisdn(item.msisdn)}</span>
                            </td>
                            <td class="text-start">
                                <span class="user-phone">${item.prize}</span>
                            </td>
                            <td class="text-end">
                                <span class="user-score">${item.total_score}</span>
                            </td>
                        `;
                            leaderboardBody.appendChild(row);
                        });
                    });
            }
        };
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.web', ['type' => 'account'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bdg.b2mwap.com/resources/views/web/gameover.blade.php ENDPATH**/ ?>