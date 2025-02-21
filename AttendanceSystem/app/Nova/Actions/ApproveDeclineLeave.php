<?php

namespace App\Nova\Actions;

use App\Notifications\LeaveApproved;
use App\Notifications\LeaveDeclined;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\ActionFields;
use App\Models\User;

// Import the User model

class ApproveDeclineLeave extends Action
{
    use Dispatchable, Actionable, Queueable;

    public $name = 'Approve/Decline Leave Request';

    public function fields (NovaRequest $request)
    {
        return [
            Select::make('Status')
                ->options([
                    'approved' => 'Approve',
                    'declined' => 'Decline',
                ])
                ->required(),

            Textarea::make('Reason for Decline', 'reason')
                ->nullable()
                ->help('Provide a reason for declining the leave request, if applicable.')
                ->rules('required_if:status,declined'),
        ];
    }

    public function handle (ActionFields $fields, Collection $models)
    {
        foreach ($models as $leave) {
            $user = User::find($leave->userID);


            if ($fields->status === 'approved') {
                $leave->update(['approved' => true]);
                // Notify the user
                /*if ($user) { // Check if user exists
                    $user->notify(new LeaveApproved($leave));
                }*/
            } else {
                $leave->update(['approved' => false]);
                // Notify the user with the reason for decline
               /* if ($user) { // Check if user exists
                    $user->notify(new LeaveDeclined($leave, $fields->reason));
                }*/
            }
        }

        return Action::message('Leave request updated successfully!');
    }
}
