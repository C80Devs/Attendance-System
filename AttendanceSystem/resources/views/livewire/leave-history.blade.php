@php use Carbon\Carbon; @endphp

<div class="mb-4">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <button
            wire:click="toggleForm"
            class="inline-flex items-center justify-center px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 relative"
        >
            <span>Apply for Leave</span>
            <div wire:loading class="absolute right-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </button>
    </div>

    <!-- Leave Application Form -->
    @if($showForm)
        <div id="closeForm" class="bg-white rounded-xl shadow-card mb-6 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Apply for Leave</h3>
                <button
                    id="closeFormBtn"
                    onclick="closeFormJs()"
                    class="inline-flex items-center justify-center p-2 bg-danger/10 hover:bg-danger/20 text-danger rounded-lg transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-5">
                <form id="leaveFormContainer" wire:submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input
                            type="date"
                            id="startDate"
                            wire:model="startDate"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                        @error('startDate')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input
                            type="date"
                            id="endDate"
                            wire:model="endDate"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                        @error('endDate')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
                        <select
                            id="type"
                            wire:model.live="type"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                            <option value="">Select Leave Type</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Monthly Leave">Monthly Leave</option>
                            <option value="Maternity/Paternity Leave">Maternity/Paternity Leave</option>
                            <option value="Wedding">Wedding</option>
                            <option value="Bereavement">Bereavement</option>
                            <option value="Extended Monthly Leave">Extended Monthly Leave</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($type === 'Other')
                        <div>
                            <label for="otherReason" class="block text-sm font-medium text-gray-700 mb-1">Please specify the reason</label>
                            <textarea
                                id="otherReason"
                                wire:model="reason"
                                rows="3"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            ></textarea>
                            @error('reason')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50"
                        >
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Leave History Section -->
    @if($formHistory->isEmpty())
        <div class="bg-gray-50 rounded-xl p-8 text-center shadow-sm">
            <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-700 mb-1">No Leave Requests</h3>
            <p class="text-gray-500">Your leave request history will appear here once you apply for leave.</p>
        </div>
    @else
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Leave History</h2>
            <span class="text-xs font-medium px-2 py-1 bg-info/10 text-info rounded-full">{{ count($formHistory) }} {{ Str::plural('Request', count($formHistory)) }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @foreach($formHistory as $form)
                <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all overflow-hidden">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800">{{ $form->type }}</h3>
                            @if($form->approved === true)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success/10 text-success">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approved
                                </span>
                            @elseif($form->approved === false)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger/10 text-danger">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Denied
                                </span>
                            @elseif($form->approved === null)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning/10 text-warning">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pending
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Leave Period</p>
                                    <p class="text-sm font-medium">
                                        {{ Carbon::parse($form->startDate)->format('jS M Y') }} - {{ Carbon::parse($form->endDate)->format('jS M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Duration</p>
                                    <p class="text-sm font-medium">
                                        {{ Carbon::parse($form->startDate)->diffInDays(Carbon::parse($form->endDate)) + 1 }} days
                                    </p>
                                </div>
                            </div>

                            @if($form->reason)
                                <div class="flex items-start">
                                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Reason</p>
                                        <p class="text-sm font-medium">{{ $form->reason }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="px-5 py-3 bg-gray-50 text-xs text-gray-500">
                        Requested on {{ Carbon::parse($form->created_at)->format('jS M Y, h:i A') }}
                    </div>
                </div>
            @endforeach
        </div>

     <!-- Pagination -->
     <div class="p-5 bg-gray-50 border-t border-gray-100">
        {{ $formHistory->links('vendor.tailwind') }}
    </div>
    @endif

    <script>
        function closeFormJs() {
            Livewire.dispatch('closeForm');
            document.getElementById('closeForm').style.display = 'none';
        }
    </script>
</div>
