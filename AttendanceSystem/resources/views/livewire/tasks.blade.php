@php use Carbon\Carbon; @endphp
<div class="container mt-4">

    <style>
        .task-card {
            font-size: 0.9rem;
        }

        .task-card h6 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .task-card small {
            font-size: 0.8rem;
        }

        .task-card .card-body {
            padding: 0.75rem;
        }

        .badge {
            font-size: 0.75rem;
        }
    </style>

    <script>
        function closeTaskForm() {
            Livewire.dispatch('closeForm');
        }
    </script>

    <h4 class="text-center mb-4 fw-bold bg-light py-2">Tasks ({{ count($tasks) }})</h4>

    <div class="text-end mb-4">
        <button class="btn bgPrimary text-white position-relative shadow-sm" wire:click="toggleForm"
                style="min-width: 120px;">
            @if($editingTaskId)
                Edit Task
            @else
                Create Task
            @endif
            <div wire:loading class="spinner-border spinner-border-sm text-light position-absolute" role="status"
                 style="right: 10px; top: 50%; transform: translateY(-50%);">
                <span class="visually-hidden">Processing...</span>
            </div>
        </button>
    </div>

    @if($showForm)
        <div class="card mb-4 border-0 shadow-sm" id="task-form">
            <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                <h5 class="mb-0 fw-bold">
                    @if($editingTaskId)
                        Edit Task
                    @else
                        Create New Task
                    @endif
                </h5>
                <!-- X button calls JS function to close the form -->
                <button class="btn-close" aria-label="Close" onclick="closeTaskForm()"></button>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="submitForm">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Task Title</label>
                        <input type="text" class="form-control shadow-sm" id="title" wire:model="title"
                               placeholder="Enter task title">
                        @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label fw-medium">Start Date</label>
                            <input type="date" class="form-control shadow-sm" id="start_date" wire:model="start_date">
                            @error('start_date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label fw-medium">End Date</label>
                            <input type="date" class="form-control shadow-sm" id="end_date" wire:model="end_date">
                            @error('end_date') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Task Description</label>
                        <textarea class="form-control shadow-sm" id="description" wire:model="description"
                                  placeholder="Description" rows="3"></textarea>
                        @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn bgPrimary text-white shadow-sm">
                        @if($editingTaskId)
                            Update Task
                        @else
                            Save Task
                        @endif
                    </button>
                </form>
            </div>
        </div>
    @endif

    @if($tasks->isEmpty())
        <div class="text-center text-muted my-5 py-5">
            <i class="fas fa-folder-open fa-3x mb-3 text-secondary"></i>
            <p class="fw-medium">No tasks available. Click "Create Task" to get started.</p>
        </div>
    @else
        @php
            $groupedTasks = $tasks->getCollection()->groupBy(function($task) {
                return Carbon::parse($task->start_date)->format('M d, Y');
            });
        @endphp

        @foreach($groupedTasks as $date => $tasksForDate)
            <div class="mb-5">
                <h6 class="mb-3 border-bottom pb-2">{{ $date }}</h6>
                <div class="row">
                    @foreach($tasksForDate as $task)
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm border-0 task-card">
                                <div class="card-body p-2">
                                    <div class="d-flex flex-column">
                                        <!-- Checkbox on its own line, top left -->
                                        <div class="mb-2">
                                            <input type="checkbox"
                                                   style="width: 30px; height: 30px; background-color: var(--primaryColor)"
                                                   class="form-check-input"
                                                   wire:click="markCompleted({{ $task->id }})"
                                                {{ $task->complete ? 'checked' : '' }}>
                                        </div>
                                        <!-- Task details -->
                                        <div>
                                            <h6 class="fw-normal mb-1 {{ $task->overDue() ? 'text-danger' : '' }} {{ $task->complete ? 'text-decoration-line-through text-muted' : '' }}">
                                                {{ $task->title }}
                                            </h6>
                                            @if ($task->overDue())
                                                <span class="badge bg-danger text-white py-1">OVERDUE</span>
                                            @endif
                                            @if($task->description)
                                                <p class="small text-muted mb-0">{{ $task->description }}</p>
                                            @endif
                                            <div>
                                                <small class="text-muted fw-medium">
                                                    {{ Carbon::parse($task->start_date)->format('M d, Y') }}
                                                </small>
                                                -
                                                <small class="text-muted fw-medium">
                                                    {{ Carbon::parse($task->end_date)->format('M d, Y') }}
                                                </small>
                                            </div>
                                        </div>
                                        <!-- Edit button on its own line -->
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-secondary border-secondary"
                                                    wire:click="editTask({{ $task->id }})">Edit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    @endif
</div>
