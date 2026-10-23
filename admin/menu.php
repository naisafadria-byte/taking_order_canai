<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . $base_url . "admin/login.php"); exit; }
$judul = "Kelola Menu";
include '../includes/header.php';

$q = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY kategori, nama_menu");
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
            <h1 class="text-2xl font-bold text-midnight">Kelola Menu</h1>
            <p class="text-slate text-sm mt-1">Daftar seluruh menu yang tersedia di kafe.</p>
        </div>
        <a href="menu_tambah.php" class="inline-flex items-center gap-2 bg-amber hover:bg-wood text-white font-semibold py-2.5 px-5 rounded-xl shadow-sm transition text-sm">
            <i class='bx bx-plus-circle text-lg'></i> Tambah Menu
        </a>
    </div>

    <?php if (isset($_SESSION['pesan'])): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 rounded-r-lg mb-6 text-sm flex items-center gap-2">
            <i class='bx bx-check-circle text-lg'></i> <?= $_SESSION['pesan']; unset($_SESSION['pesan']); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-cream text-slate uppercase text-xs tracking-wider border-b border-lavender/30">
                    <tr>
                        <th class="px-4 py-3 font-semibold w-12">No</th>
                        <th class="px-4 py-3 font-semibold">Gambar</th>
                        <th class="px-4 py-3 font-semibold">Nama</th>
                        <th class="px-4 py-3 font-semibold">Kategori</th>
                        <th class="px-4 py-3 font-semibold text-right">Harga</th>
                        <th class="px-4 py-3 font-semibold text-center">Stok</th>
                        <th class="px-4 py-3 font-semibold text-center">Status</th>
                        <th class="px-4 py-3 font-semibold text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-lavender/20">
                    <?php $no=1; while ($m = mysqli_fetch_assoc($q)): ?>
                    <tr class="hover:bg-cream/50 transition">
                        <td class="px-4 py-3 text-slate"><?= $no++; ?></td>
                        <td class="px-4 py-3">
                            <div class="w-12 h-12 rounded-lg bg-cream overflow-hidden border border-lavender/30">
                                <img src="<?= $base_url; ?>assets/img/menu/<?= htmlspecialchars($m['gambar']); ?>" alt="<?= htmlspecialchars($m['nama_menu']); ?>" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100x100/FAF5EE/C6B1D6?text=No+Img'">
                            </div>
                        </td>
                        <td class="px-4 py-3 font-medium text-midnight"><?= htmlspecialchars($m['nama_menu']); ?></td>
                        <td class="px-4 py-3"><span class="inline-block bg-lavender/20 text-plum text-xs px-2.5 py-1 rounded-md"><?= htmlspecialchars($m['kategori']); ?></span></td>
                        <td class="px-4 py-3 text-right text-slate"><?= rupiah($m['harga']); ?></td>
                        <td class="px-4 py-3 text-center text-slate"><?= $m['stok']; ?></td>
                        <td class="px-4 py-3 text-center">
                            <?php if ($m['status'] == 'tersedia'): ?>
                                <span class="inline-block bg-green-50 text-green-700 border border-green-200 text-xs px-2.5 py-1 rounded-md">Tersedia</span>
                            <?php else: ?>
                                <span class="inline-block bg-red-50 text-red-700 border border-red-200 text-xs px-2.5 py-1 rounded-md">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-1">
                                <a href="menu_edit.php?id=<?= $m['id']; ?>" class="p-1.5 text-plum hover:text-amber transition" title="Edit"><i class='bx bx-edit text-lg'></i></a>
                                <a href="menu_hapus.php?id=<?= $m['id']; ?>" class="p-1.5 text-red-400 hover:text-red-600 transition" title="Hapus" onclick="return confirm('Hapus menu ini?')"><i class='bx bx-trash text-lg'></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>