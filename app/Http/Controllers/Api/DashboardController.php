<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vault;
use App\Models\CashRequest;
use App\Models\VaultMovement;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function getStats()
    {
        $stats = [
            'total_vaults' => Vault::where('is_active', true)->count(),
            'pending_requests' => CashRequest::where('status', 'PENDING')->count(),
            'recent_movements' => VaultMovement::where('status', 'POSTED')->count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_balance' => Vault::where('is_active', true)->sum('current_balance_cents'),
            'approved_requests' => CashRequest::where('status', 'APPROVED')->count(),
            'rejected_requests' => CashRequest::where('status', 'REJECTED')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ], 200);
    }

    /**
     * Get recent transactions
     */
    public function getRecentTransactions()
    {
        $recentRequests = CashRequest::with(['requesterUser', 'requesterVault', 'purpose'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($request) {
                return [
                    'id' => $request->request_id,
                    'type' => 'cash_request',
                    'user' => $request->requesterUser->full_name,
                    'vault' => $request->requesterVault->vault_name,
                    'amount' => $request->amount_cents,
                    'amount_formatted' => number_format($request->amount_cents / 100, 2),
                    'status' => $request->status,
                    'purpose' => $request->purpose->purpose_name ?? null,
                    'created_at' => $request->created_at,
                ];
            });

        $recentMovements = VaultMovement::with(['fromVault', 'toVault', 'createdByUser'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($movement) {
                return [
                    'id' => $movement->movement_id,
                    'type' => 'vault_movement',
                    'user' => $movement->createdByUser->full_name,
                    'from_vault' => $movement->fromVault->vault_name,
                    'to_vault' => $movement->toVault->vault_name,
                    'amount' => $movement->amount_cents,
                    'amount_formatted' => number_format($movement->amount_cents / 100, 2),
                    'status' => $movement->status,
                    'created_at' => $movement->created_at,
                ];
            });

        $allTransactions = $recentRequests->concat($recentMovements)
            ->sortByDesc('created_at')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $allTransactions
        ], 200);
    }
}
