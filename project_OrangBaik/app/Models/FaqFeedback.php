<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqFeedback extends Model
{
    protected $table = 'faq_feedback';
    protected $fillable = ['user_email', 'message', 'is_addressed'];
}
