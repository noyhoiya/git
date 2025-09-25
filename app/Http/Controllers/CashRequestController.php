<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CashRequest;
use App\Models\Vault;
use App\Models\Purpose;
use App\Models\VaultMovement;
use App\Models\User;
use App\Notifications\NewCashRequest;
class CashRequestController extends Controller
{
public function create()
{
    $vaults = Vault::where('is_active', true)->get();
    $user   = Auth::user();

    // get the role name from Role model
    $role = $user->role->role_name ?? null;

    // Map role names to purpose codes
    $rolePurposesMap = [
        'ADMIN'       => ['ADMIN_DAILY','OFFICE_SUPPLIES','REPAIR','UTILITIES','OTHER'],
        'ADMIN_VAULT' => ['ADMIN_DAILY','BANK_WITHDRAW','OFFICE_SUPPLIES','REPAIR','UTILITIES','OTHER'],
        'MAIN_VAULT'  => ['ADMIN_DAILY','BANK_WITHDRAW','OFFICE_SUPPLIES','REPAIR','UTILITIES','OTHER'],
        'TELLER'      => ['TELLER_SERVICE','EOD_SURPLUS'],
        'AUDITOR'     => ['OTHER'],
    ];

    $purposes = Purpose::whereIn('purpose_code', $rolePurposesMap[$role] ?? [])->get();

    return view('cash-requests.create', compact('vaults', 'purposes'));
}



    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'requester_vault_id' => 'required|exists:vaults,id',
    //         'amount' => 'required|numeric|min:0.01',
    //         'purpose_code' => 'nullable|exists:purposes,purpose_code',
    //         'purpose_text' => 'nullable|string|max:255',
    //         'notes' => 'nullable|string|max:500',
    //     ]);

    //     // สร้าง request_id อัตโนมัติ
    //     $validated['request_id'] = 'REQ-' . time(); // หรือใช้ Str::uuid()
    //     $validated['requester_user_id'] = auth()->id();
    //     $validated['status'] = 'PENDING';
    //     $validated['amount_cents'] = $validated['amount'] * 100; // convert เป็น cents

    //     CashRequest::create($validated);

    //     return redirect()->route('cash-requests.index')->with('success'z, 'Request created successfully!');
    // }
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
   
   // Send email to admins (only email, no database)
    $admins = User::where('role_id', '1')->get();
    foreach ($admins as $admin) {
        $admin->notify(new NewCashRequest($cashRequest)); // mail only
    }

    // Flash message for dashboard alert
     // Example: store multiple cash request alerts
$alerts = session('cash_request_alerts', []); // get existing or empty array
$alerts[] = $cashRequest; // add new request
session(['cash_request_alerts' => $alerts]);

return redirect()->back();


}
// app/Http/Controllers/CashRequestController.php
 public function index()
    {
        // use paginate(...) if you want pagination; using get() for simplicity
        $cashRequests = CashRequest::with(['requesterVault', 'requesterUser', 'purpose'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10)
;

        return view('cash-requests.index', compact('cashRequests'));
    }




    public function show($id)
{
    // use variable name that is unambiguous:
    $cashRequest = CashRequest::with(['requesterVault','requesterUser','purpose'])->findOrFail($id);
    return view('cash_requests.show', compact('cashRequest'));
}


    public function approve($id, Request $request)
    {
        $cashRequest = CashRequest::findOrFail($id);
        
        if (!$cashRequest->isPending()) {
            return back()->withErrors(['status' => 'Request is not pending.']);
        }

        $cashRequest->approve(auth()->id(), $request->notes);

        // Create corresponding vault movement
        $mainVault = Vault::where('vault_type', 'MAIN')->first();
        
        VaultMovement::create([
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

        return back()->with('success', 'ອະນຸມັດຄຳຮ້ອງຂໍ ສຳເລັດ');
    }

    public function reject($id, Request $request)
    {
        $cashRequest = CashRequest::findOrFail($id);
        
        if (!$cashRequest->isPending()) {
            return back()->withErrors(['status' => 'Request is not pending.']);
        }

        $cashRequest->reject(auth()->id(), $request->notes);

        return back()->with('success', 'ຄຳຮ້ອງຂໍຖືກປະຕິເສດ.');
    }
}