<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaultMovement extends Model
{
    use HasFactory;

    protected $primaryKey = 'movement_id';

    public $timestamps = false; // <--- Disable updated_at / created_at auto-handling
    
    protected $fillable = [
        'type',
        'from_vault_id',
        'to_vault_id',
        'request_id',
        'amount_cents',
        'amount_in_words',
        'purpose_code',
        'purpose_text',
        'status',
        'created_by_user_id',
        'released_by_user_id',
        'received_by_user_id',
        'posted_at',
        'denominations_temp',   // ✅ ต้องใส่
        'quantities_temp',      // ✅ ต้องใส่
    ];

    protected $casts = [
        'amount_cents' => 'integer',
        'posted_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function fromVault()
    {
        return $this->belongsTo(Vault::class, 'from_vault_id');
    }

    public function toVault()
    {
        return $this->belongsTo(Vault::class, 'to_vault_id');
    }

    public function cashRequest()
    {
        return $this->belongsTo(CashRequest::class, 'request_id');
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_code');
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function releasedByUser()
    {
        return $this->belongsTo(User::class, 'released_by_user_id');
    }

    public function receivedByUser()
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }

public function denominations()
{
    return $this->hasMany(VaultMovementDenom::class, 'movement_id', 'movement_id');
}


    public function getAmountAttribute()
    {
        return $this->amount_cents ;
    }
        public function Amount_in_words()
    {
        return $this->amount_in_words;
    }

    public function setAmountAttribute($value)
    {
        $this->amount_cents = $value ;
    }

    public function isDraft()
    {
        return $this->status === 'DRAFT';
    }

    public function isPosted()
    {
        return $this->status === 'POSTED';
    }

    public function isVoid()
    {
        return $this->status === 'VOID';
    }

    // public function postMovement($releasedByUserId, $receivedByUserId = null)
    // {
    //     if ($this->isPosted()) {
    //         throw new \Exception('Movement is already posted');
    //     }

    //     // Update vault balances
    //     $this->fromVault->updateBalance($this->amount_cents, 'subtract');
    //     $this->toVault->updateBalance($this->amount_cents, 'add');

    //     $this->update([
    //         'status' => 'POSTED',
    //         'posted_at' => now(),
    //         'released_by_user_id' => $releasedByUserId,
    //         'received_by_user_id' => $receivedByUserId,
    //     ]);
    // }
}
