<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'isi', 'gambar', 'created_by'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
