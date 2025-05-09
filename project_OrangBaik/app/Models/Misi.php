<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Misi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nama_misi',
        'deskripsi',
        'status',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'image_url'
    ];
    
    public function relawan()
    {
        return $this->belongsToMany(Relawan::class, 'relawan_misi')->withPivot('laporan')->withTimestamps();
    }
}
