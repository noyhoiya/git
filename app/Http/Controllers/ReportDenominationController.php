<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportDenominationController extends Controller
{
    // Return blade view
    public function index()
    {
        $users = \App\Models\User::orderBy('full_name')->get();
        return view('reports.denomination', compact('users'));
    }

    // Return JSON used by frontend
    public function data(Request $request)
    {
        // fetch transactions / counts from DB according to period and user
        // For demo we return the same structure the JS expects.
        // Replace below with your real aggregation.

        $sample = [
            'keep' => [100000 => 245, 50000 => 50, 20000 => 75, 10000 => 52, 5000 => 32, 2000 => 20, 1000 => 62, 500 => 21],
            'receive' => [100000 => 100, 50000 => 200],
            'pay' => [100000 => 15]
        ];

        return response()->json($sample);
    }
}
