<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'negara',
        'provinsi',
        'kota',
        'alamat_jalan',
        'amount',
        'payment_method',
        'contact_email',
        'contact_phone',
        'message',
        'transaction_id',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentProof()
    {
        return $this->hasOne(PaymentProof::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(DonationStatusHistory::class);
    }

    public function disasterReport()
    {
        return $this->belongsTo(DisasterReport::class);
    }

    public function distribution()
    {
        return $this->hasOne(Distribution::class);
    }
}
