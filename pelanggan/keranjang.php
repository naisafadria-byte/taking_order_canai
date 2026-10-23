<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: " . $base_url . "index.php");
    exit;
}
$judul = "Keranjang - Moonlight Café";
include '../includes/header.php';
include '../includes/navbar.php';

$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
$total = 0;
?>

<div class="container mx-auto px-4 py-8 max-w-4xl flex-grow">
    <div class="flex items-center gap-3 mb-6">
        <a href="menu.php" class="text-slate hover:text-midnight transition"><i class='bx bx-arrow-back text-2xl'></i></a>
        <h1 class="text-2xl font-bold text-midnight">Keranjang Pesanan</h1>
    </div>

    <?php if (empty($keranjang)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 p-12 text-center">
            <i class='bx bx-cart text-5xl text-lavender mb-4'></i>
            <p class="text-slate mb-4">Keranjang Anda masih kosong.</p>
            <a href="menu.php" class="inline-flex items-center gap-2 bg-amber hover:bg-wood text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition text-sm">
                <i class='bx bx-coffee'></i> Lihat Menu
            </a>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-cream text-slate uppercase text-xs tracking-wider border-b border-lavender/30">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Menu</th>
                            <th class="px-4 py-3 font-semibold text-right">Harga</th>
                            <th class="px-4 py-3 font-semibold text-center">Jumlah</th>
                            <th class="px-4 py-3 font-semibold text-right">Subtotal</th>
                            <th class="px-4 py-3 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-lavender/20">
                        <?php foreach ($keranjang as $mid => $jml):
                            $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $mid");
                            $m = mysqli_fetch_assoc($q);
                            if (!$m) continue;
                            $sub = $m['harga'] * $jml;
                            $total += $sub;
                        ?>
                        <tr class="hover:bg-cream/50 transition">
                            <td class="px-4 py-3 font-medium text-midnight"><?= htmlspecialchars($m['nama_menu']); ?></td>
                            <td class="px-4 py-3 text-right text-slate"><?= rupiah($m['harga']); ?></td>
                            <td class="px-4 py-3">
                                <form action="../proses/update_keranjang.php" method="POST" class="flex gap-1 justify-center items-center">
                                    <input type="hidden" name="menu_id" value="<?= $mid; ?>">
                                    <input type="number" name="jumlah" value="<?= $jml; ?>" min="1" max="<?= $m['stok']; ?>"
                                           class="w-16 px-2 py-1.5 border border-lavender/50 rounded-lg text-center text-sm focus:outline-none focus:ring-1 focus:ring-amber bg-cream">
                                    <button class="p-1.5 text-plum hover:text-amber transition" type="submit" title="Update">
                                        <i class='bx bx-refresh text-lg'></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-midnight"><?= rupiah($sub); ?></td>
                            <td class="px-4 py-3 text-center">
                                <a href="../proses/hapus_keranjang.php?id=<?= $mid; ?>" class="p-1.5 text-red-400 hover:text-red-600 transition" title="Hapus">
                                    <i class='bx bx-trash text-lg'></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-cream border-t border-lavender/30">
                        <tr>
                            <th colspan="3" class="px-4 py-3 text-right text-slate font-semibold">Total</th>
                            <th class="px-4 py-3 text-right text-lg font-bold text-amber"><?= rupiah($total); ?></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between gap-3">
            <a href="menu.php" class="inline-flex justify-center items-center gap-2 bg-white border border-lavender/50 hover:border-plum text-slate font-medium py-2.5 px-6 rounded-xl transition text-sm">
                <i class='bx bx-arrow-back'></i> Lanjut Pesan
            </a>
            <a href="checkout.php" class="inline-flex justify-center items-center gap-2 bg-amber hover:bg-wood text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition text-sm">
                Checkout <i class='bx bx-right-arrow-alt text-lg'></i>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>