<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    use HasFactory;

    protected $primaryKey = 'vault_id';

    protected $fillable = [
        'vault_name',
        'vault_type',
        'current_balance_cents',
        'is_active',
    ];

    protected $casts = [
        'current_balance_cents' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cashRequests()
    {
        return $this->hasMany(CashRequest::class, 'requester_vault_id');
    }

    public function fromMovements()
    {
        return $this->hasMany(VaultMovement::class, 'from_vault_id');
    }

    public function toMovements()
    {
        return $this->hasMany(VaultMovement::class, 'to_vault_id');
    }

    public function getCurrentBalanceAttribute()
    {
        return $this->current_balance_cents;
    }

    public function setCurrentBalanceAttribute($value)
    {
        $this->current_balance_cents = $value ;
    }

    public function isMainVault()
    {
        return $this->vault_type === 'MAIN';
    }

    public function isSubVault()
    {
        return $this->vault_type === 'SUB';
    }

    public function canWithdraw($amountCents)
    {
        return $this->current_balance_cents >= $amountCents;
    }
public function updateBalance($amountCents, $operation = 'add')
{
    $amount = abs($amountCents); // ensure positive

    if ($operation === 'subtract') {
        $this->current_balance_cents -= $amount;
    } else {
        $this->current_balance_cents += $amount;
    }

    $this->save();
}


 public function logTransactionDebug($toVault, $amount, $userId)
{
    // Prevent negative balance
    if ($this->current_balance_cents < $amount) {
        return [
            'error' => 'Insufficient balance in main vault',
            'current_balance' => $this->current_balance_cents
        ];
    }

    // Save balances before transfer
    $balanceFromBefore = $this->current_balance_cents;
    $balanceToBefore   = $toVault->current_balance_cents;

    // Perform the transfer
    $this->current_balance_cents -= $amount;
    $toVault->current_balance_cents += $amount;

    $balanceFromAfter = $this->current_balance_cents;
    $balanceToAfter   = $toVault->current_balance_cents;

    // Save vaults
    $this->save();
    $toVault->save();

    // Insert debug log
    DB::table('transaction_debug_logs')->insert([
        'from_vault_id' => $this->id,
        'to_vault_id'   => $toVault->id,
        'amount'        => $amount,
        'operation_from'=> 'subtract',
        'operation_to'  => 'add',
        'balance_from_before' => $balanceFromBefore,
        'balance_from_after'  => $balanceFromAfter,
        'balance_to_before'   => $balanceToBefore,
        'balance_to_after'    => $balanceToAfter,
        'user_id' => $userId,
        'created_at' => now()
    ]);

    // Return debug info
    return [
        'from_before' => $balanceFromBefore,
        'from_after'  => $balanceFromAfter,
        'to_before'   => $balanceToBefore,
        'to_after'    => $balanceToAfter
    ];
}


}