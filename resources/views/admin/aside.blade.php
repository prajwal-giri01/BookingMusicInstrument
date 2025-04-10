<aside id="sidebar" class="sidebar bg-light shadow-sm">
    <ul class="sidebar-nav list-unstyled" id="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-speedometer2"></i>
                <span class="link-text">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.sliders.index') }}" aria-label="Slider Image">
                <i class="bi bi-file-earmark-text"></i>
                <span class="link-text">Slider Image</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.category.index') }}" >
                <i class="bi bi-file-earmark-text"></i>
                <span class="link-text">Category</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.instruments.index')}}">
                <i class="bi bi-file-earmark-music"></i>
                <span class="link-text">Instruments</span>
            </a>
        </li>
        <!-- Bookings -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.booking.index')}}">
                <i class="bi bi-file-earmark-music"></i>
                <span class="link-text">Bookings</span>
            </a>
        </li>
    </ul>
</aside>

<!-- Toggle Button for Sidebar -->
<button id="sidebar-toggle" class="btn btn-primary">Toggle Sidebar</button>

<!-- JavaScript for Sidebar Toggle and Active Link -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById("sidebar");
        const sidebarToggle = document.getElementById("sidebar-toggle");
        const sidebarLinks = document.querySelectorAll(".sidebar-nav .nav-link");

        // Toggle sidebar visibility
        sidebarToggle.addEventListener("click", function() {
            sidebar.classList.toggle("collapsed");
        });

        // Add active class to clicked link and remove from others
        sidebarLinks.forEach(link => {
            link.addEventListener("click", function() {
                // Remove 'active' class from all links
                sidebarLinks.forEach(item => item.classList.remove("active"));
                // Add 'active' class to clicked link
                link.classList.add("active");
            });
        });
    });
</script>

<style>
    /* Sidebar base styles */
    #sidebar {
        transition: all 0.3s ease;
        /* Smooth transition for visibility */
    }

    /* Style for the links and icons */
    .sidebar-nav .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #555;
        font-size: 16px;
        text-decoration: none;
    }

    /* Icon styling */
    .sidebar-nav .nav-link i {
        margin-right: 10px;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    /* Active state for the link */
    .sidebar-nav .nav-link.active {
        background: rgb(0, 128, 0);
        /* Active link background color */
        color: white;
        /* Text color when active */
        border-radius: 5px;
    }

    /* Active icon color */
    .sidebar-nav .nav-link.active i {
        color: white;
        /* White icon color when active */
    }

    /* Hover effect for the link */
    .sidebar-nav .nav-link:hover {
        background: rgba(0, 128, 0, 0.1);
        /* Light green background on hover */
        color: rgb(0, 128, 0);
        /* Green text color on hover */
    }

    /* Hover effect for the icon */
    .sidebar-nav .nav-link:hover i {
        color: rgb(0, 128, 0);
        /* Green icon color on hover */
    }

    /* Styles when the sidebar is collapsed */
    #sidebar.collapsed .sidebar-nav .nav-link .link-text {
        display: none;
        /* Hide the text when the sidebar is collapsed */
    }

    /* Larger icon size when sidebar is collapsed */
    #sidebar.collapsed .sidebar-nav .nav-link i {
        font-size: 22px;
        /* Icon size */
    }

    /* When the sidebar is collapsed, make the icons stick to the top */
    #sidebar.collapsed {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 999;
    }

    /* Transition for smooth visibility change */
    .link-text {
        transition: ease;
    }
</style>
