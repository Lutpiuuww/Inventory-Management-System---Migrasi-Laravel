<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory Manager')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Load FontAwesome via CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body data-theme="light">
    <div class="container">
        @auth
        <header>
            <div class="logo">
                <h1>Inventory Manager</h1>
            </div>
            <div class="header-actions">
                <a href="{{ route('products.index') }}" class="btn"><i class="fa fa-box"></i> Products</a>
                <a href="{{ route('stock-movements.index') }}" class="btn"><i class="fa fa-exchange-alt"></i> Stock Movements</a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('categories.index') }}" class="btn"><i class="fa fa-tags"></i> Categories</a>
                    <a href="{{ route('suppliers.index') }}" class="btn"><i class="fa fa-truck"></i> Suppliers</a>
                @endif
                <button class="theme-toggle" id="theme-toggle" title="Toggle Theme">
                    <i class="fa fa-moon"></i>
                </button>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </header>
        @endauth

        <main>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>

        <footer style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.875rem; text-align: center; padding-bottom: 40px;">
            <p>&copy; {{ date('Y') }} Inventory Manager Pro. All rights reserved.</p>
        </footer>
    </div>

    <script>
        const toggleBtn = document.getElementById('theme-toggle');
        const body = document.body;
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const current = body.getAttribute('data-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                body.setAttribute('data-theme', next);
                toggleBtn.innerHTML = next === 'dark' ? '<i class="fa fa-sun"></i>' : '<i class="fa fa-moon"></i>';
                localStorage.setItem('theme', next);
            });

            // Init theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                body.setAttribute('data-theme', savedTheme);
                toggleBtn.innerHTML = savedTheme === 'dark' ? '<i class="fa fa-sun"></i>' : '<i class="fa fa-moon"></i>';
            }
        }
    </script>
</body>
</html>
