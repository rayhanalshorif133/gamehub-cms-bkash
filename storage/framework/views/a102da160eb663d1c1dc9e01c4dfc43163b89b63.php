<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NXT SMS — Bulk SMS Platform</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --neon: #00f5c4;
            --neon2: #7b2fff;
            --neon3: #ff3e6c;
            --dark: #060910;
            --card: #0d1422;
            --card2: #111827;
            --border: rgba(0, 245, 196, .14);
            --body: #e2eaf7;
            --muted: #8a9bb8;
            --faint: #51637d;
            --nav: rgba(6, 9, 16, .92);
            --grid: rgba(0, 245, 196, .04);
        }

        html.light {
            --dark: #f3f7ff;
            --card: #ffffff;
            --card2: #f4f7ff;
            --border: rgba(0, 180, 145, .16);
            --body: #0e1a2c;
            --muted: #435977;
            --faint: #7488a4;
            --nav: rgba(243, 247, 255, .9);
            --grid: rgba(0, 180, 145, .05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark);
            color: var(--body);
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
            transition: .3s;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .grid-bg {
            background-image:
                linear-gradient(var(--grid) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            opacity: .5;
        }

        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            background: var(--nav);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-link {
            color: var(--muted);
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: .2s;
        }

        .nav-link:hover {
            color: var(--neon);
        }

        .hero-accent {
            background: linear-gradient(135deg, var(--neon), var(--neon2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--neon), #00c9a8);
            color: #061018;
            border: none;
            border-radius: 50px;
            padding: .9rem 1.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            cursor: pointer;
            transition: .3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(0, 245, 196, .4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, .04);
            border: 1px solid var(--border);
            color: var(--body);
            border-radius: 50px;
            padding: .9rem 1.6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: .3s;
        }

        .btn-secondary:hover {
            border-color: rgba(0, 245, 196, .4);
            color: var(--neon);
        }

        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 1.5rem;
            transition: .3s;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(0, 245, 196, .4);
            box-shadow: 0 20px 50px rgba(0, 0, 0, .4);
        }

        .pricing-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 26px;
            padding: 2rem;
            transition: .3s;
            position: relative;
        }

        .pricing-card:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 245, 196, .4);
        }

        .pricing-card.active {
            border: 1px solid rgba(0, 245, 196, .5);
            box-shadow: 0 0 40px rgba(0, 245, 196, .12);
        }

        .sec-label {
            color: var(--neon);
            text-transform: uppercase;
            letter-spacing: .2em;
            font-size: .72rem;
            font-weight: 800;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .sec-label::before {
            content: '';
            width: 18px;
            height: 2px;
            background: var(--neon);
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
        }

        .dashboard {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 30px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .sms-box {
            background: var(--card2);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1rem;
        }

        .stats {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 1.3rem;
            text-align: center;
        }

        .toggle {
            width: 44px;
            height: 24px;
            border-radius: 50px;
            border: 1px solid var(--border);
            background: var(--card);
            position: relative;
            cursor: pointer;
        }

        .knob {
            width: 18px;
            height: 18px;
            background: linear-gradient(135deg, var(--neon), #00c9a8);
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        html.light .knob {
            transform: translateX(20px);
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .fade {
            opacity: 0;
            transform: translateY(30px);
            transition: .7s;
        }

        .fade.show {
            opacity: 1;
            transform: none;
        }

        .price {
            font-size: 2.4rem;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .gradient-border {
            position: relative;
            overflow: hidden;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 1px;
            border-radius: inherit;
            background: linear-gradient(135deg, var(--neon), var(--neon2));
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            pointer-events: none;
        }

        @media(max-width:900px) {
            .hero-grid {
                grid-template-columns: 1fr !important;
            }

            .pricing-grid {
                grid-template-columns: 1fr !important;
            }

            .feature-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>

<body class="grid-bg">

    <!-- NAVBAR -->
    <nav id="navbar">
        <div
            style="max-width:1300px;margin:auto;padding:0 1.4rem;height:72px;display:flex;align-items:center;justify-content:space-between;">

            <div style="display:flex;align-items:center;gap:.8rem;">
                <div
                    style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,var(--neon),var(--neon2));display:flex;align-items:center;justify-content:center;font-weight:800;color:#061018;font-family:'Plus Jakarta Sans',sans-serif;">
                    SMS
                </div>

                <div>
                    <span style="font-weight:800;font-size:1rem;">NXT</span>
                    <span class="hero-accent" style="font-weight:800;font-size:1rem;">SMS</span>
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:2rem;" class="hide-mobile">
                <span class="nav-link">Features</span>
                <span class="nav-link">Pricing</span>
                <span class="nav-link">API</span>
                <span class="nav-link">Coverage</span>
                <span class="nav-link">Contact</span>
            </div>

            <div style="display:flex;align-items:center;gap:.8rem;">
                <button class="btn-secondary hide-mobile">Login</button>
                <button class="btn-primary">Get Started</button>

                <div class="toggle" onclick="toggleTheme()">
                    <div class="knob">🌙</div>
                </div>
            </div>

        </div>
    </nav>

    <!-- HERO -->
    <section style="padding:130px 1.5rem 80px;position:relative;overflow:hidden;">

        <div class="orb" style="width:350px;height:350px;background:rgba(0,245,196,.12);top:-120px;left:-80px;">
        </div>
        <div class="orb" style="width:420px;height:420px;background:rgba(123,47,255,.14);right:-120px;top:-100px;">
        </div>

        <div class="hero-grid"
            style="max-width:1300px;margin:auto;display:grid;grid-template-columns:1.1fr .9fr;gap:3rem;align-items:center;">

            <!-- LEFT -->
            <div class="fade">

                <div class="sec-label">Bulk SMS Platform</div>

                <h1 style="font-size:clamp(2.5rem,6vw,5rem);line-height:1.05;font-weight:800;margin-bottom:1.3rem;">
                    Send <span class="hero-accent">Millions</span><br>
                    of SMS in Seconds 🚀
                </h1>

                <p style="font-size:1rem;line-height:1.8;color:var(--muted);max-width:620px;margin-bottom:2rem;">
                    Powerful enterprise-grade Bulk SMS solution for OTP, marketing campaigns,
                    alerts, promotions, and transactional messaging with real-time analytics.
                </p>

                <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;">
                    <button class="btn-primary">
                        Start Sending SMS
                    </button>

                    <button class="btn-secondary">
                        ▶ Watch Demo
                    </button>
                </div>

                <div style="display:flex;gap:1.5rem;flex-wrap:wrap;">

                    <div class="stats">
                        <div style="font-size:2rem;">📨</div>
                        <div style="font-size:1.5rem;font-weight:800;">50M+</div>
                        <div style="color:var(--faint);font-size:.8rem;">SMS Delivered</div>
                    </div>

                    <div class="stats">
                        <div style="font-size:2rem;">⚡</div>
                        <div style="font-size:1.5rem;font-weight:800;">99.9%</div>
                        <div style="color:var(--faint);font-size:.8rem;">Delivery Rate</div>
                    </div>

                    <div class="stats">
                        <div style="font-size:2rem;">🌍</div>
                        <div style="font-size:1.5rem;font-weight:800;">190+</div>
                        <div style="color:var(--faint);font-size:.8rem;">Countries</div>
                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="fade">

                <div class="dashboard gradient-border">

                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
                        <div>
                            <div style="font-weight:800;font-size:1rem;">SMS Dashboard</div>
                            <div style="font-size:.8rem;color:var(--muted);">Live Campaign Analytics</div>
                        </div>

                        <div
                            style="background:rgba(0,245,196,.1);border:1px solid rgba(0,245,196,.2);padding:.3rem .7rem;border-radius:50px;color:var(--neon);font-size:.72rem;font-weight:700;">
                            ● LIVE
                        </div>
                    </div>

                    <div class="sms-box" style="margin-bottom:1rem;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:.8rem;">
                            <span style="font-size:.8rem;color:var(--muted);">Campaign</span>
                            <span style="font-size:.8rem;color:var(--neon);font-weight:700;">Eid Promo 2026</span>
                        </div>

                        <div style="height:8px;background:rgba(0,245,196,.1);border-radius:50px;overflow:hidden;">
                            <div
                                style="width:82%;height:100%;background:linear-gradient(90deg,var(--neon),var(--neon2));border-radius:50px;">
                            </div>
                        </div>

                        <div style="display:flex;justify-content:space-between;margin-top:.7rem;">
                            <span style="font-size:.75rem;color:var(--faint);">82% Delivered</span>
                            <span style="font-size:.75rem;color:var(--body);">820K / 1M</span>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                        <div class="sms-box">
                            <div style="font-size:2rem;">📩</div>
                            <div style="margin-top:.5rem;font-size:1.5rem;font-weight:800;">1.2M</div>
                            <div style="font-size:.8rem;color:var(--faint);">SMS Sent Today</div>
                        </div>

                        <div class="sms-box">
                            <div style="font-size:2rem;">✅</div>
                            <div style="margin-top:.5rem;font-size:1.5rem;font-weight:800;">99.4%</div>
                            <div style="font-size:.8rem;color:var(--faint);">Success Rate</div>
                        </div>

                    </div>

                    <div class="sms-box" style="margin-top:1rem;">
                        <div style="font-size:.8rem;color:var(--muted);margin-bottom:.7rem;">
                            Latest Activity
                        </div>

                        <div style="display:flex;flex-direction:column;gap:.8rem;">

                            <div style="display:flex;justify-content:space-between;">
                                <span>OTP SMS Delivered</span>
                                <span style="color:var(--neon);">2 sec ago</span>
                            </div>

                            <div style="display:flex;justify-content:space-between;">
                                <span>Marketing Campaign Started</span>
                                <span style="color:var(--neon2);">1 min ago</span>
                            </div>

                            <div style="display:flex;justify-content:space-between;">
                                <span>API Connected</span>
                                <span style="color:var(--neon3);">5 min ago</span>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- FEATURES -->
    <section style="padding:40px 1.5rem 80px;">

        <div style="max-width:1300px;margin:auto;">

            <div class="sec-label">Features</div>

            <div
                style="display:flex;justify-content:space-between;gap:2rem;align-items:end;flex-wrap:wrap;margin-bottom:2rem;">
                <div>
                    <h2 style="font-size:2.3rem;font-weight:800;">
                        Everything You Need
                    </h2>

                    <p style="color:var(--muted);margin-top:.7rem;max-width:600px;">
                        Enterprise ready messaging platform with powerful tools for modern businesses.
                    </p>
                </div>
            </div>

            <div class="feature-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;">

                <div class="feature-card fade">
                    <div style="font-size:2.5rem;margin-bottom:1rem;">⚡</div>
                    <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:.7rem;">
                        Instant Delivery
                    </h3>
                    <p style="color:var(--muted);line-height:1.7;">
                        Deliver OTP and transactional SMS instantly with ultra-fast routing.
                    </p>
                </div>

                <div class="feature-card fade">
                    <div style="font-size:2.5rem;margin-bottom:1rem;">📊</div>
                    <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:.7rem;">
                        Real-time Analytics
                    </h3>
                    <p style="color:var(--muted);line-height:1.7;">
                        Track delivery reports, clicks, responses, and campaign performance.
                    </p>
                </div>

                <div class="feature-card fade">
                    <div style="font-size:2.5rem;margin-bottom:1rem;">🔐</div>
                    <h3 style="font-size:1.2rem;font-weight:800;margin-bottom:.7rem;">
                        Secure API
                    </h3>
                    <p style="color:var(--muted);line-height:1.7;">
                        Easy to integrate REST API with high-level authentication & security.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <!-- PRICING -->
    <section style="padding:20px 1.5rem 90px;">

        <div style="max-width:1300px;margin:auto;">

            <div class="sec-label">Pricing</div>

            <h2 style="font-size:2.5rem;font-weight:800;margin-bottom:2rem;">
                Flexible SMS Packages
            </h2>

            <div class="pricing-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;">

                <!-- CARD -->
                <div class="pricing-card fade">
                    <div style="font-size:.8rem;color:var(--muted);margin-bottom:.7rem;">
                        Starter
                    </div>

                    <div class="price">৳0.25</div>

                    <div style="color:var(--faint);margin-bottom:1.4rem;">
                        Per SMS
                    </div>

                    <div style="display:flex;flex-direction:column;gap:.9rem;margin-bottom:2rem;">

                        <div>✔ 10,000 SMS</div>
                        <div>✔ API Access</div>
                        <div>✔ Delivery Reports</div>
                        <div>✔ Email Support</div>

                    </div>

                    <button class="btn-secondary" style="width:100%;">
                        Get Started
                    </button>
                </div>

                <!-- CARD -->
                <div class="pricing-card active fade">

                    <div
                        style="position:absolute;top:16px;right:16px;background:rgba(0,245,196,.12);border:1px solid rgba(0,245,196,.3);padding:.35rem .7rem;border-radius:50px;font-size:.72rem;font-weight:700;color:var(--neon);">
                        Popular
                    </div>

                    <div style="font-size:.8rem;color:var(--muted);margin-bottom:.7rem;">
                        Business
                    </div>

                    <div class="price hero-accent">৳0.18</div>

                    <div style="color:var(--faint);margin-bottom:1.4rem;">
                        Per SMS
                    </div>

                    <div style="display:flex;flex-direction:column;gap:.9rem;margin-bottom:2rem;">

                        <div>✔ Unlimited Campaigns</div>
                        <div>✔ Priority Route</div>
                        <div>✔ OTP Service</div>
                        <div>✔ Dedicated Support</div>

                    </div>

                    <button class="btn-primary" style="width:100%;">
                        Buy Package
                    </button>
                </div>

                <!-- CARD -->
                <div class="pricing-card fade">
                    <div style="font-size:.8rem;color:var(--muted);margin-bottom:.7rem;">
                        Enterprise
                    </div>

                    <div class="price">Custom</div>

                    <div style="color:var(--faint);margin-bottom:1.4rem;">
                        Contact Sales
                    </div>

                    <div style="display:flex;flex-direction:column;gap:.9rem;margin-bottom:2rem;">

                        <div>✔ Dedicated Gateway</div>
                        <div>✔ White Label</div>
                        <div>✔ SLA Guarantee</div>
                        <div>✔ 24/7 Support</div>

                    </div>

                    <button class="btn-secondary" style="width:100%;">
                        Contact Us
                    </button>
                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->
    <section style="padding:0 1.5rem 100px;">

        <div style="max-width:1300px;margin:auto;">

            <div
                style="background:linear-gradient(135deg,rgba(123,47,255,.14),rgba(0,245,196,.08));border:1px solid rgba(0,245,196,.2);border-radius:32px;padding:4rem 2rem;text-align:center;position:relative;overflow:hidden;">

                <div class="orb"
                    style="width:260px;height:260px;background:rgba(123,47,255,.2);top:-100px;right:-80px;"></div>

                <h2 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;margin-bottom:1rem;">
                    Ready to Scale Your SMS Campaigns?
                </h2>

                <p style="max-width:700px;margin:auto;color:var(--muted);line-height:1.8;margin-bottom:2rem;">
                    Join thousands of businesses using NXT SMS platform for marketing,
                    OTP verification, and customer communication.
                </p>

                <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
                    <button class="btn-primary">
                        Create Free Account
                    </button>

                    <button class="btn-secondary">
                        Contact Sales
                    </button>
                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    <footer style="border-top:1px solid var(--border);padding:2rem 1.5rem;background:rgba(6,9,16,.95);">

        <div
            style="max-width:1300px;margin:auto;display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap;align-items:center;">

            <div>
                <div style="font-weight:800;font-size:1rem;">
                    NXT <span class="hero-accent">SMS</span>
                </div>

                <div style="font-size:.8rem;color:var(--faint);margin-top:.3rem;">
                    Enterprise Bulk SMS Solution
                </div>
            </div>

            <div style="font-size:.8rem;color:var(--faint);">
                © 2026 NXT SMS Platform · Built in Bangladesh 🇧🇩
            </div>

        </div>

    </footer>

    <script>
        // THEME
        function toggleTheme() {
            document.documentElement.classList.toggle('light');

            const isLight = document.documentElement.classList.contains('light');

            localStorage.setItem('nxt_sms_theme', isLight ? 'light' : 'dark');
        }

        // LOAD THEME
        window.addEventListener('DOMContentLoaded', () => {

            if (localStorage.getItem('nxt_sms_theme') === 'light') {
                document.documentElement.classList.add('light');
            }

            document.querySelectorAll('.fade').forEach((el, i) => {
                setTimeout(() => {
                    el.classList.add('show');
                }, i * 120);
            });

        });
    </script>

</body>

</html>
<?php /**PATH D:\Rayhan\Development\gamehub-cms-bkash\resources\views/new.blade.php ENDPATH**/ ?>