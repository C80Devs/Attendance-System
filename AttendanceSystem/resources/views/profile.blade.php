@include('partials.header')

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Update Profile</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-light shadow-sm" style="border-radius: 10px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0 text-center">Edit Your Details</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- First Name -->
                        <div class="mb-4">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName"
                                   value="{{ old('firstName', auth()->user()->firstName) }}" required>
                            @error('firstName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-4">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName"
                                   value="{{ old('lastName', auth()->user()->lastName) }}" required>
                            @error('lastName') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Birthday -->
                        <div class="mb-4">
                            <label for="date_of_birth" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                   value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}" required>
                            @error('date_of_birth') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">New Password (leave blank if not changing)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation">
                        </div>

                        <!-- Next of Kin Section -->
                        <hr class="my-4">
                        <h5 class="text-center">Next of Kin Details</h5>
                        <hr class="mb-4">

                        <!-- Next of Kin's Name -->
                        <div class="mb-4">
                            <label for="nok_name" class="form-label">Next of Kin's Name</label>
                            <input type="text" class="form-control" id="nok_name" name="nok_name"
                                   value="{{ old('nok_name', auth()->user()->nok_name) }}" required>
                            @error('nok_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Next of Kin's Address -->
                        <div class="mb-4">
                            <label for="nok_address" class="form-label">Next of Kin's Address</label>
                            <input type="text" class="form-control" id="nok_address" name="nok_address"
                                   value="{{ old('nok_address', auth()->user()->nok_address) }}" required>
                            @error('nok_address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Next of Kin's Phone -->
                        <div class="mb-4">
                            <label for="nok_phone" class="form-label">Next of Kin's Phone</label>
                            <input type="text" class="form-control" id="nok_phone" name="nok_phone"
                                   value="{{ old('nok_phone', auth()->user()->nok_phone) }}" required>
                            @error('nok_phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Next of Kin's Email -->
                        <div class="mb-4">
                            <label for="nok_email" class="form-label">Next of Kin's Email (optional)</label>
                            <input type="text" class="form-control" id="nok_email" name="nok_email"
                                   value="{{ old('nok_email', auth()->user()->nok_email) }}">
                            @error('nok_email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid ">
                            <button type="submit" class="btn btn-light btn-lg">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
