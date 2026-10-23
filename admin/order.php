<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . $base_url . "admin/login.php"); exit; }
$judul = "Data Order";
include '../includes/header.php';

$filter = $_GET['status'] ?? '';
$where = "";
if ($filter != '') {
    $f = mysqli_real_escape_string($koneksi, $filter);
    $where = "WHERE o.status = '$f'";
}
$q = mysqli_query($koneksi, "SELECT o.*, p.nama FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             $where ORDER BY o.waktu_order DESC");
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
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-midnight">Data Order</h1>
            <p class="text-slate text-sm mt-1">Pantau dan perbarui status pesanan pelanggan.</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="order.php" class="px-4 py-1.5 rounded-full text-xs font-medium transition border <?= $filter==''?'bg-midnight text-white border-midnight':'bg-white text-slate border-lavender hover:border-plum'; ?>">Semua</a>
        <a href="order.php?status=pending" class="px-4 py-1.5 rounded-full text-xs font-medium transition border <?= $filter=='pending'?'bg-midnight text-white border-midnight':'bg-white text-slate border-lavender hover:border-plum'; ?>">Pending</a>
        <a href="order.php?status=diproses" class="px-4 py-1.5 rounded-full text-xs font-medium transition border <?= $filter=='diproses'?'bg-midnight text-white border-midnight':'bg-white text-slate border-lavender hover:border-plum'; ?>">Diproses</a>
        <a href="order.php?status=selesai" class="px-4 py-1.5 rounded-full text-xs font-medium transition border <?= $filter=='selesai'?'bg-midnight text-white border-midnight':'bg-white text-slate border-lavender hover:border-plum'; ?>">Selesai</a>
        <a href="order.php?status=dibatalkan" class="px-4 py-1.5 rounded-full text-xs font-medium transition border <?= $filter=='dibatalkan'?'bg-midnight text-white border-midnight':'bg-white text-slate border-lavender hover:border-plum'; ?>">Dibatalkan</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-cream text-slate uppercase text-xs tracking-wider border-b border-lavender/30">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Kode</th>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold text-center">Meja</th>
                        <th class="px-4 py-3 font-semibold text-right">Total</th>
                        <th class="px-4 py-3 font-semibold text-center">Status</th>
                        <th class="px-4 py-3 font-semibold">Waktu</th>
                        <th class="px-4 py-3 font-semibold text-center w-16">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-lavender/20">
                    <?php while ($o = mysqli_fetch_assoc($q)): ?>
                    <tr class="hover:bg-cream/50 transition">
                        <td class="px-4 py-3 font-mono text-xs text-slate"><?= $o['kode_order']; ?></td>
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
                        <td class="px-4 py-3 text-center">
                            <a href="order_detail.php?id=<?= $o['id']; ?>" class="p-1.5 text-plum hover:text-amber transition inline-block" title="Detail"><i class='bx bx-show text-lg'></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>