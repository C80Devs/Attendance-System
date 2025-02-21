<?php

namespace App\Jobs;

use App\Models\AttendanceModel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAttendance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct ($userId)
    {
        $this->userId = $userId;
    }

    public function handle (): void
    {
        $today = Carbon::today();

        if ($today->isWeekend()) {
            return;
        }

        $randomMinutes = rand(10, 60);
        $clockInTime = $today->setTime(8, 10)->addMinutes($randomMinutes);

        $clockInLocation = 'https://www.google.com/maps?q=9.080528,7.4143385';
        $clockOutLocation = 'https://www.google.com/maps?q=9.0805409,7.4143854';

        AttendanceModel::create([
            'userID' => $this->userId,
            'clockIn' => $clockInTime,
            'clockin_location' => $clockInLocation,
            'device' => 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Mobile Safari/537.36',
            'created_at' => $clockInTime,
            'updated_at' => $clockInTime,
        ]);

    }
}
