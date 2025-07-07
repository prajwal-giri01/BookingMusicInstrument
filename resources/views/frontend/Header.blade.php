<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ url('/') }}">
            <span class="brand-icon"><i class="bi bi-music-note-beamed"></i></span>
            <span class="brand-text">Sound System</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Navigation Links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('custom-packages.index') }}">Custom Packages</a>
                </li>
                @endauth
                <!-- Search Bar -->
                <li class="nav-item search-item">
                    <form class="search-form" action="{{ url('/search') }}" method="GET">
                        <div class="search-wrapper">
                            <input class="search-input" type="search" name="query" placeholder="Find instruments..." required>
                            <button class="search-button" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </li>

                <!-- Cart Icon -->
                <li class="nav-item">
                    <a class="nav-link cart-link" href="{{ url('/cart') }}">
                        <i class="bi bi-cart3"></i>
                        <span id="cart-count" class="cart-badge">{{ $cartCount ?? 0 }}</span>
                    </a>
                </li>

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary sign-up-btn" href="{{ route('register') }}">Sign Up</a>
                    </li>
                @else
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-dropdown" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <span class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">
                                    <i class="bi bi-person"></i> Profile
                                </a></li>
                            <li><a class="dropdown-item" href="{{ url('/orders') }}">
                                    <i class="bi bi-bag"></i> My Rentals
                                </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item logout-btn" type="submit">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Header Styling */
    .navbar {
        background-color: #1A1A2E;
        padding: 0.75rem 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .navbar.scrolled {
        padding: 0.5rem 0;
        background-color: rgba(26, 26, 46, 0.98);
        backdrop-filter: blur(10px);
    }

    /* Brand/Logo */
    .navbar-brand {
        display: flex;
        align-items: center;
        color: #fff;
        font-weight: 700;
        font-size: 1.5rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        color: #C7B299;
    }

    .brand-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background-color: #C7B299;
        color: #1A1A2E;
        border-radius: 50%;
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .brand-text {
        background: linear-gradient(90deg, #C7B299, #E6CCB2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Navigation Links */
    .navbar-nav .nav-item {
        margin: 0 0.25rem;
    }

    .navbar-nav .nav-link {
        color: #E6E6E6;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .navbar-nav .nav-link:hover {
        color: #C7B299;
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: #C7B299;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .navbar-nav .nav-link:hover::after {
        width: 70%;
    }

    /* Search Bar */
    .search-item {
        margin: 0 0.5rem;
    }

    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border-radius: 50px;
        width: 200px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        width: 250px;
        background-color: rgba(255, 255, 255, 0.15);
        border-color: #C7B299;
        outline: none;
        box-shadow: 0 0 0 2px rgba(199, 178, 153, 0.25);
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .search-button {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-input:focus + .search-button,
    .search-button:hover {
        color: #C7B299;
    }

    /* Cart */
    .cart-link {
        position: relative;
        font-size: 1.2rem;
        padding: 0.5rem;
        margin: 0 0.5rem;
    }

    .cart-badge {
        position: absolute;
        top: 0;
        right: 0;
        background-color: #C7B299;
        color: #1A1A2E;
        font-size: 0.7rem;
        font-weight: 700;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transform: translate(50%, -30%);
    }

    /* Sign Up Button */
    .sign-up-btn {
        background-color: #C7B299;
        border: none;
        color: #1A1A2E;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .sign-up-btn:hover {
        background-color: #E6CCB2;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(199, 178, 153, 0.3);
    }

    /* User Dropdown */
    .user-dropdown {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
    }

    .user-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background-color: #C7B299;
        color: #1A1A2E;
        border-radius: 50%;
        font-weight: 600;
        margin-right: 8px;
    }

    .user-name {
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        background-color: #fff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        padding: 0.75rem 0;
        margin-top: 0.75rem;
        min-width: 200px;
    }

    .dropdown-item {
        color: #333;
        padding: 0.6rem 1.25rem;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .dropdown-item i {
        margin-right: 10px;
        font-size: 1rem;
        color: #666;
    }

    .dropdown-item:hover {
        background-color: #f8f5f2;
        color: #1A1A2E;
    }

    .dropdown-item:hover i {
        color: #C7B299;
    }

    .dropdown-divider {
        margin: 0.5rem 0;
        border-top: 1px solid #eee;
    }

    .logout-btn {
        color: #E53E3E;
    }

    .logout-btn:hover {
        background-color: rgba(229, 62, 62, 0.1);
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background-color: #1A1A2E;
            padding: 1rem;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .navbar-nav .nav-item {
            margin: 0.5rem 0;
        }

        .search-item {
            margin: 0.75rem 0;
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .search-input:focus {
            width: 100%;
        }

        .user-dropdown {
            justify-content: flex-start;
        }
    }

    /* Add this script to your JS file */
    document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
    navbar.classList.add('scrolled');
    } else {
          navbar.classList.remove('scrolled');
      }
    });
    });
</style>
