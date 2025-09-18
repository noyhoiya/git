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
        return view('reports.reports'); // resources/views/reports/reports.blade.php
    }

    // Return JSON for JS fetch
     public function cashFlowReport(Request $request)
    {
        $period = $request->get('period', '7days');

        $query = VaultMovement::with(['fromVault', 'toVault', 'purpose','createdByUser']);

        // filter by period
        if ($period === '7days') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($period === '30days') {
            $query->where('created_at', '>=', now()->subDays(30));
        } elseif ($period === 'custom') {
            $from = $request->get('from');
            $to = $request->get('to');
            if ($from && $to) {
                $query->whereBetween('created_at', [$from, $to]);
            }
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return response()->json($data);
    }



}