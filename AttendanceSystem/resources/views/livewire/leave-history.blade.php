@php use Carbon\Carbon; @endphp

<div>
    <div class="container mt-4">

        <!-- New header added before the button -->
        <h4 class="text-center mb-3">Leave Application</h4>

        <div class="text-end mb-3">
            <button class="btn primaryButton" wire:click="toggleForm"
                    style="min-width: 120px; padding-right: 30px;">
                Apply
                <div wire:loading class="spinner-border spinner-border-sm text-light position-absolute" role="status"
                     style="right: 10px; top: 50%; transform: translateY(-50%);">
                    <span class="visually-hidden">Processing...</span>
                </div>
            </button>
        </div>

        @if($showForm)
            <div id="closeForm" class="card mb-4 border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Apply for Leave</h5>
                    <button id="closeFormBtn" class="btn btn-danger" onclick="closeFormJs()">Close</button>
                </div>

                <div class="card-body">
                    <form id="leaveFormContainer" wire:submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" wire:model="startDate">
                            @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" wire:model="endDate">
                            @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Leave Type</label>
                            <select class="form-control" id="type" wire:model.live="type">
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
                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        @if($type === 'Other')
                            <div class="mb-3">
                                <label for="otherReason" class="form-label">Please specify the reason</label>
                                <textarea class="form-control" id="otherReason" wire:model="reason"></textarea>
                                @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <button type="submit" class="btn primaryButton">Submit</button>
                    </form>
                </div>
            </div>
        @endif

        @if($formHistory->isEmpty())
            <div class="text-center text-muted my-5">
                <i class="fas fa-folder-open fa-3x mb-3"></i>
                <p>No leave requests at the moment.</p>
            </div>
        @else
            <h4 class="text-center mb-2">Leave History ({{count($formHistory)}})</h4>

            <div class="container mt-4">
                <div class="row">
                    @foreach($formHistory as $form)
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-light">
                                <div class="card-header bg-light text-center">
                                    <h5 class="mb-0">{{ $form->type }}</h5>
                                </div>
                                <div class="card-body">

                                    <p class="card-text">
                                        <strong>Status:</strong>
                                        @if($form->approved === true)
                                            <span class="text-success">&#10004; Approved</span>
                                        @elseif($form->approved === false)
                                            <span class="text-danger">&#10006; Denied</span>
                                        @elseif($form->approved === null)
                                            <span class="text-warning">
                                            <i class="fas fa-exclamation-circle"></i> Pending
                                        </span>
                                        @endif
                                    </p>
                                    <p class="card-text">
                                        <strong>Start:</strong> <span
                                            class="text-muted">{{ Carbon::parse($form->startDate)->format('jS M Y, h:i A') }}</span>
                                    </p>
                                    <p class="card-text">
                                        <strong>End:</strong> <span
                                            class="text-muted">{{ Carbon::parse($form->endDate)->format('jS M Y, h:i A') }}</span>
                                    </p>
                                    <p class="card-text">
                                        <strong>Date:</strong> <span
                                            class="text-muted">{{ Carbon::parse($form->created_at)->format('jS M Y, h:i A') }}</span>
                                    </p>

                                    @if($form->reason)
                                        <p class="card-text">
                                            <strong>Reason:</strong> <span
                                                class="text-muted">{{ $form->reason }}</span>
                                        </p>
                                    @endif

                                </div>
                                <div class="card-footer text-muted text-center">
                                    Last updated:
                                    <em>{{ Carbon::parse($form->updated_at)->format('jS M Y, h:i A') }}</em>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
                {{ $formHistory->links() }}
            </div>
        @endif


        <script>
            function closeFormJs() {
                Livewire.dispatch('closeForm');
                document.getElementById('closeForm').style.display = 'none';
            }
        </script>

    </div>
</div>
