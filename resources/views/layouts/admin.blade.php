{{--<!DOCTYPE html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Admin Panel</title>--}}
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
{{--</head>--}}
{{--<body>--}}

{{--    <!-- Navbar -->--}}
{{--    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">--}}
{{--        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>--}}
{{--        <div class="ml-auto">--}}
{{--            <ul class="navbar-nav">--}}
{{--                <li class="nav-item dropdown">--}}
{{--                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">--}}
{{--                        {{ Auth::user()->name }}--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-menu">--}}
{{--                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Edit Profile</a>--}}
{{--                        <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
{{--                            Logout--}}
{{--                        </a>--}}
{{--                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                            @csrf--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </nav>--}}

{{--    <!-- Sidebar + Content -->--}}
{{--    <div class="d-flex">--}}
{{--        <div class="bg-light border-right vh-100 p-3">--}}
{{--            <h4>Menu</h4>--}}
{{--            <ul class="list-unstyled">--}}
{{--                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>--}}
{{--                <li><a href="{{ route('admin.profile.edit') }}">Edit Profile</a></li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--        <div class="container-fluid p-3">--}}
{{--            @yield('content')--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <script src="{{ asset('js/app.js') }}"></script>--}}
{{--</body>--}}
{{--</html>--}}
