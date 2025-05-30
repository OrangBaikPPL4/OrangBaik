<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VolunteerNotification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'relawan_id',
        'volunteer_id',
        'title',
        'message',
        'type',
        'is_read',
        'read_at'
    ];
    
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];
    
    /**
     * Get the relawan that owns the notification.
     */
    public function relawan()
    {
        return $this->belongsTo(Relawan::class);
    }
    
    /**
     * Get the volunteer event associated with the notification.
     */
    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
    
    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
        
        return $this;
    }
}
