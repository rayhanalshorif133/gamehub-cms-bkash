$(() => {
    const BASE_URL = window.location.href;
    const urlParams = new URLSearchParams(new URL(BASE_URL).search);




    const paymentStatus = urlParams.get('payment');
    const campaignId = urlParams.get('campaign_id');
    const coins = urlParams.get('coins');


    if (paymentStatus == 'success' && campaignId) {
        tournamentOffcanvas(campaignId, "payment");
        return false;
    }

    if (coins) {
        coinSuccessOffcanvas(coins, paymentStatus);
        return false;
    }

    // duplicate_all_transactions
    if (paymentStatus == "Duplicate for All Transactions") {
        tournamentOffcanvas(campaignId, "duplicate_all_transactions");
        return false;
    }

    if (paymentStatus == "failed") {
        coinSuccessOffcanvas(0, paymentStatus);
        return false;
    }

    handleBlockMsg();
});


const handleBlockMsg = () => {
    $(".black_msg_close_btn").click(function () {
        const camp_id = $(this).attr('data-campid');
        axios.get(`/campaign/block/user?type=read-notice&read_status=1&camp_id=${camp_id}`)
            .then(function (res) {
                window.location.reload();
            });
    });
};

$(".gameDetailsCampaignModal").click(function (event) {
    if ($(event.target).closest(".black_msg_close_btn").length) {
        return;
    }
    const id = $(this).attr("data-campid");
    tournamentOffcanvas(id);
});

const coinSuccessOffcanvas = (coins = 0, status) => {
    const getCoinSuccessOffcanvas = document.getElementById('coinsuccess-offcanvas');
    const offcanvasInstance = new bootstrap.Offcanvas(getCoinSuccessOffcanvas);
    $("#set_coins").text(coins);
    if (status == "failed") {

        const message = new URL(window.location).searchParams.get('msg') || 'Something went wrong. You were unable to purchase the coins.';

        $("#failedMessage").text(message);
        $(".failure-wrapper").removeClass('hidden');
        $(".success-wrapper").addClass('hidden');
    } else {
        $(".failure-wrapper").addClass('hidden');
        $(".success-wrapper").removeClass('hidden');
    }
    offcanvasInstance.show();
    getCoinSuccessOffcanvas.addEventListener('hidden.bs.offcanvas', event => {
        const url = new URL(window.location);
        url.search = '';
        if (url.pathname.startsWith('/public')) {
            url.pathname = url.pathname.replace('/public', '');
        }
        window.history.replaceState({}, document.title, url);
        window.location.reload();
    });

    setTimeout(() => {
        offcanvasInstance.hide();
    }, 3000);


};


function maskMsisdn(number) {

    if (number.startsWith("88")) {
        number = number.substring(2);
    }

    let prefix = number.substring(0, 4);
    let suffix = number.substring(6);

    return prefix + "---" + suffix;
}


const tournamentOffcanvas = (campaignId, type = "tournament") => {
    const msisdn = $("#auth_phone_number").val();
    $(".priceBtn-container").html('');
    const getTournamentOffcanvas = document.getElementById('tournament-offcanvas');
    $("#tournament-offcanvas").attr("data-type", type);

    if (type == "payment") {
        $(".payment-alert").removeClass('d-none').addClass('alert-success').removeClass('alert-danger');
        $(".payment-alert").html(`
            <i class="fa-solid fa-circle-check"></i>
                <span class="ms-2">Payment successful !!!</span>
        `);
    } else if (type == "duplicate_all_transactions") {
        $(".payment-alert").removeClass('d-none').removeClass('alert-success').addClass('alert-danger');
        $(".payment-alert").html(`
            <i class="fa-regular fa-circle-xmark"></i>
                <span class="ms-2">Duplicate for All Transactions !!!</span>
        `);
    }

    const offcanvasInstance = new bootstrap.Offcanvas(getTournamentOffcanvas);
    axios.get(`/campaign/${campaignId}/fetch?msisdn=${msisdn}`)
        .then(function (response) {
            const data = response.data.data;


            $("#subs_validity").text(`2. ${data.subs_validity}`);
            $("#prize_description").text(`3. ${data.prize_description}`);

            $(".gameDetailsCampaignModalImage").attr("src", data.banner);
            $(".game-name").text(data.name);
            $(".game-description").text(data.game.title);

            if (data.prizes) {
                $(".priceBtn-container").html('');
                var prizes = '';
                data.prizes.distributions.map(function (prize) {
                    if (prize.rank_min == prize.rank_max) {
                        prizes += `<div class="item mb-2 d-flex justify-content-between">
                            <p class="mb-0">${prize.prize_label}</p>
                            <div class="price"><span>${parseInt(prize.amount)} tk</span></div>
                        </div>`;
                    } else {
                        prizes += `<div class="item mb-2 d-flex justify-content-between">
                                <p class="mb-0">${prize.prize_label}</p>
                                <div class="price"><span>${parseInt(prize.amount)} tk</span></div>
                            </div>`;
                    }
                });
                $(".priceBtn-container").html(`${prizes}`);
            } else {
                $(".priceBtn-container").html('');
            }


            if (data.hasSubs) {
                $(".trial-play-btn").html('');
                $(".game-buttons").html(`
                    <div class="play-button">
                        <a href="/game-play/${data.game.id}/${campaignId}" class="custom_play_button" data-campid=${campaignId}>
                            <i class="fas fa-play mx-1"></i> Play Now
                        </a>
                    </div>
                `);
                $(".game-buttons").css({ "--grid-template-rows": "1 1fr" });

                $(".append_leaderboard").html(`
                    <div class="btnContainer" style="--modal-width: 86%;--margin-bottom: -9px;margin-top: -9px;">
                    <button class="d-flex align-items-center leaderboardBtn" data-campid=${campaignId}>
                        Leaderboard <i class="fa-solid fa-angle-down mx-2 rotate-icon"></i>
                    </button>
                    <div class="dropdown-container hidden leaderboardBtn-container rounded bg-light shadow-sm">
                        <div
                            class="item-header d-flex justify-content-between fw-bold text-secondary border-bottom pb-2 mb-2">
                            <p class="mb-0">Rank</p>
                            <p class="mb-0">Mobile</p>
                            <p class="mb-0">Prize</p>
                            <p class="mb-0">Score</p>
                        </div>
                    </div>
                    </div>
                `);

                // leaderboard-content

                var items = '';


                axios.get(`/leaderboard/${campaignId}/fetch`)
                    .then(function (response) {
                        const {
                            daily,
                            user,
                            weekly
                        } = response.data.data;


                        var wonScore = '';
                        daily.length > 0 && daily.map(function (item, index) {
                            if (msisdn == item.msisdn) {
                                wonScore = `
                                        <div class="item ${index < 5 && 'hidden'} d-flex justify-content-between mb-2" style="--bg-color: #D1B4FF;">
                                                    <p class="mb-0">${index + 1}</p>
                                                    <p class="mb-0">${maskMsisdn(item.msisdn)}</p>
                                                    <p class="mb-0">${item.prize}</p>
                                                    <div class="price"><span>${item.total_score}</span></div>
                                        </div>
                                    `;
                                items += `
                                        <div class="item d-flex justify-content-between mb-2" style="--bg-color: #D1B4FF;">
                                                    <p class="mb-0">${index + 1}</p>
                                                    <p class="mb-0">${maskMsisdn(item.msisdn)}</p>
                                                    <p class="mb-0">${item.prize}</p>
                                                    <div class="price"><span>${item.total_score}</span></div>
                                        </div>
                                    `;
                            } else {
                                items += `
                                        <div class="item d-flex justify-content-between mb-2">
                                                    <p class="mb-0">${index + 1}</p>
                                                    <p class="mb-0">${maskMsisdn(item.msisdn)}</p>
                                                    <p class="mb-0">${item.prize}</p>
                                                    <div class="price"><span>${item.total_score}</span></div>
                                        </div>
                                    `;
                            }
                        });

                        $(".leaderboard-content").html(`<div class="btnContainer mb-3">
                            <div class="dropdown-container hidden leaderboardBtn-container bg-light shadow-sm">${wonScore}${items}</div>
                        </div>
                        `);

                    });



            } else {
                $("#gameDetailsTk").text(``);
                $(".append_leaderboard").html('');
                $(".leaderboard-content").html('');
                if (data.time_status == 'Expired') {
                    $(".game-buttons").html(`
                                            <div class="play-button">
                                                <span class="text-danger font-bold">⚠️ This campaign has expired.</span>
                                                <div>
                                                    <a href="/game-play/${data.game.id}/free" class="btn btn-outline-info"><i class="fas fa-play"></i> Trial Play</a>
                                                </div>
                                            </div>
                                        `);
                } else {
                    $(".game-buttons").html(`
                    <div class="play-button" style="width: 13rem;">
                        <button id="bKash_button" class="custom_play_button" data-amount=${data.amount} data-campid=${campaignId}>
                            <div class="bkash-logo"><img src="/images/play_button_bkash_logo.png" alt="bKash"></div>
                            <div><i class="fas fa-play mx-1"></i> Play @Tk${data.amount} </div>
                        </button>
                    </div>
                    <div class="trial-play-btn">
                        <a href="/game-play/${data.game.id}/${campaignId}" class="custom_play_button"><i class="fas fa-play"></i> Trial Play</a>
                    </div>
                `);
                }
            }
        });
    offcanvasInstance.show();

    getTournamentOffcanvas.addEventListener('hidden.bs.offcanvas', event => {
        const type = getTournamentOffcanvas.getAttribute('data-type');

        if (type === "payment" || type === "duplicate_all_transactions") {
            const url = new URL(window.location);
            url.search = ''; // Remove all query parameters
            window.history.replaceState({}, document.title, url);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }



        if (!$(".priceBtn-container").hasClass('hidden')) {
            $(".priceBtn-container").toggleClass('hidden');
            $('.priceBtn').find('i').toggleClass('rotated');
        }

        if (!$(".tournamentRulesBtn-container").hasClass('hidden')) {
            $(".tournamentRulesBtn-container").toggleClass('hidden');
            $('.tournamentRulesBtn').find('i').toggleClass('rotated');
        }

        if (!$(".leaderboardBtn-container").hasClass('hidden')) {
            $(".leaderboardBtn-container").toggleClass('hidden');
            $('.leaderboardBtn').find('i').toggleClass('rotated');
        }


    });

    if (type === "payment" || type === "duplicate_all_transactions") {
        setTimeout(() => {
            offcanvasInstance.hide();
        }, 3000);
    }

};


