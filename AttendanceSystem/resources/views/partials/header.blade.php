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

    <!-- Title -->
    <title>{{$pageTitle}}</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/pace/pace.css"')}}" rel="stylesheet">
    <!-- Font Awesome CDN -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-W6vq3/+D26w7+oRSx9a/mqerfwk9TkFZ5fz7MW6JfUn9W+qlay2G/ijqg2A6UMf8i4DWzSrq5VVQZcneJ6GgTw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>


        <!-- Theme Styles -->
    <link href="{{asset('assets/css/main.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/horizontal-menu/horizontal-menu.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/neptune.png')}}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/neptune.png')}}"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    @livewireStyles
    <style>
        #map {
            height: 180px;
        }

    </style>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <a class="navbar-brand d-lg-none">Welcome, {{ ucwords(\Illuminate\Support\Facades\Auth::user()->firstName ?? 'User') }}</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <li class="nav-item">
                    <a class="nav-link " href="{{route("dashboard")}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('activity')}}">Activity</a>
                </li>
               {{-- <li class="nav-item">
                    <a class="nav-link " href="{{route('profile.edit')}}">Profile</a>
                </li>--}}
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link d text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();">logout </a>
                    </form>
                </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{route('register')}}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
