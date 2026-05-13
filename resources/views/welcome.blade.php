<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Airport Parking Management</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            margin: 0;
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: #ffffff;
            min-height: 100vh;
        }

        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            width: 100%;
            padding: 24px 8%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-sizing: border-box;
        }

        .logo {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .login-btn {
            background: #ffffff;
            color: #1e3a8a;
            padding: 10px 22px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .login-btn:hover {
            background: #dbeafe;
            transform: translateY(-1px);
        }

        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 40px 8%;
            gap: 50px;
            box-sizing: border-box;
        }

        .hero-content {
            max-width: 620px;
        }

        .badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 56px;
            line-height: 1.05;
            margin: 0 0 20px;
            font-weight: 700;
        }

        .hero-text {
            font-size: 18px;
            line-height: 1.7;
            color: #dbeafe;
            margin-bottom: 32px;
        }

        .buttons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .primary-btn,
        .secondary-btn {
            padding: 14px 26px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .primary-btn {
            background: #38bdf8;
            color: #082f49;
        }

        .primary-btn:hover {
            background: #7dd3fc;
            transform: translateY(-2px);
        }

        .secondary-btn {
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #ffffff;
        }

        .secondary-btn:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .hero-card {
            width: 360px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 26px;
            padding: 30px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.25);
        }

        .plane-icon {
            font-size: 58px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .card-text {
            color: #dbeafe;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .features {
            display: grid;
            gap: 14px;
        }

        .feature {
            background: rgba(255, 255, 255, 0.12);
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 15px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #bfdbfe;
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 30px;
            }

            h1 {
                font-size: 40px;
            }

            .buttons {
                justify-content: center;
            }

            .hero-card {
                width: 100%;
                max-width: 380px;
            }
        }
    </style>
</head>

<body>
    <div class="page">

        <header class="navbar">
            <div class="logo">
                Airport Parking
            </div>

            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="login-btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                @endauth
            @endif
        </header>

        <main class="hero">
            <section class="hero-content">
                <div class="badge">
                    Smart Airport Parking Management
                </div>

                <h1>
                    Manage airport parking entries and returns with ease.
                </h1>

                <p class="hero-text">
                    A simple and reliable system for tracking parking entries, vehicle returns,
                    customer records, and operational updates in one secure place.
                </p>

                <div class="buttons">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="primary-btn">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="primary-btn">Login to System</a>
                        @endauth
                    @endif

                    <a href="#features" class="secondary-btn">View Features</a>
                </div>
            </section>

            <section class="hero-card" id="features">
                <div class="plane-icon">✈️</div>

                <div class="card-title">
                    Parking Operations
                </div>

                <p class="card-text">
                    Keep your airport parking workflow organised from check-in to vehicle return.
                </p>

                <div class="features">
                    <div class="feature">🚗 Track vehicle entries</div>
                    <div class="feature">🔁 Manage vehicle returns</div>
                    <div class="feature">📊 View live records</div>
                    <div class="feature">🔐 Secure staff login</div>
                </div>
            </section>
        </main>

        <footer class="footer">
            © {{ date('Y') }} Airport Parking Management System. All rights reserved.
        </footer>

    </div>
</body>
</html>php a