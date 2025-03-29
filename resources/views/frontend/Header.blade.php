<nav class="navbar navbar-expand-lg bg-gradient-to-r from-green-400 to-blue-500 shadow-lg fixed-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand text-white font-bold text-xl" href="{{ url('/') }}">SoundSystem</a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Search Bar -->
                <li class="nav-item me-3">
                    <form class="d-flex" action="{{ url('/search') }}" method="GET">
                        <input class="form-control rounded-full px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500" type="search" name="query" placeholder="Search products..." required>
                        <button class="btn bg-black text-white rounded-full px-4 py-2 ml-2 transition hover:bg-teal-700" type="submit">Search</button>
                    </form>
                </li>

                <!-- Cart Icon -->
                <li class="nav-item me-3">
                    <a class="nav-link text-white font-semibold position-relative" href="{{ url('/cart') }}">
                        🛒 Cart <span id="cart-count" class="badge bg-red-600 text-white rounded-full">{{ $cartCount }}</span>
                    </a>
                </li>

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white font-semibold hover:text-teal-300" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white font-semibold hover:text-teal-300" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white font-semibold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-white shadow-lg rounded-md">
                            <li><a class="dropdown-item text-teal-700" href="{{ url('/profile') }}">Profile</a></li>
                            <li><a class="dropdown-item text-teal-700" href="{{ url('/orders') }}">Orders</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-red-600" type="submit">Logout</button>
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
    .navbar {
        padding: 1rem 2rem;
        background: linear-gradient(to right, #38b2ac, #4299e1);
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .btn:hover {
        background-color: #2c7a7b;
    }

    .dropdown-menu {
        min-width: 150px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item:hover {
        background-color: #edf2f7;
    }
</style>
