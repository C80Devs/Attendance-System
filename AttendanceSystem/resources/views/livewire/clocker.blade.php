<div>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-500 transform hover:scale-[1.01]">
        <div class="p-6">
            <div class="flex flex-col items-center justify-center">
                <!-- Clock Display -->
                <div class="mb-6 text-center animate-fade-in">
                    <h2 id="current-time" class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-gray-800 mb-1 font-mono transition-all duration-300"></h2>
                    <p class="text-sm text-gray-500 opacity-0 animate-fade-in" style="animation-delay: 200ms; animation-fill-mode: forwards;">
                        {{ now()->format('l, F j, Y') }}
                    </p>
                </div>

                <!-- Clock Action Button -->
                @if(!$clockedOut)
                    <button
                        id="clock-button"
                        wire:click="clock(latitude, longitude)"
                        wire:loading.attr="disabled"
                        wire:target="clock"
                        class="flex items-center justify-center gap-2 px-6 py-3 rounded-full text-white font-medium transition-all duration-300
                        bg-primary hover:bg-primary-dark min-w-[160px] transform hover:scale-105 active:scale-95
                        hover:shadow-md animate-pulse-subtle disabled:opacity-75 disabled:cursor-not-allowed"
                        onclick="showClockLoading()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span id="clock-button-text">{{ $clockedIn ? 'Clock Out' : 'Clock In' }}</span>
                        <svg id="clock-spinner" class="animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                @endif

                <!-- Status Messages -->
                @if($clockedIn)
                    <div class="mt-6 w-full max-w-md bg-gray-50 border border-gray-100 rounded-lg p-4 text-center transform transition-all duration-500 animate-slide-up">
                        <div class="flex items-center justify-center gap-2 text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Clocked in at <strong>{{ $clockInTime }}</strong></span>
                        </div>
                    </div>
                @endif

                @if($clockedOut)
                    <div class="mt-4 text-center transform transition-all duration-500 animate-slide-up">
                        <p class="text-gray-500 flex items-center justify-center gap-1 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Done, check back tomorrow!</span>
                        </p>
                        <p class="text-gray-500 flex items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>You clocked out at <strong>{{ $clockOutTime }}</strong></span>
                        </p>
                    </div>
                @endif

                <!-- Location Error -->
                <div id="location_alert" class="mt-4 text-amber-600 text-sm flex items-center justify-center gap-1 animate-bounce-subtle" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span id="location_alert_text">Turn on location.</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom animations */
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-in-out;
        }

        .animate-slide-up {
            animation: slide-up 0.5s ease-out;
        }

        .animate-pulse-subtle {
            animation: pulse-subtle 2s infinite;
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s infinite;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        let latitude;
        let longitude;
        let location_alert = document.getElementById("location_alert");
        let location_alert_text = document.getElementById("location_alert_text");
        let locationRetrieved = false;
        let clock_button = document.getElementById("clock-button");
        let clock_spinner = document.getElementById("clock-spinner");
        let clock_button_text = document.getElementById("clock-button-text");


        setInterval(updateTime, 1000);
        let locationInterval = setInterval(getLocationAndClock, 3000);

        function getLocationAndClock() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        locationRetrieved = true;
                        enableClockButton();
                        clearInterval(locationInterval);
                    },
                    function (error) {
                        console.error('Error getting location:', error);
                        showLocationError();
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showLocationError('Error: Your browser does not support geolocation.');
            }
        }

        function updateTime() {
            var currentTime = new Date().toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            });
            document.getElementById('current-time').innerHTML = currentTime;
        }

        function showLocationError(message = 'Error: Unable to turn on location, retrying.') {
            location_alert.style.display = 'flex';
            location_alert_text.textContent = message;
            disableClockButton();
        }

        function disableClockButton() {
            if (clock_button) {
                clock_button.style.display = 'none';
                location_alert.style.display = 'flex';
            }
        }

        function enableClockButton() {
            if (clock_button) {
                clock_button.style.display = 'flex';
                location_alert.style.display = 'none';
            }
        }

        // Show loading state on the clock button
        function showClockLoading() {
            if (clock_spinner && clock_button_text) {
                clock_spinner.style.display = 'inline-block';
                clock_button.disabled = true;
                clock_button.classList.add('opacity-75', 'cursor-not-allowed');
                // Stop the pulse animation during loading
                clock_button.classList.remove('animate-pulse-subtle');
            }
        }

        // Hide loading state on the clock button
        function hideClockLoading() {
            if (clock_spinner && clock_button_text) {
                clock_spinner.style.display = 'none';
                clock_button.disabled = false;
                clock_button.classList.remove('opacity-75', 'cursor-not-allowed');
                // Restore the pulse animation
                clock_button.classList.add('animate-pulse-subtle');
            }
        }
    </script>
    </div>
