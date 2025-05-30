<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DonationStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'donation_id',
        'status',
        'changed_by',
        'comment',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
} 