<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VaultMovement;
use App\Models\VaultMovementDenom;
use App\Models\Vault;
use Illuminate\Support\Facades\DB;
use App\Models\Purpose;

class VaultMovementController extends Controller
{
   public function index()
{
    $movements = VaultMovement::with(['fromVault', 'toVault', 'createdByUser'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
return view('vault-movements.index', compact('movements'));

}  


    public function create()
    {
        $vaults = Vault::where('is_active', true)->get();
        $purposes = Purpose::all();

        return view('vault-movements.create', compact('vaults', 'purposes'));
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'type' => 'required|in:WITHDRAWAL,HANDOVER',
        'from_vault_id' => 'required|exists:vaults,vault_id',
        'to_vault_id' => 'required|exists:vaults,vault_id|different:from_vault_id',
        'amount_cents' => 'required|numeric|min:0.01',
        'amount_in_words' => 'required|string|max:255',
        'purpose_code' => 'nullable|exists:purposes,purpose_code',
        'purpose_text' => 'nullable|string|max:255',
        'denomination.*' => 'nullable|numeric',
        'quantity.*' => 'nullable|numeric',
    ]);

    // 1️⃣ Create movement first
   $movement = VaultMovement::create([
    'type' => $validated['type'],
    'from_vault_id' => $validated['from_vault_id'],
    'to_vault_id' => $validated['to_vault_id'],
    'amount_cents' => $validated['amount_cents'],
    'amount_in_words' => $validated['amount_in_words'],
    'purpose_code' => $validated['purpose_code'] ?? null,
    'purpose_text' => $validated['purpose_text'] ?? null,
    'created_by_user_id' => auth()->id(),
    'status' => 'DRAFT',
]);

$denominations = $request->input('denomination', []);
$quantities   = $request->input('quantity', []);

foreach ($denominations as $i => $denom) {
    if ($denom) {
        $movement->denominations()->create([
            'denomination' => $denom,
            'quantity' => $quantities[$i] ?? 0,
        ]);
    }
}


    return redirect()->route('vault-movements.show', $movement)
                     ->with('success', 'Vault movement created with denominations.');
}


    public function show(VaultMovement $vaultMovement)
    {
        $vaultMovement->load(['fromVault', 'toVault', 'createdByUser', 'denominations']);
        return view('vault-movements.show', compact('vaultMovement'));
    }

public function postMovement($id)
{
    $movement = VaultMovement::findOrFail($id);

    if ($movement->status === 'POSTED') {
        return back()->with('error', 'Movement already posted');
    }

    try {
        DB::transaction(function () use ($movement) {
    $fromVault = Vault::findOrFail($movement->from_vault_id);
    $toVault   = Vault::findOrFail($movement->to_vault_id);

    $amount = $movement->amount_cents;

    if ($amount <= 0) {
        throw new \Exception("Amount must be positive.");
    }

    // ตรวจสอบ balance เพียงพอ
    if ($fromVault->current_balance_cents < $amount) {
        throw new \Exception("ເງິນສົດໃນຄັງບໍ່ພຽງພໍ.");
    }

    // ❌ ลบการเรียก updateBalance() ของ Vault Model
    // ทำ balance เอง
    $balanceFromBefore = $fromVault->current_balance_cents;
    $balanceToBefore   = $toVault->current_balance_cents;

    // $fromVault->current_balance_cents -= $amount;
    // $toVault->current_balance_cents   += $amount;

    $fromVault->save();
    $toVault->save();
    
    $movement->status = 'POSTED';
    $movement->posted_at = now();
    $movement->released_by_user_id = auth()->id();
    $movement->save();
    $denominations = json_decode($movement->denominations_temp, true) ?? [];
$quantities = json_decode($movement->quantities_temp, true) ?? [];

foreach ($denominations as $i => $denom) {
    if ($denom && isset($quantities[$i])) {
        $movement->denominations()->create([
            'denomination' => $denom,
            'quantity' => $quantities[$i],
        ]);
    }
}




   
    DB::table('transaction_debug_logs')->insert([
       'from_vault_id'       => $movement->from_vault_id,
        'to_vault_id'         => $movement->to_vault_id,
        'amount'              => $amount,
        'operation_from'      => 'subtract',
        'operation_to'        => 'add',
        'balance_from_before' => $balanceFromBefore,
        'balance_from_after'  => $fromVault->current_balance_cents,
        'balance_to_before'   => $balanceToBefore,
        'balance_to_after'    => $toVault->current_balance_cents,
        'user_id'             => auth()->id(),
        'created_at'          => now(),
    ]);
});

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }

    return back()->with('success', 'ບັນທຶກສຳເລັດ!');
}



    public function destroy($id)
{
    $movement = VaultMovement::findOrFail($id);

    // Only allow deletion if DRAFT
    if ($movement->status !== 'DRAFT') {
        return back()->withErrors(['status' => 'Cannot delete a posted movement.']);
    }

    $movement->delete();

    return redirect()->route('vault-movements.index')->with('success', 'ລົບແບບຮ່າງການເຄື່ອນໄຫວສຳເລັດ.');
}

}