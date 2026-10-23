<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id']) || !isset($_SESSION['last_order_id'])) {
    header("Location: " . $base_url . "index.php");
    exit;
}

$oid = (int)$_SESSION['last_order_id'];

$q_order = mysqli_query($koneksi, "SELECT o.*, p.nama, p.no_hp FROM orders o
                                   JOIN pelanggan p ON o.pelanggan_id = p.id
                                   WHERE o.id = $oid");
$order = mysqli_fetch_assoc($q_order);

if (!$order) {
    header("Location: " . $base_url . "index.php");
    exit;
}

$q_detail = mysqli_query($koneksi, "SELECT * FROM order_detail WHERE order_id = $oid");
$detail = [];
while ($d = mysqli_fetch_assoc($q_detail)) {
    $detail[] = $d;
}

$judul = "Struk Pesanan - Moonlight Café";
include '../includes/header.php';
?>

<div class="min-h-screen bg-cream py-10 px-4 flex-grow">
    <div class="max-w-md mx-auto">
        
        <div class="text-center mb-6 no-print">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class='bx bx-check text-3xl text-green-600'></i>
            </div>
            <h1 class="text-2xl font-bold text-midnight">Pesanan Berhasil</h1>
            <p class="text-slate text-sm mt-1">Silakan tunjukkan struk ini ke kasir atau pelayan.</p>
        </div>

        <!-- Area Struk -->
        <div class="bg-white rounded-2xl shadow-lg border border-lavender/30 overflow-hidden" id="strukArea">
            <div class="p-8 font-mono text-sm text-midnight">
                <div class="text-center mb-6">
                    <img src="<?= $base_url; ?>assets/logo-brand.png" alt="Logo" class="h-12 w-auto mx-auto mb-3 grayscale">
                    <h2 class="font-bold text-base tracking-widest uppercase">Moonlight Café</h2>
                    <p class="text-xs text-slate mt-1">Jl. Contoh Alamat No. 123, Kota Anda</p>
                    <p class="text-xs text-slate">Telp: 021-1234567</p>
                </div>

                <div class="border-t border-dashed border-slate/30 my-3"></div>

                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate">Kode Order</span>
                        <span class="font-medium"><?= htmlspecialchars($order['kode_order']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate">Tanggal</span>
                        <span><?= date('d/m/Y H:i', strtotime($order['waktu_order'])); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate">Nama</span>
                        <span><?= htmlspecialchars($order['nama']); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate">No. Meja</span>
                        <span><?= htmlspecialchars($order['no_meja']); ?></span>
                    </div>
                    <?php if (!empty($order['no_hp'])): ?>
                    <div class="flex justify-between">
                        <span class="text-slate">No. HP</span>
                        <span><?= htmlspecialchars($order['no_hp']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="border-t border-dashed border-slate/30 my-3"></div>

                <div class="space-y-2 text-xs">
                    <?php foreach ($detail as $d): ?>
                        <div>
                            <div class="font-medium"><?= htmlspecialchars($d['nama_menu']); ?></div>
                            <div class="flex justify-between text-slate">
                                <span><?= $d['jumlah']; ?> x <?= number_format($d['harga'], 0, ',', '.'); ?></span>
                                <span><?= number_format($d['subtotal'], 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-dashed border-slate/30 my-3"></div>

                <div class="flex justify-between font-bold text-sm">
                    <span>TOTAL</span>
                    <span><?= rupiah($order['total_harga']); ?></span>
                </div>
                <div class="flex justify-between text-xs mt-1">
                    <span class="text-slate">Status</span>
                    <span class="uppercase font-medium"><?= ucfirst($order['status']); ?></span>
                </div>

                <?php if (!empty($order['catatan'])): ?>
                <div class="border-t border-dashed border-slate/30 my-3"></div>
                <div class="text-xs">
                    <div class="font-bold mb-1">Catatan:</div>
                    <div class="text-slate"><?= nl2br(htmlspecialchars($order['catatan'])); ?></div>
                </div>
                <?php endif; ?>

                <div class="border-t border-dashed border-slate/30 my-3"></div>

                <div class="text-center text-xs text-slate space-y-1">
                    <p>Terima kasih atas kunjungan Anda</p>
                    <p>Selamat menikmati</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-6 no-print flex flex-col sm:flex-row justify-center gap-3">
            <a href="menu.php" class="inline-flex justify-center items-center gap-2 bg-white border border-lavender/50 hover:border-plum text-slate font-medium py-2.5 px-6 rounded-xl transition text-sm">
                <i class='bx bx-plus-circle'></i> Order Lagi
            </a>
            <a href="<?= $base_url; ?>pelanggan/logout_pelanggan.php" class="inline-flex justify-center items-center gap-2 bg-midnight hover:bg-slate text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition text-sm">
                <i class='bx bx-log-out'></i> Selesai
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        #strukArea { box-shadow: none !important; border: none !important; }
        .min-h-screen { min-height: auto !important; padding: 0 !important; }
    }
</style>

<?php include '../includes/footer.php'; ?>