<?php

namespace App\Traits;

use App\Models\User;
use Laravel\Nova\Notifications\NovaNotification;

trait NotifySuperAdmins
{
    /**
     * Notify all super admins with a custom message.
     *
     * @param string $message
     * @param string $icon
     * @param int $leaveId
     * @return void
     */
    public function notifySuperAdmins (string $message, string $icon, int $leaveId)
    {
        $superAdmins = User::where('super_admin', true)->get();

        foreach ($superAdmins as $user) {
            $user->notify(
                NovaNotification::make()
                    ->message($message)
                    ->icon($icon)
                    ->type('info')
                    ->action('View', ('/resources/leave-requests/' . $leaveId))
            );
        }
    }

    public function notifySuperAdminsTasks (string $message, string $icon, int $id)
    {
        $superAdmins = User::where('super_admin', true)->get();

        foreach ($superAdmins as $user) {
            $user->notify(
                NovaNotification::make()
                    ->message($message)
                    ->icon($icon)
                    ->type('info')
                    ->action('View', ('/resources/tasks/' . $id))
            );
        }
    }
}
