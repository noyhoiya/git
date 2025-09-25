<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashRequest;
use App\Models\Vault;
use App\Models\Purpose;
use App\Models\User;
use App\Notifications\NewCashRequest;

class CashRequestController extends Controller
{
    /**
     * Display a listing of cash requests
     */
    public function index(Request $request)
    {
        $query = CashRequest::with(['requesterUser', 'requesterVault', 'purpose', 'denominations']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('requester_user_id', $request->user_id);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $requests->items(),
            'pagination' => [
                'current_page' => $requests->currentPage(),
                'last_page' => $requests->lastPage(),
                'per_page' => $requests->perPage(),
                'total' => $requests->total(),
            ]
        ], 200);
    }

    /**
     * Store a newly created cash request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'requester_vault_id' => 'required|exists:vaults,vault_id',
            'amount' => 'required|numeric|min:0.01',
            'amount_in_words' => 'required|string',
            'purpose_code' => 'required|exists:purposes,purpose_code',
            'purpose_text' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'denomination.*' => 'required|numeric',
            'quantity.*' => 'required|numeric',
        ]);

        $cashRequest = CashRequest::create([
            'requester_vault_id' => $validated['requester_vault_id'],
            'requester_user_id' => auth()->id(),
            'amount_cents' => $validated['amount'],
            'amount_in_words' => $validated['amount_in_words'],
            'purpose_code' => $validated['purpose_code'],
            'purpose_text' => $validated['purpose_text'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'PENDING',
        ]);

        // Save denominations
        $denominations = $request->denomination;
        $quantities = $request->quantity;

        foreach($denominations as $i => $denom) {
            if($denom && isset($quantities[$i])) {
                $cashRequest->denominations()->create([
                    'denomination' => $denom,
                    'quantity' => $quantities[$i],
                ]);
            }
        }

        // Send email to admins
        $admins = User::where('role_id', '1')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewCashRequest($cashRequest));
        }

        return response()->json([
            'success' => true,
            'message' => 'Cash request created successfully',
            'data' => $cashRequest->load(['requesterUser', 'requesterVault', 'purpose', 'denominations'])
        ], 201);
    }

    /**
     * Display the specified cash request
     */
    public function show($id)
    {
        $cashRequest = CashRequest::with(['requesterUser', 'requesterVault', 'purpose', 'denominations'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $cashRequest
        ], 200);
    }

    /**
     * Update the specified cash request
     */
    public function update(Request $request, $id)
    {
        $cashRequest = CashRequest::findOrFail($id);

        // Only allow updates if pending
        if (!$cashRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update non-pending request'
            ], 400);
        }

        $validated = $request->validate([
            'amount' => 'nullable|numeric|min:0.01',
            'amount_in_words' => 'nullable|string',
            'purpose_code' => 'nullable|exists:purposes,purpose_code',
            'purpose_text' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);

        $cashRequest->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cash request updated successfully',
            'data' => $cashRequest->load(['requesterUser', 'requesterVault', 'purpose', 'denominations'])
        ], 200);
    }

    /**
     * Remove the specified cash request
     */
    public function destroy($id)
    {
        $cashRequest = CashRequest::findOrFail($id);

        // Only allow deletion if pending
        if (!$cashRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete non-pending request'
            ], 400);
        }

        $cashRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cash request deleted successfully'
        ], 200);
    }

    /**
     * Approve a cash request
     */
    public function approve(Request $request, $id)
    {
        $cashRequest = CashRequest::findOrFail($id);
        
        if (!$cashRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Request is not pending'
            ], 400);
        }

        $cashRequest->approve(auth()->id(), $request->notes);

        // Create corresponding vault movement
        $mainVault = Vault::where('vault_type', 'MAIN')->first();
        
        $vaultMovement = VaultMovement::create([
            'type' => 'WITHDRAWAL',
            'from_vault_id' => $mainVault->vault_id,
            'to_vault_id' => $cashRequest->requester_vault_id,
            'request_id' => $cashRequest->request_id,
            'amount_cents' => $cashRequest->amount_cents,
            'amount_in_words' => $cashRequest->amount_in_words,
            'purpose_code' => $cashRequest->purpose_code,
            'purpose_text' => $cashRequest->purpose_text,
            'status' => 'DRAFT',
            'created_by_user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cash request approved successfully',
            'data' => [
                'cash_request' => $cashRequest->load(['requesterUser', 'requesterVault', 'purpose']),
                'vault_movement' => $vaultMovement
            ]
        ], 200);
    }

    /**
     * Reject a cash request
     */
    public function reject(Request $request, $id)
    {
        $cashRequest = CashRequest::findOrFail($id);
        
        if (!$cashRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Request is not pending'
            ], 400);
        }

        $cashRequest->reject(auth()->id(), $request->notes);

        return response()->json([
            'success' => true,
            'message' => 'Cash request rejected successfully',
            'data' => $cashRequest->load(['requesterUser', 'requesterVault', 'purpose'])
        ], 200);
    }
}
