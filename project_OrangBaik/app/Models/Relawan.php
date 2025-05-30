<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Relawan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama', 
        'email', 
        'telepon', 
        'lokasi', 
        'peran', 
        'status',
        'user_id',
        'verification_status'
    ];
    
    public function misi()
    {
        return $this->belongsToMany(Misi::class, 'relawan_misi')->withPivot('laporan')->withTimestamps();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function volunteer()
    {
        return $this->belongsToMany(Volunteer::class, 'relawan_volunteer')
                    ->withPivot('volunteer_event_role_id', 'status_partisipasi', 'status_kehadiran')
                    ->withTimestamps();
    }
}
