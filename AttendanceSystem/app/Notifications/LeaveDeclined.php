<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveDeclined extends Notification
{
    use Queueable;

    // Include Queueable if you want to queue the notification

    protected $leave;
    protected $reason;

    public function __construct ($leave, $reason)
    {
        $this->leave = $leave;
        $this->reason = $reason;
    }

    public function via ($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail ($notifiable)
    {
        return (new MailMessage)
            ->subject('Leave Request Declined')
            ->greeting('Hello ' . $notifiable->firstName . ',')
            ->line('We regret to inform you that your leave request has been declined.')
            ->line('Leave Type: ' . $this->leave->type)
            ->line('Start Date: ' . $this->leave->startDate->toFormattedDateString())
            ->line('End Date: ' . $this->leave->endDate->toFormattedDateString())
            ->line('Reason for Decline: ' . ($this->reason ?: 'Not specified'))
            ->line('If you have any questions, please contact your HR.');
    }

    public function toArray ($notifiable)
    {
        return [
            'leave_id' => $this->leave->id, // Store leave ID for reference
            'leave_type' => $this->leave->type, // Store leave type
            'start_date' => $this->leave->startDate->toFormattedDateString(), // Store start date
            'end_date' => $this->leave->endDate->toFormattedDateString(), // Store end date
            'reason' => $this->reason, // Store the reason for decline
            'message' => 'We regret to inform you that your leave request has been declined.', // Custom message
        ];
    }
}
