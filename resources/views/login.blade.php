<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - POSSYHRUL</title>

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        :root {
            --bg-dark: #0c0a09;
            --card-bg: #1c1917;
            --input-bg: #0c0a09;

            --border: rgba(245, 158, 11, 0.25);

            --yellow: #f59e0b;
            --yellow-hover: #d97706;

            --white: #ffffff;
            --muted: #94a3b8;

            --danger-bg: rgba(239, 68, 68, 0.12);
            --danger-border: rgba(239, 68, 68, 0.35);
            --danger-text: #fca5a5;

            --success-bg: rgba(34, 197, 94, 0.12);
            --success-border: rgba(34, 197, 94, 0.35);
            --success-text: #86efac;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background:
                radial-gradient(
                    circle at top,
                    rgba(245, 158, 11, 0.08),
                    transparent 40%
                ),
                var(--bg-dark);

            color: var(--white);

            font-family:
                'Plus Jakarta Sans',
                system-ui,
                sans-serif;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0;
            padding: 20px;
        }

        .login-card {

            width: 100%;
            max-width: 440px;

            background: var(--card-bg);

            border: 1px solid var(--border);

            border-radius: 24px;

            padding: 40px 32px;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.65);

            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {

            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Brand
        |--------------------------------------------------------------------------
        */

        .brand-logo {

            width: 64px;
            height: 64px;

            background: var(--yellow);

            color: #000;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin: 0 auto 18px;

            font-size: 32px;

            box-shadow:
                0 10px 30px rgba(245, 158, 11, 0.25);
        }

        .brand-title {

            font-size: 26px;

            font-weight: 800;

            letter-spacing: -0.8px;

            color: white;

            margin-bottom: 6px;
        }

        .brand-title span {
            color: var(--yellow);
        }

        .brand-description {

            color: var(--muted);

            font-size: 13px;

            margin-bottom: 30px;
        }

        /*
        |--------------------------------------------------------------------------
        | Alert
        |--------------------------------------------------------------------------
        */

        .alert-custom {

            border-radius: 12px;

            padding: 14px 16px;

            font-size: 13px;

            margin-bottom: 22px;
        }

        .alert-danger-custom {

            background: var(--danger-bg);

            border: 1px solid var(--danger-border);

            color: var(--danger-text);
        }

        .alert-success-custom {

            background: var(--success-bg);

            border: 1px solid var(--success-border);

            color: var(--success-text);
        }

        /*
        |--------------------------------------------------------------------------
        | Form
        |--------------------------------------------------------------------------
        */

        .form-label-custom {

            display: block;

            color: #f8fafc;

            font-size: 13px;

            font-weight: 600;

            margin-bottom: 8px;
        }

        .input-group-custom {

            background: var(--input-bg);

            border: 1px solid var(--border);

            border-radius: 13px;

            overflow: hidden;

            transition: 0.2s ease;
        }

        .input-group-custom:focus-within {

            border-color: var(--yellow);

            box-shadow:
                0 0 0 3px rgba(245, 158, 11, 0.15);
        }

        .input-group-text-custom {

            background: transparent;

            border: none;

            color: var(--yellow);

            padding-left: 16px;

            padding-right: 8px;
        }

        .form-control-custom {

            background: transparent !important;

            border: none !important;

            outline: none !important;

            box-shadow: none !important;

            color: white !important;

            padding: 13px 16px 13px 6px;

            font-size: 14px;
        }

        .form-control-custom::placeholder {
            color: #64748b;
        }

        /*
        |--------------------------------------------------------------------------
        | Login Button
        |--------------------------------------------------------------------------
        */

        .btn-yellow-login {

            width: 100%;

            background: var(--yellow);

            color: #000;

            border: none;

            border-radius: 13px;

            padding: 14px;

            font-size: 15px;

            font-weight: 700;

            transition: 0.2s ease;

            box-shadow:
                0 8px 25px rgba(245, 158, 11, 0.2);
        }

        .btn-yellow-login:hover {

            background: var(--yellow-hover);

            color: #000;

            transform: translateY(-1px);

            box-shadow:
                0 12px 30px rgba(245, 158, 11, 0.3);
        }

        .btn-yellow-login:active {
            transform: translateY(0);
        }

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        .login-footer {

            border-top: 1px solid rgba(255, 255, 255, 0.08);

            margin-top: 28px;

            padding-top: 18px;

            text-align: center;
        }

        .login-footer small {
            color: #64748b;
            font-size: 11px;
        }

        /*
        |--------------------------------------------------------------------------
        | Mobile
        |--------------------------------------------------------------------------
        */

        @media (max-width: 480px) {

            body {
                padding: 15px;
            }

            .login-card {
                padding: 32px 22px;
                border-radius: 20px;
            }

            .brand-title {
                font-size: 23px;
            }
        }

    </style>

</head>


<body>

    <div class="login-card">

        {{-- BRAND --}}
        <div class="text-center">

            <div class="brand-logo">
                <i class="bi bi-box-seam-fill"></i>
            </div>

            <h1 class="brand-title">
                POS<span>SYHRUL</span>
            </h1>

            <p class="brand-description">
                Masukkan kredensial untuk mengakses sistem
            </p>

        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))

            <div class="alert-custom alert-success-custom">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        {{-- ERROR MESSAGE --}}
        @if ($errors->any())

            <div class="alert-custom alert-danger-custom">

                <div class="fw-bold mb-2">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    Login gagal
                </div>

                <ul class="mb-0 ps-3">

                    @foreach ($errors->all() as $error)

                        <li class="login-error-message">
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM LOGIN --}}
        <form
            method="POST"
            action="{{ route('login.process') }}"
        >

            @csrf


            {{-- EMAIL --}}
            <div class="mb-3">

                <label
                    for="email"
                    class="form-label-custom"
                >
                    Email Address
                </label>

                <div class="input-group input-group-custom">

                    <span class="input-group-text input-group-text-custom">

                        <i class="bi bi-envelope-fill"></i>

                    </span>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control form-control-custom"
                        placeholder="admin@gmail.com"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        autofocus
                    >

                </div>

            </div>


            {{-- PASSWORD --}}
            <div class="mb-4">

                <label
                    for="password"
                    class="form-label-custom"
                >
                    Password
                </label>

                <div class="input-group input-group-custom">

                    <span class="input-group-text input-group-text-custom">

                        <i class="bi bi-lock-fill"></i>

                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control form-control-custom"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >

                </div>

            </div>


            {{-- LOGIN BUTTON --}}
            <button
                type="submit"
                class="btn btn-yellow-login d-flex align-items-center justify-content-center gap-2"
            >

                <span>
                    Sign In
                </span>

                <i class="bi bi-arrow-right-short fs-4"></i>

            </button>

        </form>


        {{-- FOOTER --}}
        <div class="login-footer">

            <small>
                &copy; {{ date('Y') }}
                POSSYHRUL Point of Sale System.
            </small>

        </div>

    </div>


    {{-- Bootstrap JS --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>
    <script>
        const lockoutMessage = document.querySelector('.login-error-message');
        const loginButton = document.querySelector('button[type="submit"]');

        if (lockoutMessage) {
            const lockoutPattern = /(\d+) detik/;
            const match = lockoutMessage.textContent.match(lockoutPattern);

            if (match) {
                let secondsLeft = Number(match[1]);
                loginButton.disabled = true;

                const countdown = setInterval(() => {
                    secondsLeft -= 1;

                    if (secondsLeft <= 0) {
                        clearInterval(countdown);
                        lockoutMessage.textContent = 'Waktu blokir sudah habis. Silakan coba login kembali.';
                        loginButton.disabled = false;
                        return;
                    }

                    lockoutMessage.textContent = `Tiga kali percobaan gagal. Login diblokir selama ${secondsLeft} detik.`;
                }, 1000);
            }
        }
    </script>

</body>

</html>