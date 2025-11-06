<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('navbar/header'); ?>

<div class="main-content">
    <div class="content-wrapper">
        <h2 class="page-title mb-4">Grafik Jumlah Perkara per Bulan (<span id="tahunLabel"><?= htmlspecialchars($tahun) ?></span>)</h2>
        <form method="get" action="" class="mb-3 d-flex align-items-center gap-2">
            <label for="tahun" class="form-label mb-0">Tahun:</label>
            <select name="tahun" id="tahun" class="form-select" style="width:120px;display:inline-block;">
                <?php
                $tahun_now = date('Y');
                for ($t = $tahun_now; $t >= $tahun_now - 5; $t--) {
                    echo '<option value="' . $t . '"' . ($tahun == $t ? ' selected' : '') . '>' . $t . '</option>';
                }
                ?>
            </select>
            <button type="submit" class="btn btn-success">Tampilkan</button>
        </form>
        <button id="btnCetakPDF" class="btn btn-danger mb-3"><i class="fas fa-file-pdf me-1"></i> Cetak PDF</button>
        <canvas id="grafikPerkaraBulanan" width="900" height="400"></canvas>
        <div class="mt-2" style="font-size: 1rem; color: #555;">
            <i class="fas fa-info-circle me-1"></i>
            <strong>Keterangan:</strong> Angka di sebelah kiri grafik menunjukkan berapa banyak data perkara pada bulan tersebut.
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    const ctx = document.getElementById('grafikPerkaraBulanan').getContext('2d');
    const dataBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const dataJumlah = <?= json_encode(array_map(function ($row) {
                            return $row['jumlah'];
                        }, $grafik)) ?>;
    // Array warna berbeda untuk setiap bulan
    const warnaBar = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF', '#FF6F61', '#6B5B95', '#88B04B', '#F7CAC9', '#92A8D1'
    ];
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dataBulan,
            datasets: [{
                label: 'Jumlah Perkara',
                data: dataJumlah,
                backgroundColor: warnaBar,
                borderColor: warnaBar,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Grafik Jumlah Perkara per Bulan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Perkara'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Bulan'
                    }
                }
            }
        }
    });
    // Cetak PDF
    document.getElementById('btnCetakPDF').addEventListener('click', function() {
        html2canvas(document.getElementById('grafikPerkaraBulanan')).then(function(canvas) {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new window.jspdf.jsPDF({
                orientation: 'landscape'
            });
            pdf.text('Grafik Jumlah Perkara per Bulan (<?= htmlspecialchars($tahun) ?>)', 14, 18);
            pdf.addImage(imgData, 'PNG', 10, 30, 270, 90);
            pdf.setFontSize(12);
            pdf.text('Keterangan: Angka di sebelah kiri grafik menunjukkan jumlah data perkara pada setiap bulan.', 14, 125);
            pdf.save('grafik_perkara_bulanan_<?= htmlspecialchars($tahun) ?>.pdf');
        });
    });
</script>
<?php $this->load->view('navbar/footer'); ?>