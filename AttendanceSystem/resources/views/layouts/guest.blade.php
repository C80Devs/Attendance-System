<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Time and Attendance Management System">
        <meta name="keywords" content="checkin,attendance system">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <title>{{ config('app.name', 'Attendance App') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Tailwind Configuration -->
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                DEFAULT: '#8B0000',
                                dark: '#6B0000',
                                light: '#AB0000',
                            },
                            secondary: {
                                DEFAULT: '#2C3E50',
                                dark: '#1C2E40',
                                light: '#3C4E60',
                            },
                            accent: '#F39C12',
                            success: '#27AE60',
                            warning: '#F39C12',
                            danger: '#E74C3C',
                            info: '#3498DB',
                        }
                    }
                }
            }
        </script>

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
              integrity="sha512-W6vq3/+D26w7+oRSx9a/mqerfwk9TkFZ5fz7MW6JfUn9W+qlay2G/ijqg2A6UMf8i4DWzSrq5VVQZcneJ6GgTw=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col md:flex-row">
            <!-- Left side background/image panel -->
            <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-primary to-primary-dark p-12 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="8" height="8" patternUnits="userSpaceOnUse">
                                <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.5" />
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>

                <div class="relative z-10 h-full flex flex-col">
                    <div class="flex-grow flex items-center justify-center">
                        <div class="text-white max-w-md">
                            <h1 class="text-4xl font-bold mb-6">{{ $title ?? 'Welcome' }}</h1>
                            <p class="text-lg opacity-90 mb-8">{{ $description ?? 'Track attendance efficiently and manage your team with our powerful attendance management system.' }}</p>

                            <div class="flex items-center space-x-4 mt-12">
                                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium">Easy Tracking</h3>
                                    <p class="opacity-80 text-sm">Simple and intuitive attendance management</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4 mt-6">
                                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-medium">Detailed Reports</h3>
                                    <p class="opacity-80 text-sm">Comprehensive analytics and insights</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto text-white/70 text-sm">
                        &copy; {{ date('Y') }} {{ $settings->name ?? config('app.name') }}. All rights reserved.
                    </div>
                </div>
            </div>

            <!-- Right side form panel -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-6">
                <div class="w-full max-w-md">
                    <div class="text-center mb-8">
                        <a href="{{ route('dashboard') }}" class="inline-block">
                            @php
                                use App\Models\SettingsModel;
                                $settings = SettingsModel::first();
                            @endphp

                            <!-- Custom SVG Logo -->
                            <svg class="h-20 w-20 mx-auto" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Outer Circle -->
                                <circle cx="50" cy="50" r="48" fill="white" stroke="#8B0000" stroke-width="4"/>

                                <!-- Clock Face -->
                                <circle cx="50" cy="50" r="40" fill="#8B0000" fill-opacity="0.1"/>

                                <!-- Clock Hands -->
                                <line x1="50" y1="50" x2="50" y2="25" stroke="#8B0000" stroke-width="3" stroke-linecap="round"/>
                                <line x1="50" y1="50" x2="70" y2="60" stroke="#8B0000" stroke-width="3" stroke-linecap="round"/>

                                <!-- Clock Center -->
                                <circle cx="50" cy="50" r="3" fill="#8B0000"/>

                                <!-- Clock Ticks -->
                                <line x1="50" y1="10" x2="50" y2="15" stroke="#8B0000" stroke-width="2"/>
                                <line x1="50" y1="85" x2="50" y2="90" stroke="#8B0000" stroke-width="2"/>
                                <line x1="10" y1="50" x2="15" y2="50" stroke="#8B0000" stroke-width="2"/>
                                <line x1="85" y1="50" x2="90" y2="50" stroke="#8B0000" stroke-width="2"/>

                                <!-- Checkmark -->
                                <path d="M75 35L45 65L25 45" stroke="#8B0000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        </a>
                        <h2 class="text-2xl font-bold text-gray-800 mt-4">{{ $formTitle ?? 'Sign in to your account' }}</h2>
                        <p class="text-gray-600 mt-2">{{ $formSubtitle ?? 'Enter your credentials to access your account' }}</p>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}

                    <div class="mt-8 text-center text-xs text-gray-500">
                        By signing in, you agree to our
                        <a href="#" class="text-primary hover:text-primary-dark">Terms of Service</a> and
                        <a href="#" class="text-primary hover:text-primary-dark">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
