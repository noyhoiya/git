<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRequest extends Model
{
    use HasFactory;

    protected $primaryKey = 'request_id';

    // Disable default timestamps
    public $timestamps = false;

    protected $fillable = [
        'type',
        'requester_vault_id',
        'requester_user_id',
        'amount_cents',
        'amount_in_words',
        'purpose_code',
        'purpose_text',
        'status',
        'approved_at',
        'approver_user_id',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'amount_cents' => 'integer',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function requesterVault()
    {
        return $this->belongsTo(Vault::class, 'requester_vault_id');
    }

    public function requesterUser()
    {
         return $this->belongsTo(User::class, 'requester_user_id', 'user_id');
    }

    public function approverUser()
    {
        return $this->belongsTo(User::class, 'approver_user_id');
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_code');
    }
public function denominations()
{
    return $this->hasMany(CashRequestDenom::class, 'request_id', 'request_id');
}

    public function vaultMovement()
    {
        return $this->hasOne(VaultMovement::class, 'request_id');
    }

    public function getAmountAttribute()
    {
        return $this->amount_cents;
    }

    public function setAmountAttribute($value)
    {
        $this->amount_cents = $value * 100;
    }

    public function isPending()
    {
        return $this->status === 'PENDING';
    }

    public function isApproved()
    {
        return $this->status === 'APPROVED';
    }

    public function isRejected()
    {
        return $this->status === 'REJECTED';
    }

    public function approve($approverUserId, $notes = null)
    {
        $this->update([
            'status' => 'APPROVED',
            'approved_at' => now(),
            'approver_user_id' => $approverUserId,
            'notes' => $notes,
        ]);
    }

    public function reject($approverUserId, $notes = null)
    {
        $this->update([
            'status' => 'REJECTED',
            'approved_at' => now(),
            'approver_user_id' => $approverUserId,
            'notes' => $notes,
        ]);
    }
}
