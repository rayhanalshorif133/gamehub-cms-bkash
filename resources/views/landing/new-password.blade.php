<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WEB | Bkash Game Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;700&family=Poppins:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', 'Noto Sans Bengali', sans-serif;
        }

        .game-card-container {
            background: #fff;
            border-radius: 20px;
            padding: 30px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 450px;
            margin: 50px auto;
        }

        .logo-section img {
            width: 120px;
            margin-bottom: 20px;
        }

        .input-group-custom {
            display: flex;
            align-items: center;
            border: 1px solid #ced4da;
            border-radius: 10px;
            margin-bottom: 15px;
            background: #fff;
            overflow: hidden;
            transition: border-color 0.3s;
        }

        .input-group-custom:focus-within {
            border-color: #e2136e;
        }

        .input-group-custom span {
            padding: 12px 15px;
            background: #f8f9fa;
            color: #6c757d;
            border-right: 1px solid #ced4da;
        }

        .input-group-custom input {
            border: none;
            padding: 12px;
            width: 100%;
            outline: none;
            font-size: 0.95rem;
        }

        .btn-submit {
            background: #e2136e;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: #c1105d;
            color: #fff;
        }

        .footer-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 20px;
        }

        .section-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

    <main class="container">
        <div class="game-card-container animate__animated animate__fadeIn">
            <div class="logo-section">
                <img src="{{ asset('/images/logo.png') }}" alt="BDGamers Logo">
            </div>

            <h2 class="section-title">Login to Account</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('player.register') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="reg_type" value="new_player">
                <div class="text-start">
                    <label class="small fw-bold mb-1 ms-1">Mobile Number</label>
                    <div class="input-group-custom">
                        <span><i class="fas fa-phone-alt"></i></span>
                        <input type="number" readonly id="msisdn" value="{{ $msisdn }}" name="phone"
                            placeholder="01XXXXXXXXX" required>
                    </div>
                </div>

                <div class="text-start">
                    <label class="small fw-bold mb-1 ms-1">Password</label>
                    <div class="input-group-custom">
                        <span><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            required>
                    </div>
                    <small class="text-muted ms-1" style="font-size: 12px;">
                        Press <b style="color: #e2136e">Login Button</b> after typing your password to login.
                    </small>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt me-2"></i> Login Now
                </button>
            </form>

            <div class="footer-text">
                <p class="small">By submitting, you agree to our Terms & Conditions.</p>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- axios --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                const msisdn = $('#msisdn').val();
                const password = $('#password').val();

                if (msisdn.length < 11) {
                    alert("Please enter a valid 11-digit mobile number.");
                    return;
                }

            });
        });
    </script>
</body>

</html>
