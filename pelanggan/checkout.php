<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) {
    header("Location: " . $base_url . "index.php");
    exit;
}
$keranjang = isset($_SESSION['keranjang']) ? $_SESSION['keranjang'] : [];
if (empty($keranjang)) {
    header("Location: " . $base_url . "pelanggan/keranjang.php");
    exit;
}
$total = 0;
foreach ($keranjang as $mid => $jml) {
    $q = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id = $mid");
    $m = mysqli_fetch_assoc($q);
    if ($m) $total += $m['harga'] * $jml;
}
$judul = "Checkout - Moonlight Café";
include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mx-auto px-4 py-8 max-w-5xl flex-grow">
    <div class="flex items-center gap-3 mb-6">
        <a href="keranjang.php" class="text-slate hover:text-midnight transition"><i class='bx bx-arrow-back text-2xl'></i></a>
        <h1 class="text-2xl font-bold text-midnight">Konfirmasi Pesanan</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <!-- Kolom Kiri: Data & Catatan -->
        <div class="md:col-span-3 space-y-5">
            <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden">
                <div class="bg-cream px-5 py-3 border-b border-lavender/30">
                    <h2 class="font-semibold text-midnight text-sm">Data Pelanggan</h2>
                </div>
                <div class="p-5 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate">Nama</span>
                        <span class="font-medium text-midnight"><?= htmlspecialchars($_SESSION['pelanggan_nama']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate">No. Meja</span>
                        <span class="font-medium text-midnight"><?= htmlspecialchars($_SESSION['pelanggan_meja']); ?></span>
                    </div>
                </div>
            </div>

            <form action="../proses/simpan_order.php" method="POST">
                <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden mb-5">
                    <div class="bg-cream px-5 py-3 border-b border-lavender/30">
                        <h2 class="font-semibold text-midnight text-sm">Catatan Tambahan</h2>
                    </div>
                    <div class="p-5">
                        <textarea name="catatan" rows="3" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber text-sm" placeholder="Contoh: tanpa gula, extra shot, dll (opsional)"></textarea>
                    </div>
                </div>
                <button type="submit" class="w-full bg-amber hover:bg-wood text-white font-semibold py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                    <i class='bx bx-send text-lg'></i> Kirim Pesanan
                </button>
            </form>
        </div>

        <!-- Kolom Kanan: Rincian -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden sticky top-24">
                <div class="bg-cream px-5 py-3 border-b border-lavender/30">
                    <h2 class="font-semibold text-midnight text-sm">Rincian Pesanan</h2>
                </div>
                <div class="p-5 space-y-3 text-sm">
                    <?php foreach ($keranjang as $mid => $jml):
                        $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $mid");
                        $m = mysqli_fetch_assoc($q);
                        if (!$m) continue;
                    ?>
                    <div class="flex justify-between items-start gap-2">
                        <div>
                            <p class="font-medium text-midnight"><?= htmlspecialchars($m['nama_menu']); ?></p>
                            <p class="text-xs text-slate"><?= $jml; ?> x <?= rupiah($m['harga']); ?></p>
                        </div>
                        <span class="font-medium text-midnight whitespace-nowrap"><?= rupiah($m['harga'] * $jml); ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="border-t border-lavender/30 pt-3 mt-3 flex justify-between items-center">
                        <span class="font-bold text-midnight">Total</span>
                        <span class="font-bold text-lg text-amber"><?= rupiah($total); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>