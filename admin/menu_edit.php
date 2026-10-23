<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . $base_url . "admin/login.php"); exit; }
$judul = "Edit Menu";
include '../includes/header.php';

$id = (int)$_GET['id'];
$q  = mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $id");
$m  = mysqli_fetch_assoc($q);
if (!$m) { header("Location: menu.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $kat  = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga= (float)$_POST['harga'];
    $desc = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $stok = (int)$_POST['stok'];
    $status = $_POST['status'];
    
    $gambar_sql = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed)) {
            $gambar_baru = uniqid() . '.' . $ext;
            $upload_path = '../assets/img/menu/' . $gambar_baru;
            if (!is_dir('../assets/img/menu/')) { mkdir('../assets/img/menu/', 0777, true); }
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                // Hapus gambar lama jika bukan default
                if ($m['gambar'] != 'default.jpg' && file_exists('../assets/img/menu/' . $m['gambar'])) {
                    unlink('../assets/img/menu/' . $m['gambar']);
                }
                $gambar_sql = ", gambar='$gambar_baru'";
            }
        }
    }

    $sql = "UPDATE menu SET nama_menu='$nama', kategori='$kat', harga=$harga,
            deskripsi='$desc', stok=$stok, status='$status' $gambar_sql WHERE id=$id";
    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['pesan'] = "Menu berhasil diperbarui.";
        header("Location: menu.php");
        exit;
    }
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

<div class="container mx-auto px-4 py-8 max-w-3xl flex-grow">
    <div class="mb-6 flex items-center gap-3">
        <a href="menu.php" class="text-slate hover:text-midnight transition"><i class='bx bx-arrow-back text-2xl'></i></a>
        <h1 class="text-2xl font-bold text-midnight">Edit Menu</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 p-6 md:p-8">
        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Nama Menu</label>
                    <input type="text" name="nama_menu" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" value="<?= htmlspecialchars($m['nama_menu']); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Kategori</label>
                    <input type="text" name="kategori" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" value="<?= htmlspecialchars($m['kategori']); ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Harga (Rp)</label>
                    <input type="number" name="harga" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" value="<?= $m['harga']; ?>" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Stok</label>
                    <input type="number" name="stok" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" value="<?= $m['stok']; ?>" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm"><?= htmlspecialchars($m['deskripsi']); ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm">
                        <option value="tersedia" <?= $m['status']=='tersedia'?'selected':''; ?>>Tersedia</option>
                        <option value="habis" <?= $m['status']=='habis'?'selected':''; ?>>Habis</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Ganti Foto <span class="text-plum font-normal">(Opsional)</span></label>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-lg bg-cream overflow-hidden border border-lavender/30 shrink-0">
                            <img src="<?= $base_url; ?>assets/img/menu/<?= htmlspecialchars($m['gambar']); ?>" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100x100/FAF5EE/C6B1D6?text=No+Img'">
                        </div>
                        <input type="file" name="gambar" accept="image/*" class="w-full px-3 py-1.5 border border-lavender/50 rounded-xl focus:outline-none file:mr-3 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-lavender/30 file:text-midnight hover:file:bg-lavender/50 text-xs bg-cream">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-amber hover:bg-wood text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                    <i class='bx bx-save text-lg'></i> Update Menu
                </button>
                <a href="menu.php" class="bg-gray-100 hover:bg-gray-200 text-slate font-semibold py-2.5 px-6 rounded-xl transition text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>