<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use HasFactory;

    protected $table = 'edukasi';

    protected $fillable = ['title', 'content', 'category', 'image', 'video_file', 'video_link'];

    public function getImageUrlAttribute()
        {
            return $this->image ? asset('storage/' . $this->image) : null;
        }

        public function getVideoFileUrlAttribute()
        {
            return $this->video_file ? asset('storage/' . $this->video_file) : null;
        }

}
