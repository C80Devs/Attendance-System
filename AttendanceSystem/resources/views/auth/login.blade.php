<x-guest-layout>
    <x-slot name="title">Welcome Back</x-slot>
    <x-slot name="description">Sign in to continue to your attendance dashboard and manage your team efficiently.</x-slot>
    <x-slot name="formTitle">Sign in to your account</x-slot>
    <x-slot name="formSubtitle">Enter your credentials to access your account</x-slot>

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="signInEmail" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
                <input
                    required
                    type="email"
                    id="signInEmail"
                    name="email"
                    placeholder="you@example.com"
                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary transition duration-150 ease-in-out sm:text-sm"
                >
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="signInPassword" class="block text-sm font-medium text-gray-700">Password</label>
                <a href="{{ route('password.email') }}" class="text-sm font-medium text-primary hover:text-primary-dark transition">
                    Forgot password?
                </a>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    required
                    type="password"
                    id="signInPassword"
                    name="password"
                    placeholder="••••••••"
                    class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary transition duration-150 ease-in-out sm:text-sm"
                >
            </div>
        </div>

        <div class="flex items-center">
            <input
                id="remember_me"
                name="remember"
                type="checkbox"
                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
            >
            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                Remember me
            </label>
        </div>

        <div>
            <button
                type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out"
            >
                Sign in
            </button>
        </div>
    </form>

    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-slate-50 text-gray-500">
                    Don't have an account?
                </span>
            </div>
        </div>

        <div class="mt-6">
            <a
                href="{{ route('register') }}"
                class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-150 ease-in-out"
            >
                Create new account
            </a>
        </div>
    </div>
</x-guest-layout>
