<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>WEB | Bkash Game</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@200;300;400;500;600;700&family=Poppins:wght@100;400;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>

    <link href="{{ asset('assets/dist/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/home.css') }}" rel="stylesheet">

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
            background: #f8f9fa;
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
    </style>
</head>

<body style="overflow-x: hidden; background-color: #f4f7f6;">

    @if (Auth::check())
        <header class="container mt-3">
            <div class="navbar justify-content-center">
                <img src="{{ asset('/images/logo.png') }}" alt="logo" style="width:8.5rem;" />
            </div>
        </header>
    @endif

    <main role="main" class="container mt-4">
        @if ($activeCampaign)
            <div class="game-card-container">
                <div class="game_card_text mb-3">
                    <div class="payment-alert alert alert-danger hidden">
                        Payment failed! Please try again.
                    </div>
                    <h1 class="fw-bold h3">Play & Win</h1>
                    <h2 class="text-muted h5">Stick Monkey</h2>
                </div>

                <div class="image-container position-relative">
                    <img src="{{ asset($activeCampaign->banner) }}" class="img-fluid rounded-4" alt="Game Banner">
                    <div class="gift_announcement_card">
                        <p class="m-0 py-2 fw-bold text-center">মোট পুরস্কার ৳৭,৩০০</p>
                    </div>
                </div>

                <div class="bkash-input-section">
                    <label class="fw-bold mb-2">Bkash Number Input</label>
                    <div class="input-group-custom">
                        <span class="p-2 bg-light"><i class="fas fa-mobile-alt"></i></span>
                        <input type="number" id="auth_phone_number" placeholder="01XXXXXXXXX">
                        <button type="button" id="bKash_button" data-campid="{{ $activeCampaign->id }}"
                            data-amount="1">
                            Join@TK100
                        </button>
                    </div>
                    <p class="small text-muted text-start">Ensure this is a registered bKash number.</p>
                </div>

                <div class="d-flex justify-content-between text-danger fw-bold mb-3">
                    <span>Start: {{ \Carbon\Carbon::parse($activeCampaign->start_date)->format('d M Y') }}</span>
                    <span>End: {{ \Carbon\Carbon::parse($activeCampaign->end_date)->format('d M Y') }}</span>
                </div>

                <hr>

                <div class="rules-wrapper mb-3">
                    <div class="section-title-toggle" onclick="toggleSection('rulesContent', 'rulesIcon')">
                        <span><i class="fas fa-scroll me-2 text-success"></i> Tournament Rules</span>
                        <i class="fas fa-chevron-down" id="rulesIcon"></i>
                    </div>
                    <div id="rulesContent" class="content-hidden">
                        <ul class="rules-list-container">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>গেমস খেলে প্রতিদিন
                                পুরস্কার পেতে বিডি গেমার্স এ সাবস্ক্রাইব করুন।</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>সাবস্ক্রিপশন চার্জ
                                ১০০ টাকা মেয়াদ ৭ দিন।</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>টুর্নামেন্ট শুরু
                                সোমবার ও শেষ পরবর্তি সপ্তাহের রবিবার, টুর্নামেন্ট শেষে ২৫ জন শীর্ষস্থান অধিকারি পাবে
                                বিভিন্ন অংকের পুরষ্কার, ১ম স্থান অধিকারি ৳১,৫০০ ২য় স্থান অধিকারি ৳১,০০০ ও ৩য় স্থান
                                অধিকারি ৳৭৫০। পুর্নাংগ পুরষ্কারের তালিকা পপ আপ মেনুতে দেয়া আছে।</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>পুরষ্কার ঘোষণার ৭২
                                ঘণ্টার মধ্যে গ্রাহকের বিকাশ নাম্বারে তাদের পুরস্কারের অর্থ পাঠিয়ে দেওয়া হবে।</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>সপ্তাহের রবিবার,
                                মঙ্গলবার পুর্ববর্তি দিনের বকেয়া পুরষ্কার ও বৃহস্পতিবার পুর্ববর্তি দিন ও পুরো সপ্তাহের
                                টুর্নামেন্টের পুরষ্কার প্রদান করা হয়ে থাকে। </li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>অংশগ্রহণকারীরা
                                প্রোফাইলে যে সকল টুর্নামেন্টে অংশ নিয়েছেন এবং অবস্থান দেখতে পারবে, এছাড়াও টুর্নামেন্ট
                                চলাকালে গেমসের পেইজে, লিডারবোর্ডে, ক্যাম্পেইনের ফলাফল ও বিজয়ীদের তালিকা দেখতে পারবে।
                            </li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> এছাড়াও বিস্তারিত
                                জানতে হলে উল্লেখিত ঠিকানায় ই-মেইল অথবা সরাসরি কল করতে পারবে।
                                <br />
                                <span class="d-flex">a. <a href="mailto:cservice@b2m-tech.com" class="mx-1">
                                        cservice@b2m-tech.com</a></span> <br />
                                <span class="d-flex">b. <a href="tel:+8801680388774" class="mx-1">8801680388774</a>,
                                    <a href="tel:+8801725298711" class="mx-1">8801725298711</a></span>
                            </li>
                            <li class="p-2 bg-light rounded text-danger mt-2"><strong> বিঃদ্রঃ:</strong>
                                টুর্নামেন্টে অংশগ্রহনকারি যদি কোন ধরনের অসুদপায় অবলম্বনের চেষ্টা করে বলে প্রমাণিত হয় সে
                                ক্ষেত্রে তার পুর্ববর্তি সকল স্কোর বাতিল বলে গণ্য হবে এবং তাকে টুর্নামেন্ট থেকে বহিষ্কার
                                করা হবে।
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="prizes-wrapper mb-3">
                    <div class="section-title-toggle" onclick="toggleSection('prizeContent', 'prizeIcon')">
                        <span><i class="fas fa-trophy me-2 text-warning"></i> Weekly Prizes</span>
                        <i class="fas fa-chevron-down" id="prizeIcon"></i>
                    </div>
                    <div id="prizeContent" class="content-hidden">
                        <table class="prize-table">
                            <tr>
                                <td>🏆 1st Place</td>
                                <td class="text-end fw-bold">1500 TK</td>
                            </tr>
                            <tr>
                                <td>🥈 2nd Place</td>
                                <td class="text-end fw-bold">1000 TK</td>
                            </tr>
                            <tr>
                                <td>🥉 3rd Place</td>
                                <td class="text-end fw-bold">750 TK</td>
                            </tr>
                            <tr>
                                <td>🏅 4th Place</td>
                                <td class="text-end fw-bold">500 TK</td>
                            </tr>
                            <tr>
                                <td>🎖️ 5th – 8th Place</td>
                                <td class="text-end fw-bold">250 TK (Each)</td>
                            </tr>
                            <tr>
                                <td>🎗️ 9th – 25th Place</td>
                                <td class="text-end fw-bold">150 TK (Each)</td>
                            </tr>
                        </table>



                    </div>
                </div>

            </div>
        @endif
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

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

        var countClick = 0;
        // bKash Payment Logic (As per your existing code)
        $(document).on('click', "#bKash_button", function() {
            countClick++;

            if (countClick == 1) {
                $(this).click();
            }
            const msisdn = $("#auth_phone_number").val();
            const amount = $(this).attr("data-amount");
            const campaign_id = $(this).attr("data-campid");

            if (!msisdn || msisdn.length < 11) {
                alert("Please enter a valid bKash number");
                return;
            }

            console.log("Initiating bKash for:", msisdn);

            const keyword = 'WEB';
            var paymentID = '';


            const PAY_URL = 'https://bkpay.b2mwap.com';
            const ROOT_URL = window.location.origin;
            const redirect_url =
                `${ROOT_URL}/api/callback-payment-web/msisdn/${msisdn}/campaign_id/${campaign_id}/amount/${amount}/`;

            try {
                bKash.init({
                    paymentMode: 'checkout',
                    paymentRequest: {
                        amount: '' + amount,
                        intent: 'sale'
                    },
                    createRequest: async function(request) {
                        try {
                            const response = await axios.get(
                                `${PAY_URL}/api/payment?keyword=${keyword}&msisdn=${msisdn}&amount=${amount}&redirect_url=${redirect_url}`
                            );
                            const data = response.data;

                            if (data && data.paymentID != null) {
                                const paymentID = data.paymentID;
                                window.sessionStorage.setItem('paymentID', paymentID);
                                bKash.create().onSuccess(data);
                            } else {
                                bKash.create().onError();
                            }

                        } catch (error) {
                            $('#bKash_button').html(`<i class="fas fa-play"></i> Play Now!`);
                            console.error('ERROR 1', error);
                        }
                    },
                    executeRequestOnAuthorization: function() {
                        const paymentID = window.sessionStorage.getItem('paymentID');
                        const url = `${PAY_URL}/api/payment-execute/${paymentID}`;

                        setTimeout(() => {
                            window.location.href = url;
                        }, 1000);
                    },
                    onClose: function() {
                        $(".payment-alert").removeClass('hidden');

                        const buttonText = window.sessionStorage.getItem('button-text');
                        $("#bKash_button").text(buttonText);
                        $("#bKash_button").attr('disabled', true);

                        setTimeout(() => {
                            location.reload();
                        }, 5000);
                    }
                });

            } catch (error) {
                toastr.error('Payment Api Fetching Failed');
            }

        });

        $(() => {
            var status = new URLSearchParams(window.location.search).get('status');
            if (status === 'failed') {
                $(".payment-alert").removeClass('hidden');
            }
        });
    </script>
</body>

</html>
