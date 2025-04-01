<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DisasterReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lokasi',
        'jenis_bencana',
        'deskripsi',
        'bukti_media',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

