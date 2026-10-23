<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . $base_url . "admin/login.php"); exit; }
$judul = "Laporan Order";
include '../includes/header.php';

$tgl_awal  = $_GET['tgl_awal']  ?? date('Y-m-01');
$tgl_akhir = $_GET['tgl_akhir'] ?? date('Y-m-d');

$ta = mysqli_real_escape_string($koneksi, $tgl_awal);
$tk = mysqli_real_escape_string($koneksi, $tgl_akhir);

$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE DATE(o.waktu_order) BETWEEN '$ta' AND '$tk'
                             ORDER BY o.waktu_order DESC");

$total_pendapatan = 0;
$data = [];
while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row;
    if ($row['status'] == 'selesai') $total_pendapatan += $row['total_harga'];
}
?>

<!-- Navbar Admin -->
<nav class="bg-midnight text-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center max-w-6xl">
        <a class="text-lg font-bold flex items-center gap-3" href="<?= $base_url; ?>admin/dashboard.php">
            <img src="<?= $base_url; ?>assets/logo-brand.png" alt="Logo" class="h-8 w-auto object-contain">
            <span class="hidden sm:block">Admin Panel</span>
        </a>
        <div class="flex items-center gap-4">
            <span class="text-sm text-lavender hidden md:inline"><i class='bx bx-user-circle mr-1'></i><?= htmlspecialchars($_SESSION['admin_nama']); ?></span>
            <a href="logout.php" class="text-sm bg-slate hover:bg-wood px-4 py-2 rounded-lg transition">Logout</a>
        </div>
    </div>
</nav>

<div class="container mx-auto px-4 py-8 max-w-6xl flex-grow">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-midnight">Laporan Order</h1>
        <p class="text-slate text-sm mt-1">Filter dan cetak laporan berdasarkan periode.</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 p-5 mb-6">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-slate mb-1.5">Tanggal Awal</label>
                <input type="date" name="tgl_awal" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" value="<?= $tgl_awal; ?>">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate mb-1.5">Tanggal Akhir</label>
                <input type="date" name="tgl_akhir" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" value="<?= $tgl_akhir; ?>">
            </div>
            <div>
                <button class="w-full bg-midnight hover:bg-slate text-white font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                    <i class='bx bx-filter-alt'></i> Filter
                </button>
            </div>
            <div>
                <a href="cetak_laporan.php?tgl_awal=<?= $tgl_awal; ?>&tgl_akhir=<?= $tgl_akhir; ?>" target="_blank" class="w-full bg-white border border-midnight text-midnight hover:bg-midnight hover:text-white font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                    <i class='bx bx-printer'></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Info Pendapatan -->
    <div class="bg-gradient-to-r from-midnight to-slate rounded-2xl p-5 mb-6 text-white flex items-center justify-between shadow-md">
        <div>
            <p class="text-lavender text-xs uppercase tracking-wider font-medium mb-1">Total Pendapatan (Order Selesai)</p>
            <h2 class="text-2xl font-bold text-moon"><?= rupiah($total_pendapatan); ?></h2>
        </div>
        <div class="bg-white/10 p-3 rounded-xl hidden sm:block">
            <i class='bx bx-wallet text-2xl text-moon'></i>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-cream text-slate uppercase text-xs tracking-wider border-b border-lavender/30">
                    <tr>
                        <th class="px-4 py-3 font-semibold w-12">No</th>
                        <th class="px-4 py-3 font-semibold">Kode</th>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold text-center">Meja</th>
                        <th class="px-4 py-3 font-semibold text-right">Total</th>
                        <th class="px-4 py-3 font-semibold text-center">Status</th>
                        <th class="px-4 py-3 font-semibold">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-lavender/20">
                    <?php if (empty($data)): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-slate">
                                <i class='bx bx-folder-open text-4xl text-lavender mb-2 block'></i>
                                Tidak ada data pada periode ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($data as $o): ?>
                        <tr class="hover:bg-cream/50 transition">
                            <td class="px-4 py-3 text-slate"><?= $no++; ?></td>
                            <td class="px-4 py-3 font-mono text-xs text-slate"><?= htmlspecialchars($o['kode_order']); ?></td>
                            <td class="px-4 py-3 font-medium text-midnight"><?= htmlspecialchars($o['nama']); ?></td>
                            <td class="px-4 py-3 text-center text-slate"><?= htmlspecialchars($o['no_meja']); ?></td>
                            <td class="px-4 py-3 text-right text-slate"><?= rupiah($o['total_harga']); ?></td>
                            <td class="px-4 py-3 text-center">
                                <?php
                                $badgeClass = 'bg-gray-100 text-gray-700 border-gray-200';
                                if ($o['status']=='pending') $badgeClass = 'bg-yellow-50 text-yellow-700 border-yellow-200';
                                elseif ($o['status']=='diproses') $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                                elseif ($o['status']=='selesai') $badgeClass = 'bg-green-50 text-green-700 border-green-200';
                                elseif ($o['status']=='dibatalkan') $badgeClass = 'bg-red-50 text-red-700 border-red-200';
                                ?>
                                <span class="inline-block border text-xs px-2.5 py-1 rounded-md <?= $badgeClass; ?>"><?= ucfirst($o['status']); ?></span>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate"><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>