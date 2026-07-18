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

    $from = now()->subDays(7);
    $to = now();

    if ($period === '30days') {
        $from = now()->subDays(30);
    } elseif ($period === 'custom' && $request->from && $request->to) {
        $from = Carbon::parse($request->from)->startOfDay();
        $to = Carbon::parse($request->to)->endOfDay();
    }

    // Previous total before 'from' date
    $previousWithdrawals = VaultMovement::when($userId && $userId !== 'all', function($q) use ($userId){
            $q->where('created_by', $userId);
        })
        ->where('created_at', '<', $from)
        ->where('type', 'WITHDRAWAL')
        ->sum('amount_cents');

    $previousHandovers = VaultMovement::when($userId && $userId !== 'all', function($q) use ($userId){
            $q->where('created_by', $userId);
        })
        ->where('created_at', '<', $from)
        ->where('type', 'HANDOVER')
        ->sum('amount_cents');

    $previousTotal = $previousWithdrawals - $previousHandovers;

    // Transactions in selected range
    $query = VaultMovement::with(['fromVault','toVault','purpose','createdByUser']);
    if ($userId && $userId !== 'all') $query->where('created_by', $userId);
    $transactions = $query->whereBetween('created_at', [$from, $to])
        ->orderBy('created_at','asc')
        ->get();

    return response()->json([
        'previous_total' => $previousTotal,
        'transactions' => $transactions
    ]);
}

}