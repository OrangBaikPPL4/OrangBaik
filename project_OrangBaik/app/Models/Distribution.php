<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = [
        'donation_id',
        'amount',
        'disaster',
        'description',
        'proof_image',
        'distributed_at',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
