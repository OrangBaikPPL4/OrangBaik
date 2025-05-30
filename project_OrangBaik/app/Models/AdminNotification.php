<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminNotification extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'admin_id',
        'request_id',
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
     * Get the admin that owns the notification.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    
    /**
     * Get the request associated with the notification.
     */
    public function request()
    {
        return $this->belongsTo(RequestBantuan::class, 'request_id');
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
