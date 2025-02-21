<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Auth\Impersonatable;


class User extends Authenticatable
{
    use HasFactory, Notifiable, Actionable ,Impersonatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'firstName',
        'lastName',
        'phone',
        'email',
        'password',
        'address',
        'date_of_birth',
        'nok_name',
        'nok_address',
        'nok_phone',
        'nok_email',
        'is_hybrid',
        'days',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'days' => 'array',
            'is_hybrid' => 'boolean',
        ];
    }

    public static function getFirstName() :string
    {
        return Auth::user()->firstName."'s - ";
    }

    public function leaves (): HasMany
    {
        return $this->hasMany(LeaveModel::class, 'userID', 'id');
    }

    public function monthlyAttendance (): HasMany
    {
        return $this->hasMany(AttendanceModel::class, 'userID', 'id')
            ->whereMonth('clockIn', Carbon::now()->month)
            ->whereYear('clockIn', Carbon::now()->year);
    }

    public function attendance (): HasMany
    {
        return $this->hasMany(AttendanceModel::class, 'userID', 'id');

    }

    public function tasks (): HasMany
    {
        return $this->hasMany(Task::class, 'userID', 'id');

    }

}
