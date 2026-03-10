<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background-color: #FDFDFC;
            }
            body.dark {
                background-color: #0a0a0a;
                color: #EDEDEC;
            }
            .form-container {
                max-width: 400px;
                margin: 0 auto;
                padding: 2rem;
                background: white;
                border-radius: 0.375rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            }
            body.dark .form-container {
                background: #161615;
            }
            .form-group {
                margin-bottom: 1.5rem;
            }
            label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: 500;
                color: #1b1b18;
            }
            body.dark label {
                color: #EDEDEC;
            }
            input[type="email"],
            input[type="password"] {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #e3e3e0;
                border-radius: 0.375rem;
                font-size: 1rem;
                color: #1b1b18;
                background-color: white;
            }
            body.dark input[type="email"],
            body.dark input[type="password"] {
                background-color: #0a0a0a;
                border-color: #3E3E3A;
                color: #EDEDEC;
            }
            input[type="email"]:focus,
            input[type="password"]:focus {
                outline: none;
                border-color: #1b1b18;
                box-shadow: 0 0 0 2px rgba(27, 27, 24, 0.1);
            }
            body.dark input[type="email"]:focus,
            body.dark input[type="password"]:focus {
                border-color: white;
                box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
            }
            button {
                width: 100%;
                padding: 0.75rem;
                background-color: #1b1b18;
                color: white;
                border: none;
                border-radius: 0.375rem;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.15s;
            }
            body.dark button {
                background-color: white;
                color: #1b1b18;
            }
            button:hover {
                background-color: #0a0a0a;
            }
            body.dark button:hover {
                background-color: #f0f0f0;
            }
            .error-message {
                color: #f53003;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
            .header {
                text-align: center;
                margin-bottom: 2rem;
            }
            .header h1 {
                margin: 0;
                font-size: 1.875rem;
                color: #1b1b18;
            }
            body.dark .header h1 {
                color: #EDEDEC;
            }
            .footer-text {
                text-align: center;
                color: #706f6c;
                font-size: 0.875rem;
                margin-top: 1.5rem;
            }
            body.dark .footer-text {
                color: #A1A09A;
            }
            .footer-text a {
                color: #1b1b18;
                text-decoration: none;
            }
            body.dark .footer-text a {
                color: #EDEDEC;
            }
            .footer-text a:hover {
                text-decoration: underline;
            }
            .alert {
                padding: 0.75rem 1rem;
                border-radius: 0.375rem;
                margin-bottom: 1.5rem;
                font-size: 0.875rem;
            }
            .alert-danger {
                background-color: #fff2f2;
                color: #f53003;
                border: 1px solid #f5300333;
            }
            body.dark .alert-danger {
                background-color: #1d0002;
                border-color: #f5300366;
            }
        </style>
    @endif
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1.5rem;">
        <form method="POST" action="{{ route('login.store') }}" class="form-container" style="width: 100%; max-width: 400px;">
            @csrf

            <div class="header">
                <h1>Login</h1>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @if ($errors->has('email'))
                        {{ $errors->first('email') }}
                    @else
                        {{ $errors->first() }}
                    @endif
                </div>
            @endif

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="admin@example.com"
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    placeholder="••••••••"
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Sign In</button>

            <div class="footer-text">
                {{-- Don't have an account? <a href="{{ route('register') }}">Register here</a> --}}
            </div>
        </form>
    </div>
</body>
</html>
