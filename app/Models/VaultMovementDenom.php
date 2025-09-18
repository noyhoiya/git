<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaultMovementDenom extends Model
{
    use HasFactory;

    protected $table = 'vault_movement_denoms';
    
    protected $fillable = [
        'movement_id',
        'denomination',
        'quantity',
    ];

    protected $casts = [
        'denomination' => 'integer',
        'quantity' => 'integer',
    ];

    public $timestamps = false;

    public function vaultMovement()
    {
        return $this->belongsTo(VaultMovement::class, 'movement_id');
    }

    public function getTotalValueAttribute()
    {
        return $this->denomination * $this->quantity;
    }
}
