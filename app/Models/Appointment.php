<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $guarded = [];

    public function appointmentNotes()
    {
        return $this->hasMany(AppointmentNote::class, 'appointment_id', 'id');
    }

    public function doctor()
    {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }

    public static function convertAppointmentTimeByUserTimezone($user_id, $time_in_utc)
    {
        $user_info = User::where('id', $user_id)->first();
        $timezone_info = TimeZone::where('id', $user_info->timezone_id)->first();
        $appointment_date_time = Carbon::parse($time_in_utc)->shiftTimezone('UTC')->setTimezone($timezone_info->tz_identifier)->toDateTimeString();
        $formatted_date_time = Carbon::parse($appointment_date_time)->format('m/d/Y H:i a') . " " . $timezone_info->tz_abbreviation;
        return $formatted_date_time;
    }
}
