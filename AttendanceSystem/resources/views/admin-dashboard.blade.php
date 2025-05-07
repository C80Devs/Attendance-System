
<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage users and their face recognition enrollment</p>
        </div>

        <!-- Search Form -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin-dashboard') }}" class="flex gap-2 md:w-96">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm" placeholder="Search by first or last name" value="{{ request('search') }}">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Search
                </button>
            </form>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-primary">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">First Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Last Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->firstName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->lastName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if (empty($user->faces))
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 enroll-btn" data-bs-toggle="modal" data-bs-target="#enrollModal" data-id="{{ $user->id }}" data-name="{{ $user->firstName }} {{ $user->lastName }}">
                                            <svg class="mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Enroll</span>
                                        </button>
                                    @else
                                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 clock-in-btn" data-bs-toggle="modal" data-bs-target="#clockInModal" data-id="{{ $user->id }}" data-faces="{{ json_encode($user->faces) }}" data-name="{{ $user->firstName }} {{ $user->lastName }}">
                                            <svg class="mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Clock In</span>
                                        </button>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if (!empty($user->faces))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Face enrolled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            No face enrolled
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($users->isEmpty())
                <div class="px-6 py-10 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
                </div>
            @endif
        </div>

       <!-- Pagination -->
       <div class="p-5 bg-gray-50 border-t border-gray-100">
        {{ $users->links('vendor.tailwind') }}
    </div>
    </div>

    <!-- Enroll Modal -->
    <div class="modal fade" id="enrollModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-lg shadow-xl">
                <div class="modal-header bg-gray-50 p-4 rounded-t-lg">
                    <h5 class="modal-title text-lg font-medium text-gray-900">Enroll User</h5>
                    <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" data-bs-dismiss="modal">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body p-6">
                    <p class="text-sm text-gray-600 mb-4">Enrolling: <strong id="enrollUserName" class="text-gray-900"></strong></p>
                    <div class="text-center bg-gray-100 p-4 rounded-lg" id="enrollVideoContainer">
                        <video id="enrollVideo" class="mx-auto rounded shadow-sm" width="300" height="225" autoplay></video>
                    </div>
                    <div class="text-center mt-4" id="enrollControls">
                        <button id="captureFaceBtn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" type="button" onclick="captureFace('enroll')">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span id="captureFaceBtnText">Capture Face</span>
                            <svg id="captureFaceSpinner" class="animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="text-center mt-4" id="enrollSuccess" style="display: none;">
                        <div class="rounded-md bg-green-50 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">Face captured successfully!</p>
                                </div>
                            </div>
                        </div>
                        <button id="confirmEnrollBtn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" type="button" onclick="confirmEnrollment()">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span id="confirmEnrollBtnText">Confirm Enrollment</span>
                            <svg id="confirmEnrollSpinner" class="animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="modal-footer bg-gray-50 px-4 py-3 rounded-b-lg">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Clock In Modal -->
    <div class="modal fade" id="clockInModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('users.clock-in') }}">
                @csrf
                <input type="hidden" name="user_id" id="clockInUserId">
                <input type="hidden" name="face_descriptor" id="clockInFaceDescriptor">
                <div class="modal-content rounded-lg shadow-xl">
                    <div class="modal-header bg-gray-50 p-4 rounded-t-lg">
                        <h5 class="modal-title text-lg font-medium text-gray-900">Clock In</h5>
                        <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" data-bs-dismiss="modal">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body p-6">
                        <p class="text-sm text-gray-600 mb-4">Clocking In: <strong id="clockInUserName" class="text-gray-900"></strong></p>
                        <div class="text-center bg-gray-100 p-4 rounded-lg" id="clockInVideoContainer">
                            <video id="clockInVideo" class="mx-auto rounded shadow-sm" width="300" height="225" autoplay></video>
                        </div>
                        <div class="text-center mt-4" id="clockInControls">
                            <button id="verifyFaceBtn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" type="button" onclick="captureFace('clockIn')">
                                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span id="verifyFaceBtnText">Verify Face</span>
                                <svg id="verifyFaceSpinner" class="animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-center mt-4" id="clockInSuccess" style="display: none;">
                            <div class="rounded-md bg-green-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">Face verified successfully!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-gray-50 px-4 py-3 rounded-b-lg">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="clockInSubmit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" style="display: none;">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span id="clockInSubmitText">Confirm Clock In</span>
                            <svg id="clockInSubmitSpinner" class="animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Variables to store video streams and face descriptors
        let enrollVideoStream, clockInVideoStream;
        let modelsLoaded = false;
        let currentFaceDescriptor = null;
        let currentUserId = null;

        // Load face-api.js models
        async function loadModels() {
            try {
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri('/models/tiny_face_detector'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('/models/face_landmark_68'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('/models/face_recognition'),
                ]);
                modelsLoaded = true;
                console.log('Models loaded successfully');
            } catch (error) {
                console.error('Error loading models:', error);
                toastr.error('Failed to load face recognition models. Please refresh the page.');
            }
        }

        // Initialize when modal opens
        document.addEventListener('DOMContentLoaded', function() {
            loadModels();

            // Enroll modal setup
            $('#enrollModal').on('shown.bs.modal', async function(event) {
                const button = $(event.relatedTarget);
                currentUserId = button.data('id');
                const userName = button.data('name');

                $('#enrollUserName').text(userName);
                $('#enrollVideoContainer').show();
                $('#enrollControls').show();
                $('#enrollSuccess').hide();
                currentFaceDescriptor = null;

                const video = document.getElementById('enrollVideo');
                await startVideo(video, 'enroll');
            });

            // Clock-in modal setup
            $('#clockInModal').on('shown.bs.modal', async function(event) {
                const button = $(event.relatedTarget);
                const userId = button.data('id');
                const userName = button.data('name');
                const faces = button.data('faces');

                $('#clockInUserId').val(userId);
                $('#clockInUserName').text(userName);
                $('#clockInModal').data('faces', faces);
                $('#clockInModal').data('id', userId);

                $('#clockInVideoContainer').show();
                $('#clockInControls').show();
                $('#clockInSuccess').hide();
                $('#clockInSubmit').hide();
                currentFaceDescriptor = null;

                const video = document.getElementById('clockInVideo');
                await startVideo(video, 'clockIn');
            });

            // Clean up when modal closes
            $('.modal').on('hidden.bs.modal', function() {
                stopVideoStream();
                currentFaceDescriptor = null;
                currentUserId = null;
            });

            // Add loading state to clock in submit button
            $('#clockInSubmit').on('click', function() {
                showButtonLoading('clockInSubmit');
            });
        });

        // Start video stream
        async function startVideo(videoElement, type) {
            try {
                if (!modelsLoaded) {
                    await loadModels();
                }

                if (videoElement.srcObject) {
                    videoElement.srcObject.getTracks().forEach(track => track.stop());
                }

                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user'
                    } // Force front camera
                });
                videoElement.srcObject = stream;

                if (type === 'enroll') {
                    enrollVideoStream = stream;
                } else {
                    clockInVideoStream = stream;
                }
            } catch (error) {
                console.error('Error accessing camera:', error);
                toastr.error('Could not access camera. Please ensure you have granted camera permissions.');
            }
        }

        // Stop video stream
        function stopVideoStream() {
            if (enrollVideoStream) {
                enrollVideoStream.getTracks().forEach(track => track.stop());
                enrollVideoStream = null;
            }
            if (clockInVideoStream) {
                clockInVideoStream.getTracks().forEach(track => track.stop());
                clockInVideoStream = null;
            }
        }

        // Helper function to show loading state on buttons
        function showButtonLoading(buttonId) {
            const button = document.getElementById(buttonId);
            const textSpan = document.getElementById(buttonId + 'Text');
            const spinner = document.getElementById(buttonId + 'Spinner');

            if (button && textSpan && spinner) {
                button.disabled = true;
                spinner.style.display = 'inline-block';
            }
        }

        // Helper function to hide loading state on buttons
        function hideButtonLoading(buttonId) {
            const button = document.getElementById(buttonId);
            const textSpan = document.getElementById(buttonId + 'Text');
            const spinner = document.getElementById(buttonId + 'Spinner');

            if (button && textSpan && spinner) {
                button.disabled = false;
                spinner.style.display = 'none';
            }
        }

        // Capture face and get descriptor
        async function captureFace(type) {
            // Show loading state
            const buttonId = type === 'enroll' ? 'captureFaceBtn' : 'verifyFaceBtn';
            showButtonLoading(buttonId);

            if (!modelsLoaded) {
                toastr.warning('Face recognition models are still loading. Please wait.');
                hideButtonLoading(buttonId);
                return;
            }

            const videoElement = type === 'enroll' ?
                document.getElementById('enrollVideo') :
                document.getElementById('clockInVideo');

            const displayName = type === 'enroll' ?
                document.getElementById('enrollUserName').textContent :
                document.getElementById('clockInUserName').textContent;

            try {
                // Detect face
                const detections = await faceapi.detectSingleFace(
                    videoElement,
                    new faceapi.TinyFaceDetectorOptions()
                ).withFaceLandmarks().withFaceDescriptor();

                if (!detections) {
                    toastr.error('No face detected. Please position your face clearly in the frame.');
                    hideButtonLoading(buttonId);
                    return;
                }

                // Store the face descriptor
                const faceDescriptor = Array.from(detections.descriptor);
                console.log('Face descriptor captured:', faceDescriptor);

                // Store the face descriptor for enrollment
                if (type === 'enroll') {
                    currentFaceDescriptor = faceDescriptor;
                    document.getElementById('enrollVideoContainer').style.display = 'none';
                    document.getElementById('enrollControls').style.display = 'none';
                    document.getElementById('enrollSuccess').style.display = 'block';
                    hideButtonLoading(buttonId);
                    return;
                }

                // Get enrolled face descriptor
                const enrolledFaces = $('#clockInModal').data('faces');
                const userID = $('#clockInModal').data('id');

                if (!enrolledFaces || enrolledFaces.length === 0) {
                    toastr.error('No face enrolled for this user.');
                    hideButtonLoading(buttonId);
                    return;
                }

                const enrolledDescriptor = new Float32Array(enrolledFaces);
                const currentDescriptor = new Float32Array(faceDescriptor);
                const distance = faceapi.euclideanDistance(currentDescriptor, enrolledDescriptor);
                const threshold = 0.6;

                console.log('Face distance:', distance);

                // Get user location before sending request
                navigator.geolocation.getCurrentPosition(async (position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    // Prepare form data for API request
                    const formData = new FormData();
                    formData.append('latitude', userLat);
                    formData.append('longitude', userLng);
                    formData.append('user_id', userID);

                    // If face does not match, capture and send image
                    if (distance > threshold) {
                        toastr.warning('Face mismatch detected. Capturing image...');

                        const canvas = document.createElement('canvas');
                        canvas.width = videoElement.videoWidth;
                        canvas.height = videoElement.videoHeight;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

                        const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg'));
                        formData.append('face_image', blob, 'face.jpg');
                    }

                    // Send clock-in request
                    const response = await fetch("{{ route('users.clock-in') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData,
                    });

                    const result = await response.json();

                    if (response.ok) {
                        toastr.success(result.success || 'Clocked In!');
                        document.getElementById('clockInVideoContainer').style.display = 'none';
                        document.getElementById('clockInControls').style.display = 'none';
                        document.getElementById('clockInSuccess').style.display = 'block';
                        document.getElementById('clockInSubmit').style.display = 'inline-flex';
                    } else {
                        toastr.error(result.error || 'Clock-in failed.');
                    }

                    hideButtonLoading(buttonId);
                }, () => {
                    toastr.error('Location access denied. Please enable location services.');
                    hideButtonLoading(buttonId);
                });
            } catch (error) {
                console.error('Error capturing face:', error);
                toastr.error('Error processing face. Please try again.');
                hideButtonLoading(buttonId);
            }
        }

        async function confirmEnrollment() {
            // Show loading state
            showButtonLoading('confirmEnrollBtn');

            if (!currentFaceDescriptor || !currentUserId) {
                console.log('Face descriptor:', currentFaceDescriptor);
                console.log('User ID:', currentUserId);
                toastr.error('No face data or user ID found. Please capture face again.');
                hideButtonLoading('confirmEnrollBtn');
                return;
            }

            try {
                const response = await fetch('{{ route('users.enroll') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: currentUserId,
                        face_descriptor: currentFaceDescriptor
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    $('#enrollModal').modal('hide');
                    toastr.success(data.message || 'User enrolled successfully!');
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Failed to enroll user.');
                }
            } catch (error) {
                console.error('Error enrolling user:', error);
                toastr.error('Error: ' + error.message);
                // Reset UI to allow trying again
                $('#enrollVideoContainer').show();
                $('#enrollControls').show();
                $('#enrollSuccess').hide();
                hideButtonLoading('confirmEnrollBtn');
            }
        }
    </script>
</x-app-layout>
