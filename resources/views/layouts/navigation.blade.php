<style>
    /* Set default color */
    .profile-icon, .nav-profile-name {
        color: black; /* Default color */
    }

    /* On hover or click, change to green */
    .nav-profile-name:hover, .profile-icon:hover, .nav-profile-name.clicked, .profile-icon.clicked {
        color: rgb(0, 128, 0); /* Green color on hover or click */
    }

    /* Link styling on hover */
    .profile-link:hover {
        color: rgb(0, 128, 0);
    }
</style>


<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">SoundSystem</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <div class="d-flex align-items-center">
                        @if (auth()->check())
                            <!-- Display User Icon -->
                            <i class="bi bi-person rounded-circle profile-icon" style="font-size: 20px; margin-right: 8px;"></i>
                            <!-- Display Vendor Name -->
                            <span class="ms-2 nav-profile-name" id="vendorName">{{ auth()->user()->name }}</span>
                        @else
                            <!-- Default when not logged in -->
                            <i class="bi bi-person profile-icon" style="font-size: 30px;"></i>
                        @endif
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                    style="min-width: 240px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <li class="dropdown-header" style="padding: 16px 20px; background-color: #f8f9fa; border-radius: 10px 10px 0 0;">
                        @if (auth()->check())
                            <h6 class="mb-0" style="font-size: 16px; font-weight: 600; color: black;">
                                {{ auth()->user()->name }}</h6>
                        @else
                            <h6 class="mb-0" style="font-size: 16px; font-weight: 600; color: rgb(0, 128, 0);">Guest</h6>
                        @endif
                    </li>
                    <li><hr class="dropdown-divider" style="margin: 0;"></li>

                    @if (auth()->check())
                        <li>
                            <a class="dropdown-item d-flex align-items-center profile-link" href="#">
                                <i class="bi bi-person" style="font-size: 18px; margin-right: 10px;"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" style="margin: 0;"></li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center profile-link" href="#">
                                <i class="bi bi-gear" style="font-size: 18px; margin-right: 10px;"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider" style="margin: 0;"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center profile-link">
                                    <i class="bi bi-box-arrow-right" style="font-size: 18px; margin-right: 10px;"></i>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item d-flex align-items-center profile-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right" style="font-size: 18px; margin-right: 10px;"></i>
                                <span>Login</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const vendorName = document.querySelector('#vendorName'); // Target the vendor name span by ID

        if (vendorName) {
            vendorName.addEventListener('click', function() {
                this.classList.toggle('clicked'); // Toggle the 'clicked' class on click
            });
        }
    });
</script>
