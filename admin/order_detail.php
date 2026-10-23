<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . $base_url . "admin/login.php"); exit; }
$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $st = mysqli_real_escape_string($koneksi, $status);
    mysqli_query($koneksi, "UPDATE orders SET status='$st' WHERE id=$id");
    $_SESSION['pesan'] = "Status order berhasil diperbarui.";
    header("Location: order_detail.php?id=$id");
    exit;
}

$judul = "Detail Order";
include '../includes/header.php';

$q = mysqli_query($koneksi, "SELECT o.*, p.nama, p.no_hp FROM orders o
                             JOIN pelanggan p ON o.pelanggan_id = p.id
                             WHERE o.id = $id");
$o = mysqli_fetch_assoc($q);
if (!$o) { header("Location: order.php"); exit; }

$qd = mysqli_query($koneksi, "SELECT * FROM order_detail WHERE order_id = $id");
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

<div class="container mx-auto px-4 py-8 max-w-5xl flex-grow">
    <div class="mb-6 flex items-center gap-3">
        <a href="order.php" class="text-slate hover:text-midnight transition"><i class='bx bx-arrow-back text-2xl'></i></a>
        <h1 class="text-2xl font-bold text-midnight">Detail Order <span class="text-slate font-mono text-lg"><?= $o['kode_order']; ?></span></h1>
    </div>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded-r-lg mb-6 text-sm flex items-center gap-2">
            <i class='bx bx-check-circle text-lg'></i> <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kolom Kiri -->
        <div class="md:col-span-1 space-y-5">
            <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden">
                <div class="bg-cream px-5 py-3 border-b border-lavender/30">
                    <h2 class="font-semibold text-midnight text-sm">Informasi Pelanggan</h2>
                </div>
                <div class="p-5 space-y-3 text-sm">
                    <div>
                        <span class="block text-xs text-slate mb-0.5">Nama</span>
                        <span class="font-medium text-midnight"><?= htmlspecialchars($o['nama']); ?></span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate mb-0.5">No. HP</span>
                        <span class="font-medium text-midnight"><?= htmlspecialchars($o['no_hp'] ?: '-'); ?></span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate mb-0.5">No. Meja</span>
                        <span class="font-medium text-midnight"><?= htmlspecialchars($o['no_meja']); ?></span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate mb-0.5">Waktu Order</span>
                        <span class="font-medium text-midnight"><?= date('d/m/Y H:i', strtotime($o['waktu_order'])); ?></span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate mb-0.5">Catatan</span>
                        <span class="font-medium text-midnight"><?= htmlspecialchars($o['catatan'] ?: '-'); ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden">
                <div class="bg-cream px-5 py-3 border-b border-lavender/30">
                    <h2 class="font-semibold text-midnight text-sm">Update Status</h2>
                </div>
                <div class="p-5">
                    <form method="POST">
                        <select name="status" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm mb-3">
                            <option value="pending" <?= $o['status']=='pending'?'selected':''; ?>>Pending</option>
                            <option value="diproses" <?= $o['status']=='diproses'?'selected':''; ?>>Diproses</option>
                            <option value="selesai" <?= $o['status']=='selesai'?'selected':''; ?>>Selesai</option>
                            <option value="dibatalkan" <?= $o['status']=='dibatalkan'?'selected':''; ?>>Dibatalkan</option>
                        </select>
                        <button class="w-full bg-amber hover:bg-wood text-white font-semibold py-2.5 rounded-xl shadow-sm transition flex items-center justify-center gap-2 text-sm">
                            <i class='bx bx-save text-lg'></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden">
                <div class="bg-cream px-5 py-3 border-b border-lavender/30">
                    <h2 class="font-semibold text-midnight text-sm">Rincian Item</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-white text-slate uppercase text-xs tracking-wider border-b border-lavender/20">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Menu</th>
                                <th class="px-5 py-3 font-semibold text-right">Harga</th>
                                <th class="px-5 py-3 font-semibold text-center">Jumlah</th>
                                <th class="px-5 py-3 font-semibold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-lavender/20">
                            <?php while ($d = mysqli_fetch_assoc($qd)): ?>
                            <tr>
                                <td class="px-5 py-3 font-medium text-midnight"><?= htmlspecialchars($d['nama_menu']); ?></td>
                                <td class="px-5 py-3 text-right text-slate"><?= rupiah($d['harga']); ?></td>
                                <td class="px-5 py-3 text-center text-slate"><?= $d['jumlah']; ?></td>
                                <td class="px-5 py-3 text-right text-midnight font-medium"><?= rupiah($d['subtotal']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <tfoot class="bg-cream border-t border-lavender/30">
                            <tr>
                                <th colspan="3" class="px-5 py-3 text-right text-slate font-semibold">Total</th>
                                <th class="px-5 py-3 text-right text-lg font-bold text-amber"><?= rupiah($o['total_harga']); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>