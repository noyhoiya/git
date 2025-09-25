<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VaultMovement;
use App\Models\Vault;
use App\Models\Purpose;
use Illuminate\Support\Facades\DB;

class VaultMovementController extends Controller
{
    /**
     * Display a listing of vault movements
     */
    public function index(Request $request)
    {
        $query = VaultMovement::with(['fromVault', 'toVault', 'createdByUser', 'denominations']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by vault
        if ($request->has('vault_id')) {
            $query->where(function($q) use ($request) {
                $q->where('from_vault_id', $request->vault_id)
                  ->orWhere('to_vault_id', $request->vault_id);
            });
        }

        $movements = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $movements->items(),
            'pagination' => [
                'current_page' => $movements->currentPage(),
                'last_page' => $movements->lastPage(),
                'per_page' => $movements->perPage(),
                'total' => $movements->total(),
            ]
        ], 200);
    }

    /**
     * Store a newly created vault movement
     */
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

        // Save denominations
        $denominations = $request->input('denomination', []);
        $quantities = $request->input('quantity', []);

        foreach ($denominations as $i => $denom) {
            if ($denom) {
                $movement->denominations()->create([
                    'denomination' => $denom,
                    'quantity' => $quantities[$i] ?? 0,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Vault movement created successfully',
            'data' => $movement->load(['fromVault', 'toVault', 'createdByUser', 'denominations'])
        ], 201);
    }

    /**
     * Display the specified vault movement
     */
    public function show($id)
    {
        $movement = VaultMovement::with(['fromVault', 'toVault', 'createdByUser', 'denominations'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $movement
        ], 200);
    }

    /**
     * Update the specified vault movement
     */
    public function update(Request $request, $id)
    {
        $movement = VaultMovement::findOrFail($id);

        // Only allow updates if draft
        if (!$movement->isDraft()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update non-draft movement'
            ], 400);
        }

        $validated = $request->validate([
            'amount_cents' => 'nullable|numeric|min:0.01',
            'amount_in_words' => 'nullable|string|max:255',
            'purpose_code' => 'nullable|exists:purposes,purpose_code',
            'purpose_text' => 'nullable|string|max:255',
        ]);

        $movement->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Vault movement updated successfully',
            'data' => $movement->load(['fromVault', 'toVault', 'createdByUser', 'denominations'])
        ], 200);
    }

    /**
     * Remove the specified vault movement
     */
    public function destroy($id)
    {
        $movement = VaultMovement::findOrFail($id);

        // Only allow deletion if draft
        if (!$movement->isDraft()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete non-draft movement'
            ], 400);
        }

        $movement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vault movement deleted successfully'
        ], 200);
    }

    /**
     * Post a vault movement (execute the transaction)
     */
    public function postMovement(Request $request, $id)
    {
        $movement = VaultMovement::findOrFail($id);

        if ($movement->status === 'POSTED') {
            return response()->json([
                'success' => false,
                'message' => 'Movement already posted'
            ], 400);
        }

        try {
            DB::transaction(function () use ($movement) {
                $fromVault = Vault::findOrFail($movement->from_vault_id);
                $toVault = Vault::findOrFail($movement->to_vault_id);

                $amount = $movement->amount_cents;

                if ($amount <= 0) {
                    throw new \Exception("Amount must be positive.");
                }

                // Check sufficient balance
                if ($fromVault->current_balance_cents < $amount) {
                    throw new \Exception("Insufficient balance in source vault.");
                }

                // Update vault balances
                $balanceFromBefore = $fromVault->current_balance_cents;
                $balanceToBefore = $toVault->current_balance_cents;

                $fromVault->current_balance_cents -= $amount;
                $toVault->current_balance_cents += $amount;

                $fromVault->save();
                $toVault->save();

                // Update movement status
                $movement->status = 'POSTED';
                $movement->posted_at = now();
                $movement->released_by_user_id = auth()->id();
                $movement->save();

                // Log transaction
                DB::table('transaction_debug_logs')->insert([
                    'from_vault_id' => $movement->from_vault_id,
                    'to_vault_id' => $movement->to_vault_id,
                    'amount' => $amount,
                    'operation_from' => 'subtract',
                    'operation_to' => 'add',
                    'balance_from_before' => $balanceFromBefore,
                    'balance_from_after' => $fromVault->current_balance_cents,
                    'balance_to_before' => $balanceToBefore,
                    'balance_to_after' => $toVault->current_balance_cents,
                    'user_id' => auth()->id(),
                    'created_at' => now(),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Movement posted successfully',
                'data' => $movement->load(['fromVault', 'toVault', 'createdByUser'])
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
