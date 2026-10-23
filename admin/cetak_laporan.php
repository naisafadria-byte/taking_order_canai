<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: " . $base_url . "admin/login.php");
    exit;
}

$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

$ta = mysqli_real_escape_string($koneksi, $tgl_awal);
$tk = mysqli_real_escape_string($koneksi, $tgl_akhir);

$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE DATE(o.waktu_order) BETWEEN '$ta' AND '$tk'
                             ORDER BY o.waktu_order ASC");

$total_pendapatan = 0;
$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
    if ($row['status'] == 'selesai') $total_pendapatan += $row['total_harga'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan - Moonlight Café</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #fff;
            color: #000;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header img { height: 60px; margin-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 3px 0; color: #444; }
        
        .info { margin-bottom: 20px; }
        .info table { border: none; }
        .info td { padding: 2px 5px; vertical-align: top; }
        
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #333; padding: 6px 8px; }
        table.data th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .total-box { margin-top: 20px; text-align: right; font-size: 14px; font-weight: bold; }
        
        .footer { margin-top: 50px; text-align: right; }
        .footer .ttd { margin-top: 70px; border-top: 1px solid #000; display: inline-block; padding-top: 5px; min-width: 200px; text-align: center; }
        
        @media print {
            body { padding: 0; margin: 10mm; }
            .no-print { display: none !important; }
            @page { size: A4; margin: 15mm; }
        }
    </style>
</head>
<body>

<div class="header">
    <img src="<?= $base_url; ?>assets/logo-brand.png" alt="Logo">
    <h1>Moonlight Café</h1>
    <p>Jl. Contoh Alamat No. 123, Kota Anda</p>
    <p>Telp: 021-1234567 | Email: info@moonlightcafe.com</p>
</div>

<h3 style="text-align:center; margin-bottom: 20px;">LAPORAN ORDER</h3>

<div class="info">
    <table>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td><?= date('d/m/Y', strtotime($tgl_awal)); ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)); ?></td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>:</td>
            <td><?= date('d/m/Y H:i'); ?></td>
        </tr>
    </table>
</div>

<table class="data">
    <thead>
        <tr>
            <th style="width: 30px;">No</th>
            <th style="width: 130px;">Kode Order</th>
            <th>Nama Pelanggan</th>
            <th style="width: 50px;">Meja</th>
            <th style="width: 100px;">Total</th>
            <th style="width: 80px;">Status</th>
            <th style="width: 110px;">Waktu</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data pada periode ini.</td>
            </tr>
        <?php else: ?>
            <?php $no = 1; foreach ($data as $o): ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($o['kode_order']); ?></td>
                <td><?= htmlspecialchars($o['nama']); ?></td>
                <td class="text-center"><?= htmlspecialchars($o['no_meja']); ?></td>
                <td class="text-right"><?= rupiah($o['total_harga']); ?></td>
                <td class="text-center"><?= ucfirst($o['status']); ?></td>
                <td class="text-center"><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="total-box">
    Total Pendapatan (Order Selesai): <?= rupiah($total_pendapatan); ?>
</div>

<div class="footer">
    <p>Kota Anda, <?= date('d/m/Y'); ?></p>
    <p>Administrator,</p>
    <p class="ttd"><?= htmlspecialchars($_SESSION['admin_nama']); ?></p>
</div>

<script>
    window.onload = function() { window.print(); };
    window.onafterprint = function() { window.close(); };
</script>

</body>
</html>