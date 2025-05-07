
<x-app-layout>
    <div class="mb-4">
        @if (is_null(Auth::user()->date_of_birth))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-md transform hover:scale-[1.01] transition-all duration-300 animate-fade-in">
                <div class="flex items-center">
                    <div class="flex-shrink-0 animate-pulse">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Please update your birthday. <a href="{{ route('profile') }}" class="font-medium underline text-yellow-700 hover:text-yellow-600 transition-colors duration-200">Go to Profile</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-6 transform hover:translate-y-[-2px] transition-all duration-300">
            <livewire:Clocker/>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Attendance Stats Card -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-500 p-5 relative overflow-hidden group">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Attendance Overview</h2>
                        <span class="text-xs font-medium px-2.5 py-1 bg-primary-100 text-primary-700 rounded-full animate-pulse">{{ date('F Y') }}</span>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 transform transition-all duration-500 group-hover:rotate-12 group-hover:scale-110 group-hover:bg-primary-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Present Days</p>
                                <h3 class="text-xl font-bold">{{$userAttendanceCount}}/{{$numberOfWorkingDays}}</h3>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 transition-all duration-300 hover:bg-emerald-600 hover:text-white">
                                <span>{{$earlyAttendancePercentage}}% On Time</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center p-3 rounded-lg bg-rose-50 border border-rose-100 transition-all duration-300 hover:bg-rose-100 transform hover:scale-[1.02] hover:shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-rose-600 mr-3 transition-transform duration-500 hover:rotate-12 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Late</p>
                                <p class="text-lg font-semibold text-rose-700">{{$lateAttendance}}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 rounded-lg bg-emerald-50 border border-emerald-100 transition-all duration-300 hover:bg-emerald-100 transform hover:scale-[1.02] hover:shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-600 mr-3 transition-transform duration-500 hover:rotate-12 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Early</p>
                                <p class="text-lg font-semibold text-emerald-700">{{$earlyAttendance}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leave Stats Card -->
            @if($settings->leave_active)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-500 p-5 relative overflow-hidden group">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Leave Balance</h2>
                        <span class="text-xs font-medium px-2.5 py-1 bg-blue-100 text-primary/90 rounded-full animate-pulse">{{ date('Y') }}</span>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary/60 transform transition-all duration-500 group-hover:rotate-12 group-hover:scale-110 group-hover:bg-blue-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Remaining Days</p>
                                <h3 class="text-xl font-bold">{{$remainingLeaveDays}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">

                        @if(count($topLeaveTypes) > 0)
                            @foreach($topLeaveTypes as $leaveType)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-primary/50 border border-blue-100 transition-all duration-300 hover:bg-blue-100 transform hover:scale-[1.02] hover:shadow-sm">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-primary/60 mr-3 transition-transform duration-500 hover:rotate-12 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-white">{{ $leaveType->type }}</p>
                                    </div>
                                    <span class="text-lg font-semibold text-white">{{ $leaveType->leave_count }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 rounded-lg bg-blue-50 text-center transition-all duration-300 hover:bg-blue-100">
                                <p class="text-sm text-gray-500">No leave records found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Task Stats Card -->
            @if($settings->task_active)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-500 p-5 relative overflow-hidden group">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Task Management</h2>
                        <span class="text-xs font-medium px-2.5 py-1 bg-primary-100 text-primary-700 rounded-full animate-pulse">{{ $totalTasks }} Total</span>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 transform transition-all duration-500 group-hover:rotate-12 group-hover:scale-110 group-hover:bg-primary-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-500">Completion Rate</p>
                                <h3 class="text-xl font-bold">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</h3>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="flex flex-col items-center p-3 rounded-lg bg-emerald-50 border border-emerald-100 transition-all duration-300 hover:bg-emerald-100 transform hover:scale-[1.05] hover:shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-600 mb-2 transition-transform duration-500 hover:rotate-12 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-600">Completed</p>
                            <p class="text-lg font-semibold text-emerald-700">{{ $completedTasks }}</p>
                        </div>
                        <div class="flex flex-col items-center p-3 rounded-lg bg-amber-50 border border-amber-100 transition-all duration-300 hover:bg-amber-100 transform hover:scale-[1.05] hover:shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-amber-600 mb-2 transition-transform duration-500 hover:rotate-12 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-600">Ongoing</p>
                            <p class="text-lg font-semibold text-amber-700">{{ $ongoingTasks }}</p>
                        </div>
                        <div class="flex flex-col items-center p-3 rounded-lg bg-rose-50 border border-rose-100 transition-all duration-300 hover:bg-rose-100 transform hover:scale-[1.05] hover:shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-rose-600 mb-2 transition-transform duration-500 hover:rotate-12 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-gray-600">Failed</p>
                            <p class="text-lg font-semibold text-rose-700">{{ $failedTasks }}</p>
                        </div>
                    </div>

                    <!-- Task Progress Bar -->
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium text-gray-600">Task Progress</span>
                            <span class="font-medium text-primary">{{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-primary/40 to-primary/60 rounded-full transition-all duration-1000 ease-out"
                                style="width: {{ $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

<!-- Birthday Modal Component -->
<div id="birthdayModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity ease-out duration-300 opacity-0" id="modal-backdrop"></div>

        <!-- Falling balloons container (positioned outside the modal for fullscreen effect) -->
        <div id="balloons-container" class="fixed inset-0 z-10 pointer-events-none overflow-hidden"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" id="modal-content">
            <!-- Modal content -->
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-center w-full">
                        <div class="flex justify-center mb-4">
                            <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center">
                                <svg class="w-12 h-12 text-primary" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17a3 3 0 015-2.236zM10 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                    <path d="M10 12a1 1 0 100 2 1 1 0 000-2z"></path>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-title">
                            Happy Birthday, {{ Auth::user()->firstName }}! 🎂
                        </h3>
                        <div class="mt-4">
                            <p class="text-lg text-gray-600 leading-relaxed">
                                From all of us at <span class="font-semibold text-primary">{{ $settings->name }}</span>, we wish you a truly wonderful day filled with happiness, peace, and countless moments of joy. May your day be as amazing as you are!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="closeBirthdayModal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                    Thank You!
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add this to your existing styles section -->
<style>
    /* Balloon animation */
    @keyframes float-up {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(-100px) rotate(20deg);
            opacity: 0;
        }
    }

    .balloon {
        position: absolute;
        bottom: -100px;
        animation: float-up 10s linear forwards;
        z-index: 10;
        pointer-events: none;
    }

    /* Modal animation */
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scale-in {
        from { transform: scale(0.95); }
        to { transform: scale(1); }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-out forwards;
    }

    .animate-scale-in {
        animation: scale-in 0.5s ease-out forwards;
    }
</style>

<!-- Add this to your existing script section -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isBirthday = checkIfBirthdayToday();

        if (isBirthday) {
            showBirthdayModal();
        }

        // Close modal when clicking the close button
        document.getElementById('closeBirthdayModal').addEventListener('click', function() {
            hideBirthdayModal();
        });

        // Function to check if today is the user's birthday
        function checkIfBirthdayToday() {
            @if(Auth::check() && !is_null(Auth::user()->date_of_birth))
                const birthDate = new Date("{{ Auth::user()->date_of_birth }}");
                const today = new Date();

                return birthDate.getDate() === today.getDate() &&
                       birthDate.getMonth() === today.getMonth();
            @else
                return false;
            @endif
        }

        // Function to show the birthday modal with animations
        function showBirthdayModal() {
            const modal = document.getElementById('birthdayModal');
            const backdrop = document.getElementById('modal-backdrop');
            const content = document.getElementById('modal-content');

            // Show the modal
            modal.classList.remove('hidden');

            // Animate in
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                content.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');

                // Start balloon animation
                createBalloons();
            }, 10);

            // Store in localStorage to prevent showing again today
            localStorage.setItem('birthdayModalShown', new Date().toDateString());
        }

        // Function to hide the birthday modal with animations
        function hideBirthdayModal() {
            const modal = document.getElementById('birthdayModal');
            const backdrop = document.getElementById('modal-backdrop');
            const content = document.getElementById('modal-content');

            // Animate out
            backdrop.classList.add('opacity-0');
            content.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            content.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

            // Hide the modal after animation completes
            setTimeout(() => {
                modal.classList.add('hidden');

                // Clear balloons
                const balloonsContainer = document.getElementById('balloons-container');
                balloonsContainer.innerHTML = '';
            }, 300);
        }

        // Create falling balloons
        function createBalloons() {
            const balloonsContainer = document.getElementById('balloons-container');
            const colors = ['#FF5252', '#FF4081', '#E040FB', '#7C4DFF', '#536DFE', '#448AFF', '#40C4FF', '#18FFFF', '#64FFDA', '#69F0AE', '#B2FF59', '#EEFF41', '#FFFF00', '#FFD740', '#FFAB40', '#FF6E40'];
            const balloonCount = 30;

            for (let i = 0; i < balloonCount; i++) {
                setTimeout(() => {
                    const balloon = document.createElement('div');
                    balloon.className = 'balloon';

                    // Random position, size, and color
                    const size = Math.floor(Math.random() * 40) + 40; // 40-80px
                    const left = Math.floor(Math.random() * 100); // 0-100%
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    const duration = Math.floor(Math.random() * 5) + 8; // 8-13s
                    const delay = Math.random() * 5; // 0-5s

                    balloon.innerHTML = `
                        <svg width="${size}" height="${size * 1.2}" viewBox="0 0 50 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25 0C11.2 0 0 11.2 0 25C0 36.3 7.8 45.9 18.5 48.5C19.3 48.7 20 49.4 20 50.2V52.5C20 53.3 19.3 54 18.5 54H16C15.4 54 15 54.4 15 55V59C15 59.6 15.4 60 16 60H34C34.6 60 35 59.6 35 59V55C35 54.4 34.6 54 34 54H31.5C30.7 54 30 53.3 30 52.5V50.2C30 49.4 30.7 48.7 31.5 48.5C42.2 45.9 50 36.3 50 25C50 11.2 38.8 0 25 0Z" fill="${color}"/>
                            <path d="M25 50.2V60" stroke="#888" stroke-width="1" stroke-linecap="round"/>
                        </svg>
                    `;

                    balloon.style.left = `${left}%`;
                    balloon.style.animationDuration = `${duration}s`;
                    balloon.style.animationDelay = `${delay}s`;

                    balloonsContainer.appendChild(balloon);

                    // Remove balloon after animation completes
                    setTimeout(() => {
                        if (balloonsContainer.contains(balloon)) {
                            balloonsContainer.removeChild(balloon);
                        }
                    }, (duration + delay) * 1000);
                }, i * 200); // Stagger balloon creation
            }
        }
    });
</script>


        <!-- Announcements Section -->
        @if($announcements->isNotEmpty())
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-500 p-6 relative overflow-hidden group">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                            Announcements
                        </h2>
                        <span class="text-xs font-medium px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full animate-pulse">{{ $announcements->count() }} {{ Str::plural('Announcement', $announcements->count()) }}</span>
                    </div>

                    <div class="space-y-4">
                        @foreach($announcements as $announcement)
                            <div class="p-4 rounded-lg border transition-all duration-300 transform hover:scale-[1.01] hover:shadow-md {{ $announcement->isActive() ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-5 h-5 {{ $announcement->isActive() ? 'text-blue-500' : 'text-gray-400' }} mr-2 transition-transform duration-500 hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                            </svg>
                                            @if($announcement->isActive())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500 text-white animate-pulse">
                                                    Active
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-gray-800 mb-3">{{ $announcement->message }}</p>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <div class="flex items-center mr-4">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Posted: {{ $announcement->created_at->format('jS M Y, h:i A') }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>Expires: {{ $announcement->expires_at->format('jS M Y, h:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        /* Fade in animation */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Fade in up animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Slow ping animation */
        @keyframes pingSlow {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.4;
            }
            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        /* Slow pulse animation */
        @keyframes pulseSlow {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        /* Slow spin animation */
        @keyframes spinSlow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-ping-slow {
            animation: pingSlow 3s infinite;
        }

        .animate-pulse-slow {
            animation: pulseSlow 3s infinite;
        }

        .animate-spin-slow {
            animation: spinSlow 10s linear infinite;
        }

        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        /* Staggered animation for cards */
        .grid > div:nth-child(1) { animation-delay: 0ms; }
        .grid > div:nth-child(2) { animation-delay: 100ms; }
        .grid > div:nth-child(3) { animation-delay: 200ms; }
        .grid > div:nth-child(4) { animation-delay: 300ms; }
        .grid > div:nth-child(5) { animation-delay: 400ms; }
        .grid > div:nth-child(6) { animation-delay: 500ms; }
    </style>



    <script>
        const hasBirthdayToday = @json($upcomingBirthdays->contains(function($user) {
            return Carbon\Carbon::parse($user->date_of_birth)->isToday();
        }));

        window.addEventListener("load", () => {
            // Add entrance animations to cards
            const cards = document.querySelectorAll('.card-hover, .rounded-xl');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 * index);
            });

            if (hasBirthdayToday) {
                const animationContainer = document.getElementById('animation');
                animationContainer.style.display = 'block';

                // Add confetti effect for birthdays
                playBirthdayAnimation('animation');

                // Add extra celebration effects
                setTimeout(() => {
                    const birthdayCards = document.querySelectorAll('.animate-pulse-slow');
                    birthdayCards.forEach(card => {
                        card.classList.add('animate-bounce');
                        setTimeout(() => card.classList.remove('animate-bounce'), 3000);
                    });
                }, 1000);
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced birthday animation with confetti
        function playBirthdayAnimation(containerId) {
            const animationContainer = document.getElementById(containerId);

            // Load and play the Lottie animation
            const animation = lottie.loadAnimation({
                container: animationContainer,
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: '{{ asset("assets/ballons.json") }}'
            });

            // Add confetti effect using canvas
            const confettiCanvas = document.createElement('canvas');
            confettiCanvas.style.position = 'absolute';
            confettiCanvas.style.top = '0';
            confettiCanvas.style.left = '0';
            confettiCanvas.style.width = '100%';
            confettiCanvas.style.height = '100%';
            confettiCanvas.style.pointerEvents = 'none';
            confettiCanvas.style.zIndex = '10';
            document.body.appendChild(confettiCanvas);

            const confetti = {
                canvas: confettiCanvas,
                ctx: confettiCanvas.getContext('2d'),
                particles: [],
                colors: ['#FFC700', '#FF0000', '#2E3191', '#41BBC7', '#9BC53D', '#E11D74', '#7209B7'],

                start: function() {
                    this.canvas.width = window.innerWidth;
                    this.canvas.height = window.innerHeight;
                    this.particles = [];

                    for (let i = 0; i < 200; i++) {
                        this.particles.push({
                            x: Math.random() * this.canvas.width,
                            y: Math.random() * this.canvas.height - this.canvas.height,
                            size: Math.random() * 8 + 3,
                            color: this.colors[Math.floor(Math.random() * this.colors.length)],
                            speed: Math.random() * 3 + 2
                        });
                    }

                    this.update();
                },

                update: function() {
                    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

                    for (let i = 0; i < this.particles.length; i++) {
                        const p = this.particles[i];
                        this.ctx.fillStyle = p.color;
                        this.ctx.fillRect(p.x, p.y, p.size, p.size);

                        p.y += p.speed;

                        if (p.y > this.canvas.height) {
                            this.particles[i].y = -10;
                            this.particles[i].x = Math.random() * this.canvas.width;
                        }
                    }

                    if (this.active) {
                        requestAnimationFrame(() => this.update());
                    }
                },

                active: true,

                stop: function() {
                    this.active = false;
                    setTimeout(() => {
                        document.body.removeChild(this.canvas);
                    }, 1000);
                }
            };

            // Start confetti
            confetti.start();

            // Clean up animations after completion
            animation.addEventListener('complete', function() {
                setTimeout(() => {
                    animationContainer.style.display = 'none';
                    confetti.stop();
                }, 2000);
            });
        }

        // Add hover effects to icons
        document.addEventListener('DOMContentLoaded', function() {
            const icons = document.querySelectorAll('svg');
            icons.forEach(icon => {
                icon.addEventListener('mouseover', function() {
                    this.style.transform = 'scale(1.2)';
                    this.style.transition = 'transform 0.3s ease';
                });

                icon.addEventListener('mouseout', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</x-app-layout>


