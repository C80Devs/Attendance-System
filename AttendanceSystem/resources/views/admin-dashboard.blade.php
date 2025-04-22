@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Users</h2>

        <form method="GET" action="{{ route('admin-dashboard') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by first or last name"
                    value="{{ request('search') }}">
                <button type="submit" class="btn primaryButton">Search</button>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered">
            <thead style="background: var(--primaryColor); color: whitesmoke">
                <tr>
                    <th class="text-white">First Name</th>
                    <th class="text-white">Last Name</th>
                    <th class="text-white">Actions</th>
                    <th class="text-white">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->firstName }}</td>
                        <td>{{ $user->lastName }}</td>
                        <td>
                            @if (empty($user->faces))
                                <button class="btn btn-light enroll-btn" data-bs-toggle="modal"
                                    data-bs-target="#enrollModal" data-id="{{ $user->id }}"
                                    data-name="{{ $user->firstName }} {{ $user->lastName }}">
                                    Enroll
                                </button>
                            @else
                                <button class="btn btn-muted clock-in-btn" data-bs-toggle="modal"
                                    data-bs-target="#clockInModal" data-id="{{ $user->id }}"
                                    data-faces="{{ json_encode($user->faces) }}" data
                                    data-name="{{ $user->firstName }} {{ $user->lastName }}">
                                    Clock In
                                </button>
                            @endif
                        </td>
                        <td>
                            @if (!empty($user->faces))
                                <p class="text-success text-center">Face enrolled</p>
                            @else
                                <p class="text-muted text-center">No face enrolled</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($users->isEmpty())
            <p class="text-muted text-center">No users found.</p>
        @endif

        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Enroll Modal -->
    <div class="modal fade" id="enrollModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enroll User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Enrolling: <strong id="enrollUserName"></strong></p>
                    <div class="text-center" id="enrollVideoContainer">
                        <video id="enrollVideo" width="300" height="225" autoplay></video>
                    </div>
                    <div class="text-center mt-3" id="enrollControls">
                        <button class="btn btn-primary" type="button" onclick="captureFace('enroll')">Capture Face</button>
                    </div>
                    <div class="text-center mt-3" id="enrollSuccess" style="display: none;">
                        <div class="alert alert-success">Face captured successfully!</div>
                        <button class="btn btn-success" type="button" onclick="confirmEnrollment()">Confirm
                            Enrollment</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Clock In</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Clocking In: <strong id="clockInUserName"></strong></p>
                        <div class="text-center" id="clockInVideoContainer">
                            <video id="clockInVideo" width="300" height="225" autoplay></video>
                        </div>
                        <div class="text-center mt-3" id="clockInControls">
                            <button class="btn btn-primary" type="button" onclick="captureFace('clockIn')">Verify
                                Face</button>
                        </div>
                        <div class="text-center mt-3" id="clockInSuccess" style="display: none;">
                            <div class="alert alert-success">Face verified successfully!</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="clockInSubmit" style="display: none;">Confirm
                            Clock In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
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
                alert('Failed to load face recognition models. Please refresh the page.');
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
                alert('Could not access camera. Please ensure you have granted camera permissions.');
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

        // Capture face and get descriptor
        async function captureFace(type) {
            if (!modelsLoaded) {
                toastr.warning('Face recognition models are still loading. Please wait.');
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
                    return;
                }

                toastr.success('Face captured..');

                const faceDescriptor = Array.from(detections.descriptor);
                console.log('Face descriptor captured:', faceDescriptor);

                if (type === 'enroll') {
                    document.getElementById('enrollVideoContainer').style.display = 'none';
                    document.getElementById('enrollControls').style.display = 'none';
                    document.getElementById('enrollSuccess').style.display = 'block';
                    return;
                }

                // Get enrolled face descriptor
                const enrolledFaces = $('#clockInModal').data('faces');

                const userID = $('#clockInModal').data('id');

                if (!enrolledFaces || enrolledFaces.length === 0) {
                    toastr.error('No face enrolled for this user.');
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
                    formData.append('user_id', userID)

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
                    } else {
                        toastr.error(result.error || 'Clock-in failed.');
                    }
                }, () => {
                    toastr.error('Location access denied. Please enable location services.');
                });
            } catch (error) {
                console.error('Error capturing face:', error);
                toastr.error('Error processing face. Please try again.');
            }
        }

        async function confirmEnrollment() {
            if (!currentFaceDescriptor || !currentUserId) {
                alert('No face data or user ID found. Please capture face again.');
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
                    alert(data.message || 'User enrolled successfully!');
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Failed to enroll user.');
                }
            } catch (error) {
                console.error('Error enrolling user:', error);
                alert('Error: ' + error.message);
                // Reset UI to allow trying again
                $('#enrollVideoContainer').show();
                $('#enrollControls').show();
                $('#enrollSuccess').hide();
            }
        }
    </script>
@endsection
