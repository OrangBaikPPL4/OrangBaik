<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Volunteer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_acara',
        'deskripsi',
        'status',
        'kuota_relawan',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'image_url'
    ];
    
    public function relawan()
    {
        return $this->belongsToMany(Relawan::class, 'relawan_volunteer')->withPivot('status_kehadiran')->withTimestamps();
    }
}
