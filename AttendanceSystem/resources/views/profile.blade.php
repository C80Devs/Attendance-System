<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Update Profile</h2>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Section -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Personal Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- First Name -->
                                <div>
                                    <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" id="firstName" name="firstName"
                                           value="{{ old('firstName', auth()->user()->firstName) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                    @error('firstName')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" id="lastName" name="lastName"
                                           value="{{ old('lastName', auth()->user()->lastName) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                    @error('lastName')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Birthday -->
                            <div class="mt-4">
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Birthday</label>
                                <input type="date" id="date_of_birth" name="date_of_birth"
                                       value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Change Password</h3>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password (leave blank if not changing)</label>
                                <input type="password" id="password" name="password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            </div>
                        </div>

                        <!-- Next of Kin Section -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Next of Kin Details</h3>

                            <!-- Next of Kin's Name -->
                            <div class="mb-4">
                                <label for="nok_name" class="block text-sm font-medium text-gray-700 mb-1">Next of Kin's Name</label>
                                <input type="text" id="nok_name" name="nok_name"
                                       value="{{ old('nok_name', auth()->user()->nok_name) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                @error('nok_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Next of Kin's Address -->
                            <div class="mb-4">
                                <label for="nok_address" class="block text-sm font-medium text-gray-700 mb-1">Next of Kin's Address</label>
                                <input type="text" id="nok_address" name="nok_address"
                                       value="{{ old('nok_address', auth()->user()->nok_address) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                @error('nok_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Next of Kin's Phone -->
                                <div>
                                    <label for="nok_phone" class="block text-sm font-medium text-gray-700 mb-1">Next of Kin's Phone</label>
                                    <input type="text" id="nok_phone" name="nok_phone"
                                           value="{{ old('nok_phone', auth()->user()->nok_phone) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                    @error('nok_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Next of Kin's Email -->
                                <div>
                                    <label for="nok_email" class="block text-sm font-medium text-gray-700 mb-1">Next of Kin's Email (optional)</label>
                                    <input type="email" id="nok_email" name="nok_email"
                                           value="{{ old('nok_email', auth()->user()->nok_email) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                                    @error('nok_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-primary text-white font-medium rounded-md shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
