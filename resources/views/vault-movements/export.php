<?php
require_once __DIR__ . '/vendor/autoload.php';

use setasign\Fpdi\Fpdi;

// Get values from POST (your modal form)
$customerName = $_POST['customer_name'] ?? '';
$invoiceDate  = $_POST['invoice_date'] ?? '';
$amount       = $_POST['amount'] ?? '';

// Load the existing PDF
$pdf = new FPdi();
$pdf->AddPage();

// Set the template
$pdf->setSourceFile(__DIR__ . "/templates/template.pdf");
$template = $pdf->importPage(1);
$pdf->useTemplate($template, 0, 0, 210); // full A4

// Add data on top
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);

// Example positions (x,y in mm)
$pdf->SetXY(40, 50);
$pdf->Write(10, $customerName);

$pdf->SetXY(150, 50);
$pdf->Write(10, $invoiceDate);

$pdf->SetXY(100, 100);
$pdf->Write(10, $amount);

// Output PDF to browser
$pdf->Output('I', 'invoice_filled.pdf'); // I = inline, D = download
