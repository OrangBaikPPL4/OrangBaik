<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VolunteerEventRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'volunteer_id',
        'name',
        'description',
        'slots_needed',
        'estimated_work_hours',
    ];

    /**
     * Get the volunteer event that this role belongs to.
     */
    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
    
    /**
     * Get the participants (relawan) for this role.
     */
    public function participants()
    {
        return $this->belongsToMany(Relawan::class, 'relawan_volunteer', 'volunteer_event_role_id', 'relawan_id')
                    ->withPivot('status_partisipasi', 'status_kehadiran')
                    ->withTimestamps();
    }
}
