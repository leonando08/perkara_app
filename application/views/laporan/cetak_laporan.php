<?php
include_once("../../config/database.php");
include_once("../../models/Perkara.php");
require('../../libs/fpdf.php'); // pastikan path sesuai

$perkaraModel = new Perkara($conn);

// --- Ambil filter dari GET ---
$filters = [
    'bulan'           => $_GET['bulan'] ?? '',
    'asal_pengadilan' => $_GET['asal_pengadilan'] ?? '',
    'klasifikasi'     => $_GET['klasifikasi'] ?? '',
    'status'          => $_GET['status'] ?? ''
];

// --- Ambil data berdasarkan filter ---
$useFilter = ($filters['bulan'] || $filters['asal_pengadilan'] || $filters['klasifikasi'] || $filters['status']);
if ($useFilter && method_exists($perkaraModel, 'getFiltered')) {
    $perkaras = $perkaraModel->getFiltered($filters);
} else {
    $perkaras = $perkaraModel->getAll();
}

// --- Buat judul laporan dinamis ---
$judul = "Laporan Perkara Pidana";
if (!empty($filters['bulan'])) {
    $judul .= " Bulan " . date("F Y", strtotime($filters['bulan'] . "-01"));
}
if (!empty($filters['asal_pengadilan'])) {
    $judul .= " | Asal: " . $filters['asal_pengadilan'];
}
if (!empty($filters['klasifikasi'])) {
    $judul .= " | Klasifikasi: " . $filters['klasifikasi'];
}
if (!empty($filters['status'])) {
    $judul .= " | Status: " . $filters['status'];
}

class PDF_MC_Table extends FPDF
{
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function RowWithWrap($data, $headerWidths)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($headerWidths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        $this->CheckPageBreak($h);

        for ($i = 0; $i < count($data); $i++) {
            $w = $headerWidths[$i];
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 5, $data[$i], 0, 'C');
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }
}

// --- Header tabel ---
$header = [
    ['label' => 'No', 'width' => 8],
    ['label' => 'Asal Pengadilan', 'width' => 28],
    ['label' => 'Nomor Perkara Tk1', 'width' => 28],
    ['label' => 'Klasifikasi', 'width' => 25],
    ['label' => 'Tgl Register', 'width' => 20],
    ['label' => 'Nomor Perkara Banding', 'width' => 28],
    ['label' => 'Lama Proses', 'width' => 18],
    ['label' => 'Status Perkara', 'width' => 30],
    ['label' => 'Pemberitahuan Putusan', 'width' => 30],
    ['label' => 'Permohonan Kasasi', 'width' => 25],
    ['label' => 'Pengiriman Berkas', 'width' => 25],
    ['label' => 'Status', 'width' => 20], // tambahan
];

// --- Buat PDF ---
$pdf = new PDF_MC_Table('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, $judul, 0, 1, 'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 6);
$pdf->SetFillColor(200, 220, 255);
foreach ($header as $col) {
    $pdf->Cell($col['width'], 8, $col['label'], 1, 0, 'C', true);
}
$pdf->Ln();

// Isi tabel
$pdf->SetFont('Arial', '', 6);
$no = 1;

if ($perkaras && $perkaras->num_rows > 0) {
    while ($row = $perkaras->fetch_assoc()) {
        $statusBadge = $row['status'] ?? '-';
        $data = [
            $no++,
            $row['asal_pengadilan'] ?? '-',
            $row['nomor_perkara_tk1'] ?? '-',
            $row['klasifikasi'] ?? '-',
            !empty($row['tgl_register_banding']) ? date('d-m-Y', strtotime($row['tgl_register_banding'])) : '-',
            $row['nomor_perkara_banding'] ?? '-',
            $row['lama_proses'] ?? '-',
            $row['status_perkara_tk_banding'] ?? '-',
            !empty($row['pemberitahuan_putusan_banding']) ? date('d-m-Y', strtotime($row['pemberitahuan_putusan_banding'])) : '-',
            !empty($row['permohonan_kasasi']) ? date('d-m-Y', strtotime($row['permohonan_kasasi'])) : '-',
            !empty($row['pengiriman_berkas_kasasi']) ? date('d-m-Y', strtotime($row['pengiriman_berkas_kasasi'])) : '-',
            $statusBadge,
        ];
        $pdf->RowWithWrap($data, array_column($header, 'width'));
    }
} else {
    $pdf->Cell(0, 10, "Tidak ada data perkara.", 1, 1, 'C');
}

$pdf->Output('I', 'Laporan_Perkara.pdf');
