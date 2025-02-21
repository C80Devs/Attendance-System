<?php

namespace App\Livewire;

use App\Models\LeaveModel;
use App\Models\SettingsModel;
use App\Models\User;
use App\Traits\NotifySuperAdmins;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LeaveHistory extends Component
{
    use NotifySuperAdmins;

    public $startDate;
    public $endDate;
    public $type;
    public $reason;
    public $department;

    public $showForm = false;

    protected $rules = [
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'type' => 'required|string|max:255',
        'reason' => 'nullable|string|max:500',
    ];

    public function toggleForm (): void
    {
        // Fetch settings
        $settings = SettingsModel::first();

        // Check if leave is active
        if (!$settings->leave_active) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Leave functionality is currently disabled.']);
            return;
        }

        $userId = Auth::id();

        // Check for active leave applications
        $activeLeave = LeaveModel::where('userID', $userId)
            ->whereNull('approved')
            ->exists();

        if ($activeLeave) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'You already have an active leave application.']);
            return;
        }

        // Check for monthly leave application limit
        $existingLeaveCount = LeaveModel::where('userID', $userId)
            ->whereMonth('created_at', now()->month)
            ->count();

        if ($existingLeaveCount >= 2) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'You already have 2 leave applications for this month.']);
            return;
        }

        // Check if the user has exceeded their leave days
        $totalLeaveDaysTaken = $this->calculateTotalLeaveDaysTaken($userId);
        $allowedLeaveDays = $settings->no_of_leave_days;

        if ($totalLeaveDaysTaken >= $allowedLeaveDays) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'You have exceeded your allowed leave days for this year.']);
            return;
        }

        $this->showForm = !$this->showForm;
    }

    protected $listeners = ['closeForm'];

    public function closeForm ()
    {
        $this->showForm = false;
    }

    /**
     * @throws ValidationException
     */
    public function submitForm ()
    {
        try {
            $this->validate();

            // Fetch settings
            $settings = SettingsModel::first();

            // Check if leave is active
            if (!$settings->leave_active) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'Leave functionality is currently disabled.']);
                return;
            }

            $userId = Auth::id();

            // Check if the user has exceeded their leave days
            $totalLeaveDaysTaken = $this->calculateTotalLeaveDaysTaken($userId);
            $allowedLeaveDays = $settings->no_of_leave_days;

            if ($totalLeaveDaysTaken >= $allowedLeaveDays) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'You have exceeded your allowed leave days for this year.']);
                return;
            }

            $startDate = Carbon::parse($this->startDate);
            $endDate = Carbon::parse($this->endDate);
            $leaveDays = $endDate->diffInDays($startDate) + 1;

            if (($totalLeaveDaysTaken + $leaveDays) > $allowedLeaveDays) {
                $this->dispatch('alert', ['type' => 'error', 'message' => 'This leave application will exceed your allowed leave days.']);
                return;
            }

            $leave = LeaveModel::create([
                'userID' => $userId,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'type' => $this->type,
                'reason' => $this->reason,
                'approved' => null,
            ]);

            $date = Carbon::now();
            $this->notifySuperAdmins(Auth::user()->firstName . " has applied for leave on $date.", 'calendar', $leave->id);

            $this->reset(['startDate', 'endDate', 'type', 'reason']);
            $this->showForm = false;
            $this->dispatch('alert', ['type' => 'success', 'message' => 'Leave applied successfully.']);

        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->first();
            $this->dispatch('alert', ['type' => 'error', 'message' => $errors]);
            throw $e;
        }
    }

    public function render ()
    {
        $formHistory = LeaveModel::where('userID', Auth::id())->simplePaginate(8);

        return view('livewire.leave-history', [
            'formHistory' => $formHistory
        ]);
    }

    /**
     * Calculate the total number of leave days taken by the user.
     *
     * @param int $userId
     * @return int
     */
    private function calculateTotalLeaveDaysTaken (int $userId): int
    {
        $leaves = LeaveModel::where('userID', $userId)
            ->whereNotNull('approved')
            ->where('approved', true)
            ->whereYear('startDate', Carbon::now()->year)
            ->get();

        $totalDays = 0;

        foreach ($leaves as $leave) {
            $startDate = Carbon::parse($leave->startDate);
            $endDate = Carbon::parse($leave->endDate);
            $totalDays += $endDate->diffInDays($startDate) + 1;
        }

        return $totalDays;
    }
}
