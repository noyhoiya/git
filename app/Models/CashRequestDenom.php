<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRequestDenom extends Model
{
    use HasFactory;

    protected $table = 'cash_request_denoms';
    
    protected $fillable = [
        'request_id',
        'denomination',
        'quantity',
    ];

    protected $casts = [
        'denomination' => 'integer',
        'quantity' => 'integer',
    ];

    public $timestamps = false;

    public function cashRequest()
    {
        return $this->belongsTo(CashRequest::class, 'request_id');
    }

    public function getTotalValueAttribute()
    {
        return $this->denomination * $this->quantity;
    }
}