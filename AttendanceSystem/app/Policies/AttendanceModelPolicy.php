<?php

namespace App\Policies;

use App\Models\AttendanceModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;

class AttendanceModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return  true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AttendanceModel $attendanceModel): bool
    {
        return true;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Nova::whenServing(function(NovaRequest $request) use ($user) {
            return false;
        }, function(Request $request) use ($user) {
            return true;
        });
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AttendanceModel $attendanceModel): bool
    {
        return true;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AttendanceModel $attendanceModel): bool
    {
        return true;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AttendanceModel $attendanceModel): bool
    {
        return true;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AttendanceModel $attendanceModel): bool
    {
        return true;

    }
}
