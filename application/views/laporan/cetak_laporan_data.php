<?php
include_once("../../config/database.php");
require('../../libs/fpdf.php'); // pastikan path sesuai

// Ambil data rekap
$sql = "SELECT 
            SUM(CASE WHEN permohonan_kasasi IS NOT NULL AND permohonan_kasasi <> '' THEN 1 ELSE 0 END) AS jumlah_kasasi,
            SUM(CASE WHEN permohonan_kasasi IS NULL OR permohonan_kasasi = '' THEN 1 ELSE 0 END) AS jumlah_tidak_kasasi,
            SUM(CASE WHEN pemberitahuan_putusan_banding IS NOT NULL AND pemberitahuan_putusan_banding <> '' THEN 1 ELSE 0 END) AS jumlah_putus_banding
        FROM perkara_banding";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Judul laporan
$judul = "Laporan Rekap Perkara Pidana Banding";

$pdf = new FPDF('P', 'mm', 'A4'); // Portrait
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, $judul, 0, 1, 'C');
$pdf->Ln(10);

// Atur lebar kolom
$colWidth = 63; // biar muat 3 kolom di kertas A4 portrait
$colHeight = 8;

// Header (judul kategori)
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell($colWidth, $colHeight, 'Kasasi (Lanjut)', 1, 0, 'C', true);
$pdf->Cell($colWidth, $colHeight, 'Tidak Kasasi (Tidak Lanjut)', 1, 0, 'C', true);
$pdf->Cell($colWidth, $colHeight, 'Putus Banding', 1, 1, 'C', true);

// Isi (jumlah tiap kategori)
$pdf->SetFont('Arial', '', 12);
$pdf->Cell($colWidth, $colHeight, ($data['jumlah_kasasi'] ?? 0), 1, 0, 'C');
$pdf->Cell($colWidth, $colHeight, ($data['jumlah_tidak_kasasi'] ?? 0), 1, 0, 'C');
$pdf->Cell($colWidth, $colHeight, ($data['jumlah_putus_banding'] ?? 0), 1, 1, 'C');

$pdf->Output('I', 'Laporan_Rekap_Perkara.pdf');
