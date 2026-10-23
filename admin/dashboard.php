<?php
require_once '../config/koneksi.php';
if (!isset($_SESSION['admin_id'])) { header("Location: " . $base_url . "admin/login.php"); exit; }
$judul = "Dashboard Admin";

$total_menu   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as j FROM menu"))['j'];
$total_order  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as j FROM orders"))['j'];
$total_pending= mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as j FROM orders WHERE status='pending'"))['j'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(total_harga),0) as j FROM orders WHERE status='selesai'"))['j'];

include '../includes/header.php';
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
    <h1 class="text-2xl font-bold text-midnight mb-6">Dashboard Overview</h1>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-lavender/20 border-l-4 border-l-midnight">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate text-xs font-medium uppercase tracking-wider">Total Menu</p>
                    <h3 class="text-2xl font-bold text-midnight mt-2"><?= $total_menu; ?></h3>
                </div>
                <div class="bg-midnight/5 p-2.5 rounded-xl"><i class='bx bx-food-menu text-xl text-midnight'></i></div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-lavender/20 border-l-4 border-l-amber">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate text-xs font-medium uppercase tracking-wider">Total Order</p>
                    <h3 class="text-2xl font-bold text-midnight mt-2"><?= $total_order; ?></h3>
                </div>
                <div class="bg-amber/5 p-2.5 rounded-xl"><i class='bx bx-receipt text-xl text-amber'></i></div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-lavender/20 border-l-4 border-l-butter">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate text-xs font-medium uppercase tracking-wider">Order Pending</p>
                    <h3 class="text-2xl font-bold text-midnight mt-2"><?= $total_pending; ?></h3>
                </div>
                <div class="bg-butter/20 p-2.5 rounded-xl"><i class='bx bx-time-five text-xl text-yellow-600'></i></div>
            </div>
        </div>
        <!-- Card 4 -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-lavender/20 border-l-4 border-l-plum">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate text-xs font-medium uppercase tracking-wider">Pendapatan</p>
                    <h3 class="text-lg font-bold text-midnight mt-2"><?= rupiah($total_pendapatan); ?></h3>
                </div>
                <div class="bg-plum/5 p-2.5 rounded-xl"><i class='bx bx-wallet text-xl text-plum'></i></div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <a href="menu.php" class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition flex items-center gap-4 group border border-lavender/20">
            <div class="bg-lavender/20 p-3 rounded-full group-hover:bg-lavender/40 transition"><i class='bx bx-coffee text-xl text-midnight'></i></div>
            <div>
                <h4 class="font-bold text-midnight text-sm">Kelola Menu</h4>
                <p class="text-xs text-slate mt-0.5">Tambah, edit, atau hapus menu</p>
            </div>
        </a>
        <a href="order.php" class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition flex items-center gap-4 group border border-lavender/20">
            <div class="bg-amber/10 p-3 rounded-full group-hover:bg-amber/20 transition"><i class='bx bx-list-ul text-xl text-amber'></i></div>
            <div>
                <h4 class="font-bold text-midnight text-sm">Data Order</h4>
                <p class="text-xs text-slate mt-0.5">Lihat dan update status pesanan</p>
            </div>
        </a>
        <a href="laporan.php" class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition flex items-center gap-4 group border border-lavender/20">
            <div class="bg-plum/10 p-3 rounded-full group-hover:bg-plum/20 transition"><i class='bx bx-file text-xl text-plum'></i></div>
            <div>
                <h4 class="font-bold text-midnight text-sm">Laporan</h4>
                <p class="text-xs text-slate mt-0.5">Cetak laporan pendapatan</p>
            </div>
        </a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>