<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashRequest;
use setasign\Fpdi\Fpdi;

class CashRequestPdfController extends Controller
{
    public function show($id)
    {
        $cashRequest = CashRequest::with(['requesterUser','requesterVault','purpose'])
                        ->findOrFail($id);

        $pdf = new Fpdi();
        $pdf->AddPage();
        
        // ใช้ template PDF เดิม
        $pdf->setSourceFile(public_path('assets/pdf/1.pdf'));
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 0, 0, 210);

        // เพิ่มฟอนต์
        $pdf->SetFont('Arial','',12);
        $pdf->SetTextColor(0,0,0);

        // เขียนข้อมูลลงบน template
        $pdf->SetXY(50, 60);
        $pdf->Write(8, "Request ID: " . $cashRequest->request_id);

        $pdf->SetXY(50, 70);
        $pdf->Write(8, "User: " . ($cashRequest->requesterUser->full_name ?? '-'));

        $pdf->SetXY(50, 80);
        $pdf->Write(8, "Vault: " . ($cashRequest->requesterVault->vault_name ?? '-'));

        $pdf->SetXY(50, 90);
        $pdf->Write(8, "Amount: " . number_format($cashRequest->amount) . " ກີບ");

        $pdf->SetXY(50, 100);
        $pdf->Write(8, "Amount_in-words: " . ($cashRequest->amount_in_words) . "-");

        $pdf->SetXY(50, 110);
        $pdf->Write(8, "Purpose: " . ($cashRequest->purpose->purpose_name ?? $cashRequest->purpose_text));

        $pdf->SetXY(50, 120);
        $pdf->Write(8, "Status: " . $cashRequest->status);

        return response($pdf->Output('S'), 200)
                ->header('Content-Type', 'application/pdf');
    }
}