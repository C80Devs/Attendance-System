<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\SettingsModel;
use App\Traits\NotifySuperAdmins;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TasksComponent extends Component
{
    use NotifySuperAdmins;

    #[Validate('required|string|max:255')]
    public $title;

    #[Validate('required|date')]
    public $start_date;

    #[Validate('required|date|after_or_equal:start_date')]
    public $end_date;

    #[Validate('required|string|max:500')]
    public $description;

    #[Validate('required|in:pending,in_progress,completed')]
    public $status = 'pending';


    // Property for editing
    public $editingTaskId = null;

    public $showForm = false;


    protected $listeners = ['closeForm'];

    public function toggleForm (): void
    {
        $settings = SettingsModel::first();
        if (!$settings->task_active) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Task functionality is currently disabled.']);
            return;
        }

        if ($this->showForm && $this->editingTaskId) {
            $this->editingTaskId = null;
            $this->reset(['title', 'start_date', 'end_date', 'description', 'status']);
            $this->resetValidation();
        }
        $this->showForm = !$this->showForm;
    }

    public function closeForm (): void
    {
        $this->reset(['title', 'start_date', 'end_date', 'description', 'status']);
        $this->resetValidation();
        $this->showForm = false;
        $this->editingTaskId = null;
    }

    public function markCompleted ($taskId): void
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->status = $task->status === 'completed' ? 'pending' : 'completed';
            $task->complete = !$task->complete;
            $task->save();
            session()->flash('message', 'Task status updated.');
        }
    }

    /**
     * Load task data into form for editing.
     */
    public function editTask ($taskId): void
    {
        $task = Task::find($taskId);
        if ($task) {
            $this->title = $task->title;
            $this->start_date = Carbon::parse($task->start_date)->format('Y-m-d');
            $this->end_date = Carbon::parse($task->end_date)->format('Y-m-d');
            $this->description = $task->description;
            $this->status = $task->status;
            $this->editingTaskId = $taskId;
            $this->showForm = true;
        }
    }


    public function submitForm ()
    {
        $this->validate();

        $settings = SettingsModel::first();
        if (!$settings->task_active) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Task functionality is currently disabled.']);
            return;
        }

        $userId = Auth::id();

        if ($this->editingTaskId) {
            // Update existing task
            $task = Task::find($this->editingTaskId);
            if ($task) {
                $task->update([
                    'title' => $this->title,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'description' => $this->description,
                    'status' => $this->status,
                ]);
                session()->flash('message', 'Task updated successfully.');
            }
            $this->editingTaskId = null;
        } else {
            // Create a new task
            $task = Task::create([
                'title' => $this->title,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'description' => $this->description,
                'status' => $this->status,
                'userID' => $userId,
                'complete' => false,
            ]);
            $date = Carbon::now();
            $this->notifySuperAdminsTasks(Auth::user()->firstName . " has created a new task on $date.", 'tasks', $task->id);
            session()->flash('message', 'Task created successfully.');
        }

        $this->reset(['title', 'start_date', 'end_date', 'description', 'status']);
        $this->showForm = false;
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Task processed successfully.']);
        $this->resetValidation();
    }

    public function render (): View|Factory|Application
    {
        $tasks = Task::where('userID', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(8);

        return view('livewire.tasks', [
            'tasks' => $tasks,
        ]);
    }
}
