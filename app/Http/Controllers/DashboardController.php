<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vault;
use App\Models\CashRequest;
use App\Models\VaultMovement;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'total_vaults' => Vault::where('is_active', true)->count(),
        'pending_requests' => CashRequest::where('status', 'PENDING')->count(),
        'recent_movements' => VaultMovement::where('status', 'POSTED')->count(),
        'active_users' => User::where('is_active', true)->count(),
    ];

    $recentRequests = CashRequest::with(['requesterUser', 'requesterVault'])
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();


    $recentMovements = VaultMovement::with(['fromVault', 'toVault', 'createdByUser'])
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return view('dashboard', compact('stats', 'recentRequests', 'recentMovements'));
}








   public function reports()
{
    $users = User::orderBy('full_name')->get();
    return view('reports.reports', compact('users'));
}


    // Return JSON for JS fetch
    public function cashFlowReport(Request $request)
{
    $userId = $request->get('user_id');
    $period = $request->get('period', '7days');

    // Default date range
    $from = now()->subDays(7);
    $to = now();

    // Adjust range based on selected period
    if ($period === 'today' || $period === 'now') {
        $from = now()->startOfDay();
        $to = now()->endOfDay();
    } elseif ($period === '30days') {
        $from = now()->subDays(30);
        $to = now();
    } elseif ($period === 'custom') {
        $from = $request->get('from');
        $to = $request->get('to');
    }

    // --- Previous total before 'from' date ---
    $previousWithdrawals = VaultMovement::when($userId && $userId !== 'all', function($q) use ($userId) {
            $q->where('created_by', $userId);
        })
        ->where('created_at', '<', $from)
        ->where('type', 'WITHDRAWAL')
        ->sum('amount_cents');

    $previousHandovers = VaultMovement::when($userId && $userId !== 'all', function($q) use ($userId) {
            $q->where('created_by', $userId);
        })
        ->where('created_at', '<', $from)
        ->where('type', 'HANDOVER')
        ->sum('amount_cents');

    // Balance brought forward
    $previousTotal = $previousWithdrawals - $previousHandovers;

    // --- Transactions in the selected range ---
    $query = VaultMovement::with(['fromVault', 'toVault', 'purpose', 'createdByUser'])
        ->when($userId && $userId !== 'all', function($q) use ($userId) {
            $q->where('created_by', $userId);
        })
        ->whereBetween('created_at', [$from, $to])
        ->orderBy('created_at', 'asc');

    $transactions = $query->get();

    // --- Return result ---
    return response()->json([
        'period' => $period,
        'from' => $from,
        'to' => $to,
        'previous_total' => $previousTotal,
        'transactions' => $transactions
    ]);
}

}