<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'Testimoni';

    protected $fillable = [
        'nama',
        'lokasi',
        'jenis_bencana',
        'isicerita',
        'foto',
        'status',
    ];
}
