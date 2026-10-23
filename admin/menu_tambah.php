<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . $base_url . "admin/login.php"); exit; }
$judul = "Tambah Menu";
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $kat  = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga= (float)$_POST['harga'];
    $desc = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $stok = (int)$_POST['stok'];
    $status = $_POST['status'];
    
    $gambar = 'default.jpg';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed)) {
            $gambar = uniqid() . '.' . $ext;
            $upload_path = '../assets/img/menu/' . $gambar;
            if (!is_dir('../assets/img/menu/')) { mkdir('../assets/img/menu/', 0777, true); }
            move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path);
        }
    }

    $sql = "INSERT INTO menu (nama_menu, kategori, harga, deskripsi, stok, gambar, status)
            VALUES ('$nama', '$kat', $harga, '$desc', $stok, '$gambar', '$status')";
    if (mysqli_query($koneksi, $sql)) {
        $_SESSION['pesan'] = "Menu berhasil ditambahkan.";
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
        <h1 class="text-2xl font-bold text-midnight">Tambah Menu Baru</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-lavender/30 p-6 md:p-8">
        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Nama Menu</label>
                    <input type="text" name="nama_menu" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Kategori</label>
                    <input type="text" name="kategori" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" placeholder="Kopi / Makanan / Minuman" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Harga (Rp)</label>
                    <input type="number" name="harga" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Stok</label>
                    <input type="number" name="stok" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm" value="0" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:ring-2 focus:ring-amber focus:outline-none text-sm">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Foto Produk</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 border border-lavender/50 rounded-xl focus:outline-none file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-lavender/30 file:text-midnight hover:file:bg-lavender/50 text-sm bg-cream">
                    <p class="text-[11px] text-plum mt-1.5">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-amber hover:bg-wood text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                    <i class='bx bx-save text-lg'></i> Simpan Menu
                </button>
                <a href="menu.php" class="bg-gray-100 hover:bg-gray-200 text-slate font-semibold py-2.5 px-6 rounded-xl transition text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>