<?php
require 'vendor/autoload.php';

use setasign\Fpdi\Fpdi;

function exportPdf($data) {
    $pdf = new FPDI();
    $pdf->AddPage();

    // Import existing template
    $pdf->setSourceFile(__DIR__ . "/assets/pdf/my_template.pdf");
    $tplId = $pdf->importPage(1);
    $pdf->useTemplate($tplId, 0, 0, 210); // A4 width

    // Load Lao font
    $pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);
    $pdf->SetFont('DejaVu','',12);

    // Fill data
    $pdf->SetXY(40, 60);
    $pdf->Write(8, "ເລກທີ: " . $data['id']);

    $pdf->SetXY(150, 60);
    $pdf->Write(8, "ວັນທີ: " . $data['created']);

    $pdf->SetXY(40, 90);
    $pdf->Write(8, "ຊື່ຜູ້ຖອນ: " . $data['withdrawer']);

    $pdf->SetXY(40, 110);
    $pdf->Write(8, "ຈຸດປະສົງ: " . $data['purpose']);

    $pdf->SetXY(40, 130);
    $pdf->Write(8, "ຈຳນວນເງິນ: " . number_format($data['amount'], 0) . " ₭");

    $pdf->SetXY(40, 150);
    $pdf->Write(8, "ເປັນຕົວໜັງສື: " . $data['amount_words']);

    // Output
    $pdf->Output("I", "voucher.pdf");
}

// Example dynamic data
$data = [
    'id' => '001/ມຖງ.ບກ',
    'created' => date('d/m/Y'),
    'withdrawer' => 'Vatthana Sayasy',
    'purpose' => 'ຊື້ຢາ',
    'amount' => 1000000,
    'amount_words' => 'ໜຶ່ງລ້ານກີບ'
];

exportPdf($data);
