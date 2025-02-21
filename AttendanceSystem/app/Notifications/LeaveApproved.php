<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveApproved extends Notification
{
    use Queueable;

    // Include Queueable if you want to queue the notification

    protected $leave;

    public function __construct ($leave)
    {
        $this->leave = $leave;
    }

    public function via ($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail ($notifiable)
    {
        return (new MailMessage)
            ->subject('Leave Request Approved')
            ->greeting('Hello ' . $notifiable->firstName . ',')
            ->line('Your leave request has been approved.')
            ->line('Leave Type: ' . $this->leave->type)
            ->line('Start Date: ' . $this->leave->startDate->toFormattedDateString())
            ->line('End Date: ' . $this->leave->endDate->toFormattedDateString());
    }

    public function toArray ($notifiable)
    {
        return [
            'leave_id' => $this->leave->id, // Store leave ID for reference
            'leave_type' => $this->leave->type, // Store leave type
            'start_date' => $this->leave->startDate->toFormattedDateString(), // Store start date
            'end_date' => $this->leave->endDate->toFormattedDateString(), // Store end date
            'message' => 'Your leave request has been approved.', // Custom message
        ];
    }
}
