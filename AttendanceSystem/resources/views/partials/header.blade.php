<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Time and Attendance Management System">
    <meta name="keywords" content="checkin,attendance system">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="author" content="Cyberwizard">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/kanbanjs/1.0.0/kanban.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/kanbanjs/1.0.0/kanban.min.js"></script>

    <!-- Title -->
    <title>{{ $pageTitle ?? ucwords(Route::currentRouteName()) . " - " . config('app.name') }}</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/pace/pace.css') }}" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-W6vq3/+D26w7+oRSx9a/mqerfwk9TkFZ5fz7MW6JfUn9W+qlay2G/ijqg2A6UMf8i4DWzSrq5VVQZcneJ6GgTw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/main.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/horizontal-menu/horizontal-menu.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/neptune.png') }}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/neptune.png') }}"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <!-- Include jQuery and jQuery UI (if not already included) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @livewireStyles
    @livewireScripts

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Flatpickr CSS -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        rel="stylesheet"/>

    <style>
        /* Custom Pagination Styles */
        .custom-pagination {
            display: flex;
            justify-content: center; /* Center the pagination links */
            margin-top: 20px; /* Space above pagination */
        }

        .custom-pagination .pagination {
            list-style: none; /* Remove default list styles */
            padding: 0; /* Remove padding */
            margin: 0; /* Remove margin */
        }

        .custom-pagination .pagination li {
            margin: 0 5px; /* Space between pagination items */
        }

        .custom-pagination .pagination li a,
        .custom-pagination .pagination li span {
            display: inline-block; /* Inline block for spacing */
            padding: 10px 15px; /* Space inside pagination items */
            background-color: var(--primaryColor); /* Button background color */
            color: white; /* Button text color */
            border-radius: 5px; /* Rounded corners */
            text-decoration: none; /* Remove underline */
        }

        .custom-pagination .pagination li a:hover,
        .custom-pagination .pagination li span.active {
            background-color: var(--primaryColor); /* Button background color */
            color: #ffffff; /* Text color on hover */
        }


        .toggle-btn {
            position: absolute;
            top: 1px;
            left: 1px; /* Adjust to avoid overlap with menu */
            width: 40px; /* Set width */
            height: 40px; /* Set height */
            background-color: white; /* Change button color to white */
            color: black;
            border: none;
            cursor: pointer;
            z-index: 1001; /* Ensure it is above the sidebar */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .toggle-btn.hidden {
            display: none;
        }

        .toggle-btn:hover {
            background-color: gray;
        }


        /* Full-page overlay for announcement */
        .overlay-announcement-card {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure it's above all other elements */
        }

        /* Announcement card styling */
        .overlay-announcement-card .card {
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
        }

        .overlay-announcement-card .card-header {
            position: relative;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .overlay-announcement-card .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: black;
            cursor: pointer;
        }

        .overlay-announcement-card .card-body {
            max-height: 100%;
            overflow-y: auto;
        }

        .overlay-announcement-card .announcement-item {
            padding: 10px;
            border-bottom: 1px solid #eaeaea;
        }

        .overlay-announcement-card .announcement-item:last-child {
            border-bottom: none;
        }

        /* Ensure consistent box sizing */
        * {
            box-sizing: border-box;
        }

        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px; /* Start hidden off-screen */
            width: 250px;
            height: 100%;
            max-height: 100vh; /* Ensure it does not exceed the viewport height */
            background-color: #333;
            color: #fff;
            padding: 20px;
            transition: left 0.3s ease;
            z-index: 1000;
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: hidden; /* Hide horizontal overflow */
        }

        .sidebar.active {
            left: 0; /* Slide in from the left */
        }

        .sidebar ul {
            padding: 0;
            list-style-type: none;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 20px 10px;
            background-color: #444;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .sidebar ul li a:hover {
            background-color: #555;
        }

        .sidebar ul li a.active {
            background-color: var(--primaryColor); /* Change to your preferred active color */
            color: #fff;
        }

        /* Responsive adjustments for smaller screens */
        @media screen and (max-width: 480px) {
            .sidebar {
                width: 200px;
                left: -200px;
            }

            .sidebar.active {
                left: 0;
            }
        }

        /* Add media query for small devices */
        @media (max-width: 600px) {
            .overlay-announcement-card .card {
                width: 100%;
                border-radius: 0;
            }
        }
    </style>

   @include('partials.style-change')
</head>


<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    @php
    $settings = \App\Models\SettingsModel::first();
 @endphp
    <ul>
        @if(Auth::user())
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard</a></li>

            <li><a href="{{ route('activity') }}" class="{{ request()->routeIs('activity') ? 'active' : '' }}">
                    <i class="fas fa-calendar"></i> Attendance</a></li>

            @if($settings->leave_active)
                <li><a href="{{ route('leave') }}" class="{{ request()->routeIs('leave') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Leave Requests</a></li>
            @endif

        @if($settings->task_active)
            <li><a href="{{ route('tasks') }}" class="{{ request()->routeIs('tasks') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i> Tasks</a></li>
            @endif

            <li><a href="{{ route('employee.board') }}"
                   class="{{ request()->routeIs('employee.board') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Employee Board</a></li>

            <li><a href="{{ route('poll') }}"
                   class="{{ request()->routeIs('poll') ? 'active' : '' }}">
                    <i class="fas fa-poll"></i> Poll</a></li>

            <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                    <i class="fas fa-user"></i> Profile</a></li>

            @if(Auth::user()->super_admin)
                <li><a href="/admin" target="_blank" class="{{ request()->is('admin') ? 'active' : '' }}">
                        <i class="fas fa-cogs"></i> Admin</a></li>
            @endif

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                       class="text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout</a>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
                    <i class="fas fa-sign-in-alt"></i> Login</a></li>
            <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i> Register</a></li>
        @endif
    </ul>
</div>

<!-- Toggle Button -->
<button class="toggle-btn" id="toggle-btn" onclick="toggleSidebar()">
    <!-- Inline SVG Hamburger Icon -->
    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <rect y="4" width="24" height="2"/>
        <rect y="11" width="24" height="2"/>
        <rect y="18" width="24" height="2"/>
    </svg>
</button>


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("toggle-btn");
        sidebar.classList.toggle("active");
        toggleBtn.classList.toggle("hidden");

        document.removeEventListener('click', closeSidebar);
        document.addEventListener('click', closeSidebar);
    }

    function closeSidebar(event) {
        const sidebar = document.getElementById("sidebar");
        const toggleBtn = document.getElementById("toggle-btn");

        if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
            sidebar.classList.remove("active");
            toggleBtn.classList.remove("hidden");
            document.removeEventListener('click', closeSidebar);
        }
    }
</script>


@once
    @include('partials.alerts')
@endonce


@livewireStyles
@livewireScripts


