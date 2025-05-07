<x-app-layout>
    <div class="mb-4">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Employee Directory</h2>
            <span class="text-xs font-medium px-2 py-1 bg-primary/10 text-primary rounded-full">{{ $users->total() }} {{ Str::plural('Employee', $users->total()) }}</span>
        </div>

        <!-- Employee Grid -->
        @if($users->isEmpty())
            <div class="bg-gray-50 rounded-xl p-8 text-center shadow-sm">
                <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-1">No Employees Found</h3>
                <p class="text-gray-500">There are no employees in the system yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                @foreach($users as $user)
                    <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all overflow-hidden">
                        <!-- Employee Header -->
                        <div class="p-5 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white text-lg font-bold mr-3">
                                    {{ substr($user->firstName, 0, 1) }}{{ substr($user->lastName ?? '', 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $user->firstName }} {{ $user->lastName }}</h3>
                                    <p class="text-sm text-gray-500">Employee</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="p-5 space-y-3">
                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <a href="tel:{{ $user->phone }}" class="text-sm font-medium text-primary hover:text-primary-dark transition-colors">
                                        {{ $user->phone }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary mr-3 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <a href="mailto:{{ $user->email }}" class="text-sm font-medium text-primary hover:text-primary-dark transition-colors">
                                        {{ $user->email }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Action Footer -->
                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex justify-center">
                            @if(auth()->user()->super_admin)
                                <a
                                    href="/admin/resources/users/{{ $user->id }}"
                                    class="inline-flex items-center px-3 py-1.5 border border-primary text-sm font-medium rounded-lg text-primary hover:bg-primary hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Profile
                                </a>
                            @else
                                <button
                                    disabled
                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-gray-50 cursor-not-allowed"
                                >
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Profile
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="p-5 bg-gray-50 border-t border-gray-100">
                {{ $users->links('vendor.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
