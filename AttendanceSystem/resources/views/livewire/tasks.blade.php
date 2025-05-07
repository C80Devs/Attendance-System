@php use Carbon\Carbon; @endphp

<div class="mb-4">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <button
            wire:click="toggleForm"
            class="inline-flex items-center justify-center px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 relative"
        >
            <span>{{ $editingTaskId ? 'Edit Task' : 'Create Task' }}</span>
            <div wire:loading class="absolute right-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </button>
    </div>

    <!-- Task Form -->
    @if($showForm)
        <div id="task-form" class="bg-white rounded-xl shadow-card mb-6 overflow-hidden">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">{{ $editingTaskId ? 'Edit Task' : 'Create New Task' }}</h3>
                <button
                    onclick="closeTaskForm()"
                    class="inline-flex items-center justify-center p-2 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-lg transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-5">
                <form wire:submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Task Title</label>
                        <input
                            type="text"
                            id="title"
                            wire:model="title"
                            placeholder="Enter task title"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input
                                type="date"
                                id="start_date"
                                wire:model="start_date"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                            @error('start_date')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input
                                type="date"
                                id="end_date"
                                wire:model="end_date"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                            @error('end_date')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Task Description</label>
                        <textarea
                            id="description"
                            wire:model="description"
                            rows="3"
                            placeholder="Description"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        ></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50"
                        >
                            {{ $editingTaskId ? 'Update Task' : 'Save Task' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Task Count Badge -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Tasks</h2>
        <span class="text-xs font-medium px-2 py-1 bg-accent/10 text-accent rounded-full">{{ count($tasks) }} {{ Str::plural('Task', count($tasks)) }}</span>
    </div>

    <!-- Empty State -->
    @if($tasks->isEmpty())
        <div class="bg-gray-50 rounded-xl p-8 text-center shadow-sm">
            <div class="w-16 h-16 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-700 mb-1">No Tasks Available</h3>
            <p class="text-gray-500">Click "Create Task" to get started with your first task.</p>
        </div>
    @else
        <!-- Tasks List -->
        @php
            $groupedTasks = $tasks->getCollection()->groupBy(function($task) {
                return Carbon::parse($task->start_date)->format('M d, Y');
            });
        @endphp

        @foreach($groupedTasks as $date => $tasksForDate)
            <div class="mb-6 last:mb-0">
                <!-- Date Header -->
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 rounded-full bg-accent/10 flex items-center justify-center text-accent mr-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-md font-medium text-gray-700">{{ $date }}</h3>
                </div>

                <!-- Tasks Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($tasksForDate as $task)
                        <div class="bg-white rounded-xl shadow-card hover:shadow-card-hover transition-all overflow-hidden">
                            <div class="p-4">
                                <div class="flex items-start">
                                    <!-- Checkbox -->
                                    <div class="mr-3 pt-0.5">
                                        <input
                                            type="checkbox"
                                            wire:click="markCompleted({{ $task->id }})"
                                            {{ $task->complete ? 'checked' : '' }}
                                            class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary"
                                        >
                                    </div>

                                    <!-- Task Content -->
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between mb-1">
                                            <h4 class="font-medium text-gray-800 {{ $task->complete ? 'line-through text-gray-400' : '' }} {{ $task->overDue() ? 'text-danger' : '' }}">
                                                {{ $task->title }}
                                            </h4>

                                            @if($task->overDue())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-danger/10 text-danger">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    OVERDUE
                                                </span>
                                            @endif
                                        </div>

                                        @if($task->description)
                                            <p class="text-sm text-gray-500 mb-2 {{ $task->complete ? 'text-gray-400' : '' }}">
                                                {{ $task->description }}
                                            </p>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <div class="text-xs text-gray-500">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {{ Carbon::parse($task->start_date)->format('M d') }} - {{ Carbon::parse($task->end_date)->format('M d, Y') }}
                                                </span>
                                            </div>

                                            <button
                                                wire:click="editTask({{ $task->id }})"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition-colors"
                                            >
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
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

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $tasks->links() }}
        </div>
    @endif

    <script>
        function closeTaskForm() {
            Livewire.dispatch('closeForm');
        }
    </script>
</div>
