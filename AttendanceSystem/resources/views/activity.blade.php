<x-app-layout>
    <div class="mb-4">
        <!-- Attendance Activity Section -->
        @if ($attendance->isEmpty())
            <div class="bg-gray-50 rounded-xl p-8 text-center shadow-card">
                <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-1">No Attendance Records Found</h3>
                <p class="text-gray-500">Your attendance history will appear here once you start clocking in and out.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-800">Attendance Activity</h2>
                    <span class="text-xs font-medium px-2 py-1 bg-primary/10 text-primary rounded-full">{{ $count }} {{ Str::plural('Record', $count) }}</span>
                </div>

                <!-- Attendance Records -->
                <div class="p-5">
                    @foreach($attendance as $attend)
                        <div class="mb-6 last:mb-0">
                            <!-- Date Header -->
                            <p class="text-sm text-gray-500 mb-3">{{ $attend->clockInHeader }}</p>

                            <!-- Clock In Record -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-success/10 flex items-center justify-center text-success mr-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">Clock In</h4>
                                                <p class="text-gray-500 text-sm">{{ $attend->clockInFormatted }}</p>
                                            </div>
                                            <a href="{{ $attend->clockin_location }}" class="text-primary hover:text-primary-dark text-sm flex items-center mt-2 sm:mt-0">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                View Location
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Clock Out Record -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-danger/10 flex items-center justify-center text-danger mr-4">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">Clock Out</h4>
                                                <p class="text-gray-500 text-sm">{{ $attend->clockOutFormatted }}</p>
                                            </div>
                                            <a href="{{ $attend->clockout_location }}" class="text-primary hover:text-primary-dark text-sm flex items-center mt-2 sm:mt-0">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                View Location
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!$loop->last)
                                <hr class="my-6 border-gray-100">
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="p-5 bg-gray-50 border-t border-gray-100">
                    {{ $attendance->links('vendor.tailwind') }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
