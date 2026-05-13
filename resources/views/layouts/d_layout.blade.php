<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background-color: #FDFDFC;
                color: #1b1b18;
                display: flex;
                min-height: 100vh;
            }
            
            body.dark {
                background-color: #0a0a0a;
                color: #EDEDEC;
            }

            /* Sidebar */
            .sidebar {
                width: 250px;
                background-color: #1b1b18;
                color: white;
                padding: 2rem 0;
                position: fixed;
                height: 100vh;
                overflow-y: auto;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            }

            body.dark .sidebar {
                background-color: #161615;
            }

            .sidebar-brand {
                padding: 0 1.5rem 2rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                margin-bottom: 2rem;
            }

            .sidebar-brand h2 {
                font-size: 1.5rem;
                font-weight: 600;
            }

            .sidebar-menu {
                list-style: none;
            }

            .sidebar-menu li {
                margin: 0;
            }

            .sidebar-menu a {
                display: block;
                padding: 0.75rem 1.5rem;
                color: rgba(255, 255, 255, 0.7);
                text-decoration: none;
                transition: all 0.3s ease;
                border-left: 3px solid transparent;
            }

            .sidebar-menu a:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: white;
                border-left-color: white;
            }

            .sidebar-menu a.active {
                background-color: rgba(255, 255, 255, 0.1);
                color: white;
                border-left-color: white;
            }

            /* Main Content */
            .main-wrapper {
                margin-left: 250px;
                display: flex;
                flex-direction: column;
                width: calc(100% - 250px);
                min-height: 100vh;
            }

            /* Header */
            .header {
                background-color: white;
                border-bottom: 1px solid #e3e3e0;
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            body.dark .header {
                background-color: #161615;
                border-bottom-color: #3E3E3A;
            }

            .header h1 {
                font-size: 1.5rem;
                font-weight: 600;
            }

            .header-actions {
                display: flex;
                align-items: center;
                gap: 1.5rem;
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: #1b1b18;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
            }

            body.dark .user-avatar {
                background-color: white;
                color: #1b1b18;
            }

            .logout-btn {
                padding: 0.5rem 1rem;
                background-color: #1b1b18;
                color: white;
                border: none;
                border-radius: 0.375rem;
                cursor: pointer;
                font-weight: 500;
                transition: background-color 0.3s ease;
                text-decoration: none;
                display: inline-block;
            }

            .logout-btn:hover {
                background-color: #0a0a0a;
            }

            body.dark .logout-btn {
                background-color: white;
                color: #1b1b18;
            }

            body.dark .logout-btn:hover {
                background-color: #f0f0f0;
            }

            /* Content Area */
            .content {
                flex: 1;
                padding: 2rem;
                overflow-y: auto;
            }

            /* Footer */
            .footer {
                background-color: white;
                border-top: 1px solid #e3e3e0;
                padding: 1.5rem 2rem;
                text-align: center;
                color: #706f6c;
                font-size: 0.875rem;
            }

            body.dark .footer {
                background-color: #161615;
                border-top-color: #3E3E3A;
                color: #A1A09A;
            }

            /* Scrollbar styling */
            .sidebar::-webkit-scrollbar {
                width: 6px;
            }

            .sidebar::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1);
            }

            .sidebar::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 3px;
            }

            .sidebar::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 255, 255, 0.5);
            }

            /* Dark mode toggle */
            .theme-toggle {
                background: none;
                border: none;
                cursor: pointer;
                font-size: 1.5rem;
                color: #1b1b18;
            }

            body.dark .theme-toggle {
                color: #EDEDEC;
            }
        </style>
    @endif
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h2>🅿️ ParkHub</h2>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="@if(request()->routeIs('dashboard')) active @endif">
                    📊 Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('check_flights') }}" class="@if(request()->routeIs('check_flights')) active @endif">
                    ✈️ Check Flights
                </a>
            </li>
            <li>
                <a href="{{ route('all_airport_parking_prices') }}" class="@if(request()->routeIs('all_airport_parking_prices')) active @endif">
                    ✈️ Airport Prices
                </a>
            </li>
            <li>
                <a href="{{ route('clients.index') }}" class="@if(request()->routeIs('clients.*') || request()->is('admin/clients*')) active @endif">
                    🔑 Clients
                </a>
            </li>
            <li>
                <a href="{{ route('licenses.index') }}" class="@if(request()->routeIs('licenses.*') || request()->is('admin/licenses*')) active @endif">
                    🔐 Offline Generator
                </a>
            </li>
            <li>
                <a href="#" class="@if(request()->routeIs('profile')) active @endif">
                    👤 Profile
                </a>
            </li>
            <li>
                <a href="#" class="@if(request()->routeIs('settings')) active @endif">
                    ⚙️ Settings
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <header class="header">
            <h1>@yield('page_title', 'Dashboard')</h1>
            
            <div class="header-actions">
                <button class="theme-toggle" onclick="toggleDarkMode()">🌙</button>
                
                <div class="user-info">
                    <div>
                        <div style="font-weight: 600;">{{ auth()->user()->name }}</div>
                        <div style="font-size: 0.875rem; color: #706f6c;">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; 2026 ParkHub. All rights reserved. | Car Parking Management System</p>
        </footer>
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark');
            localStorage.setItem('darkMode', document.body.classList.contains('dark'));
        }

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark');
        }
    </script>
</body>
</html>
