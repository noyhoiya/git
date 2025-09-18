<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use Illuminate\Http\Request;use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VaultController extends Controller
{
    // Display all vaults
    public function index()
    {
        $vaults = Vault::all();
        return view('vaults.index', compact('vaults'));
    }

    // Show form to create a new vault
    public function create()
    {
        return view('vaults.create');
    }

    // Store new vault
    public function store(Request $request)
    {
        $request->validate([
            'vault_name' => 'required|string|max:255',
            'vault_type' => 'required|in:MAIN,SUB',
            'current_balance_cents' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        Vault::create([
            'vault_name' => $request->vault_name,
            'vault_type' => $request->vault_type,
            'current_balance_cents' => $request->current_balance_cents,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('vaults.index')->with('success', 'Vault created successfully.');
    }

    // Show vault details
    public function show(Vault $vault)
    {
        return view('vaults.show', compact('vault'));
    }

    // Show edit form
    public function edit(Vault $vault)
    {
        return view('vaults.edit', compact('vault'));
    }

    // Update vault
    public function update(Request $request, Vault $vault)
    {
        $request->validate([
            'vault_name' => 'required|string|max:255',
            'vault_type' => 'required|in:MAIN,SUB',
            'current_balance_cents' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        $vault->update([
            'vault_name' => $request->vault_name,
            'vault_type' => $request->vault_type,
            'current_balance_cents' => $request->current_balance_cents,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('vaults.index')->with('success', 'Vault updated successfully.');
    }

    // Delete vault
    public function destroy(Vault $vault)
    {
        $vault->delete();
        return redirect()->route('vaults.index')->with('success', 'Vault deleted successfully.');
    }
public function handoverDebug(Request $request)
{
    $mainVault = Vault::find($request->main_vault_id);
    $tellerVault = Vault::find($request->teller_id);
    $userId = auth()->id();
    $amount = abs($request->amount); // Ensure amount is positive

    if (!$mainVault || !$tellerVault) {
        return response()->json([
            'error' => 'Vault not found'
        ], 404);
    }

    // Call Vault method to handle transfer
    $result = $mainVault->logTransactionDebug($tellerVault, $amount, $userId);

    if (isset($result['error'])) {
        return response()->json([
            'error' => $result['error'],
            'current_balance' => $result['current_balance']
        ], 400);
    }

    return response()->json([
        'message' => 'Handover completed successfully',
        'debug' => $result
    ]);
}


// public function showDebugLogs()
// {
//     $logs = \DB::table('transaction_debug_logs')
//         ->orderBy('created_at', 'desc')
//         ->get();

//     return view('vault.debug_logs', compact('logs'));
// }
public function showDebugLogs()
{
    $logs = DB::table('transaction_debug_logs')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($log) {
            // Negative check
            $log->is_negative = ($log->balance_from_after < 0 || $log->balance_to_after < 0);

            // Duplicate check (same from/to/amount within 5 seconds)
            $duplicate = DB::table('transaction_debug_logs')
                ->where('from_vault_id', $log->from_vault_id)
                ->where('to_vault_id', $log->to_vault_id)
                ->where('amount', $log->amount)
                ->where('id', '!=', $log->id)
                ->whereBetween('created_at', [
                    Carbon::parse($log->created_at)->subSeconds(5),
                    Carbon::parse($log->created_at)->addSeconds(5),
                ])
                ->exists();

            $log->is_duplicate = $duplicate;

            return $log;
        });

    return view('vaults.debug_logs', compact('logs'));

}

}
