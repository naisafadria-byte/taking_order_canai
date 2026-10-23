<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['pelanggan_id'])) { header("Location: " . $base_url . "index.php"); exit; }
$judul = "Menu - Moonlight Café";
include '../includes/header.php';
include '../includes/navbar.php';

$kategori_filter = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$where = "WHERE status = 'tersedia'";
if ($kategori_filter != '') {
    $kf = mysqli_real_escape_string($koneksi, $kategori_filter);
    $where .= " AND kategori = '$kf'";
}
$query = mysqli_query($koneksi, "SELECT * FROM menu $where ORDER BY kategori, nama_menu");
$kategori_list = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM menu ORDER BY kategori");
?>

<div class="container mx-auto px-4 py-8 max-w-6xl flex-grow">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-midnight">Menu Kami</h1>
            <p class="text-slate text-sm mt-1">Pilih menu favorit Anda hari ini.</p>
        </div>
        <a href="<?= $base_url; ?>pelanggan/keranjang.php" class="bg-amber hover:bg-wood text-white px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 text-sm font-medium">
            <i class='bx bx-cart-alt text-lg'></i> Lihat Keranjang
        </a>
    </div>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded-r-lg mb-6 text-sm flex items-center gap-2">
            <i class='bx bx-check-circle text-lg'></i> <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
        </div>
    <?php endif; ?>

    <!-- Filter Kategori -->
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="menu.php" class="px-4 py-1.5 rounded-full text-sm font-medium transition border <?= $kategori_filter == '' ? 'bg-midnight text-white border-midnight' : 'bg-white text-slate border-lavender hover:border-plum'; ?>">Semua</a>
        <?php while ($k = mysqli_fetch_assoc($kategori_list)): ?>
            <a href="menu.php?kategori=<?= urlencode($k['kategori']); ?>" class="px-4 py-1.5 rounded-full text-sm font-medium transition border <?= $kategori_filter == $k['kategori'] ? 'bg-midnight text-white border-midnight' : 'bg-white text-slate border-lavender hover:border-plum'; ?>">
                <?= htmlspecialchars($k['kategori']); ?>
            </a>
        <?php endwhile; ?>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php if (mysqli_num_rows($query) == 0): ?>
            <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-lavender/30">
                <i class='bx bx-coffee text-5xl text-lavender mb-3'></i>
                <p class="text-slate">Belum ada menu tersedia untuk kategori ini.</p>
            </div>
        <?php endif; ?>
        <?php while ($m = mysqli_fetch_assoc($query)): ?>
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition duration-300 overflow-hidden border border-lavender/30 flex flex-col group">
                <!-- Gambar Produk -->
                <div class="h-48 w-full bg-cream relative overflow-hidden">
                    <img src="<?= $base_url; ?>assets/img/menu/<?= htmlspecialchars($m['gambar']); ?>" alt="<?= htmlspecialchars($m['nama_menu']); ?>" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" onerror="this.src='https://placehold.co/400x300/FAF5EE/C6B1D6?text=No+Image'">
                    <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm text-xs font-semibold px-2.5 py-1 rounded-md text-midnight shadow-sm border border-lavender/20"><?= htmlspecialchars($m['kategori']); ?></span>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-base font-bold text-midnight mb-1 leading-tight"><?= htmlspecialchars($m['nama_menu']); ?></h3>
                    <p class="text-slate text-xs mb-3 flex-grow line-clamp-2"><?= htmlspecialchars($m['deskripsi']); ?></p>
                    
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-base font-bold text-amber"><?= rupiah($m['harga']); ?></span>
                        <span class="text-[10px] font-medium text-plum bg-lavender/20 px-2 py-0.5 rounded">Stok: <?= $m['stok']; ?></span>
                    </div>
                    
                    <form action="../proses/tambah_keranjang.php" method="POST" class="flex gap-2 mt-auto">
                        <input type="hidden" name="menu_id" value="<?= $m['id']; ?>">
                        <input type="number" name="jumlah" value="1" min="1" max="<?= $m['stok']; ?>" class="w-14 px-2 py-1.5 border border-lavender/50 rounded-lg text-center text-sm focus:outline-none focus:ring-1 focus:ring-amber bg-cream">
                        <button type="submit" class="flex-1 bg-midnight hover:bg-slate text-white text-sm font-medium py-1.5 rounded-lg transition flex items-center justify-center gap-1">
                            <i class='bx bx-plus'></i> Tambah
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>