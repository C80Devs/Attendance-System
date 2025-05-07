<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Time and Attendance Management System">
    <meta name="keywords" content="checkin,attendance system">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="author" content="Cyberwizard">

    <title>{{ $pageTitle ?? ucwords(Route::currentRouteName()) . " - " . config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Configuration -->
    <script>

tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: "#BF0000FF",
                    dark: "#6B0000",
                    light: "#AB0000",
                },
                secondary: {
                    DEFAULT: "#2C3E50",
                    dark: "#1C2E40",
                    light: "#3C4E60",
                },
                accent: "#F39C12",
                success: "#27AE60",
                warning: "#F39C12",
                danger: "#E74C3C",
                info: "#3498DB",
                card: {
                    DEFAULT: "#FFFFFF",
                    dark: "#F8FAFC",
                },
            },
            boxShadow: {
                card: "0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)",
                "card-hover":
                    "0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04)",
            },
        },
    },
}

    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/neptune.png') }}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/neptune.png') }}"/>

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>

    @livewireStyles

    <!-- Custom Styles -->
    <style>
        /* Custom styles for sidebar transitions */
        .sidebar-transition {
            transition: transform 0.3s ease, width 0.3s ease;
        }

        /* Ensure consistent box sizing */
        * {
            box-sizing: border-box;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d1d1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #8B0000;
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Pulse animation for notifications */
        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(139, 0, 0, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(139, 0, 0, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(139, 0, 0, 0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Gradient backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #8B0000 0%, #CC0000 100%);
        }

        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Improved focus styles */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.3);
        }
    </style>

    @include('partials.style-change')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transform -translate-x-full md:translate-x-0 transition-all duration-300 ease-in-out bg-gradient-to-b from-secondary to-secondary-dark shadow-xl">
            <div class="flex flex-col h-full">
                <!-- Sidebar Header -->
                <div class="p-5 border-b border-secondary-light/20">
                    <div class="flex items-center justify-between">
                        <!-- Logo and App Name -->
                        <div class="flex items-center space-x-3">
                            <div class="p-1.5 bg-white/10 rounded-lg">
                                <svg class="h-8 w-8" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="50" cy="50" r="48" fill="white" stroke="#8B0000" stroke-width="4"/>
                                    <circle cx="50" cy="50" r="40" fill="#8B0000" fill-opacity="0.1"/>
                                    <line x1="50" y1="50" x2="50" y2="25" stroke="#8B0000" stroke-width="3" stroke-linecap="round"/>
                                    <line x1="50" y1="50" x2="70" y2="60" stroke="#8B0000" stroke-width="3" stroke-linecap="round"/>
                                    <circle cx="50" cy="50" r="3" fill="#8B0000"/>
                                    <path d="M75 35L45 65L25 45" stroke="#8B0000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-white">{{ $settings->name ?? config('app.name') }}</h2>
                        </div>
                        <button onclick="toggleSidebar()" class="text-white hover:text-gray-300 focus:outline-none md:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- User Profile Summary -->
                @if(Auth::user())
                <div class="px-5 py-4 border-b border-secondary-light/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-primary flex items-center justify-center text-white text-lg font-bold shadow-md">
                            {{ substr(Auth::user()->firstName, 0, 1) }}{{ substr(Auth::user()->lastName ?? '', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-medium text-white">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</h3>
                            <p class="text-xs text-gray-300 truncate max-w-[160px]">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Navigation Menu -->
                <nav class="flex-1 overflow-y-auto py-5">
                    <div class="px-3 mb-3">
                        <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</h3>
                    </div>
                    <ul class="space-y-1.5 px-3">
                        @if(Auth::user())
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   class="{{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('activity') }}"
                                   class="{{ request()->routeIs('activity') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Attendance</span>
                                </a>
                            </li>

                            @if($settings->leave_active)
                                <li>
                                    <a href="{{ route('leave') }}"
                                       class="{{ request()->routeIs('leave') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Leave Requests</span>
                                    </a>
                                </li>
                            @endif

                            @if($settings->task_active)
                                <li>
                                    <a href="{{ route('tasks') }}"
                                       class="{{ request()->routeIs('tasks') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                        </svg>
                                        <span>Tasks</span>
                                    </a>
                                </li>
                            @endif

                            <div class="px-3 pt-5 pb-2">
                                <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Employees</h3>
                            </div>

                            <li>
                                <a href="{{ route('employee.board') }}"
                                   class="{{ request()->routeIs('employee.board') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span>Employee Board</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('poll') }}"
                                   class="{{ request()->routeIs('poll') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span>Poll</span>
                                </a>
                            </li>

                            <div class="px-3 pt-5 pb-2">
                                <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Account</h3>
                            </div>

                            <li>
                                <a href="{{ route('profile') }}"
                                   class="{{ request()->routeIs('profile') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Profile</span>
                                </a>
                            </li>

                            @if(Auth::user()->super_admin)
                                <div class="px-3 pt-5 pb-2">
                                    <h3 class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</h3>
                                </div>
                                <li>
                                    <a href="/admin" target="_blank"
                                       class="{{ request()->is('admin') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Admin</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin-dashboard') }}" target="_blank"
                                       class="{{ request()->is('admin/*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Admin Control</span>
                                    </a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="{{ route('login') }}"
                                   class="{{ request()->routeIs('login') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Login</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('register') }}"
                                   class="{{ request()->routeIs('register') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-secondary-light hover:text-white' }} flex items-center px-4 py-2.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    <span>Register</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>

                <!-- Sidebar Footer -->
                @if(Auth::user())
                <div class="p-4 border-t border-secondary-light/20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="flex items-center px-4 py-2.5 text-gray-300 hover:bg-secondary-light hover:text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
                @endif
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col md:ml-64">
            <!-- Top Navigation Bar -->
            <header class="bg-white shadow-soft sticky top-0 z-30">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Toggle Button -->
                            <button id="toggle-btn" onclick="toggleSidebar()"
                                    class="p-2 rounded-md text-gray-600 hover:text-primary hover:bg-gray-100 focus:outline-none transition-colors md:hidden">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>

                            <!-- Current Page Title -->
                            <div class="ml-4 flex items-center">
                                <h1 class="text-xl font-bold text-gray-800">{{ ucwords(Route::currentRouteName()) }}</h1>
                            </div>
                        </div>

                        <!-- Right Navigation -->
                        <div class="flex items-center space-x-4">
                            @if(Auth::user())
                                <!-- Search -->
                                <div class="hidden md:block">
                                    <div class="relative">
                                        <input type="text" placeholder="Search..." class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                                        <div class="absolute left-3 top-2.5 text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notifications -->
                                <div class="relative">
                                    <button class="p-2 rounded-full text-gray-600 hover:text-primary hover:bg-gray-100 focus:outline-none transition-colors">
                                        <div class="relative">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-primary"></span>
                                        </div>
                                    </button>
                                </div>

                                <!-- User Dropdown -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-full text-gray-600 hover:text-primary hover:bg-gray-100 focus:outline-none transition-colors">
                                        <div class="w-8 h-8 rounded-full bg-gradient-primary flex items-center justify-center text-white text-sm font-bold shadow-md">
                                            {{ substr(Auth::user()->firstName, 0, 1) }}{{ substr(Auth::user()->lastName ?? '', 0, 1) }}
                                        </div>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                        <div class="border-t border-gray-100"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <!-- Alert Messages -->
                    @once
                        @include('partials.alerts')
                    @endonce

                    <!-- Main Content -->
                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </main>

            <!-- Footer -->
            @if (request()->route()->getName() !== 'profile')
            <footer class="bg-gray-800 text-white py-3 w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="flex items-center mb-2 md:mb-0">
                            <svg class="h-5 w-5 mr-2" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="50" r="48" fill="white" stroke="white" stroke-width="4"/>
                                <circle cx="50" cy="50" r="40" fill="white" fill-opacity="0.1"/>
                                <line x1="50" y1="50" x2="50" y2="25" stroke="white" stroke-width="3" stroke-linecap="round"/>
                                <line x1="50" y1="50" x2="70" y2="60" stroke="white" stroke-width="3" stroke-linecap="round"/>
                                <circle cx="50" cy="50" r="3" fill="white"/>
                                <path d="M75 35L45 65L25 45" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="text-sm font-medium">{{ $settings->name ?? config('app.name') }}</span>
                        </div>

                        <div class="flex space-x-4 text-xs">
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a>
                            <a href="{{ route('activity') }}" class="text-gray-300 hover:text-white transition-colors">Attendance</a>
                            <a href="{{ route('profile') }}" class="text-gray-300 hover:text-white transition-colors">Profile</a>
                        </div>

                        <div class="flex items-center space-x-3 mt-2 md:mt-0">
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="border-t border-gray-700 mt-2 pt-2 flex justify-between items-center text-xs text-gray-400">
                        <p>&copy; <span id="currentYear"></span> {{ $settings->name ?? config('app.name') }}</p>
                        <p>All rights reserved</p>
                    </div>
                </div>
            </footer>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <script>
        // Toastr configuration
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");

            // Only toggle on mobile
            if (window.innerWidth < 768) {
                sidebar.classList.toggle("-translate-x-full");

                // Close sidebar when clicking outside (mobile only)
                if (!sidebar.classList.contains("-translate-x-full")) {
                    document.addEventListener('click', closeSidebarOnClickOutside);
                } else {
                    document.removeEventListener('click', closeSidebarOnClickOutside);
                }
            }
        }

        function closeSidebarOnClickOutside(event) {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("toggle-btn");

            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.add("-translate-x-full");
                document.removeEventListener('click', closeSidebarOnClickOutside);
            }
        }

        // Update footer year
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById("currentYear")) {
                document.getElementById("currentYear").textContent = new Date().getFullYear();
            }
        });
    </script>

    @livewireScripts
</body>
</html>
