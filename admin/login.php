<?php
require_once '../config/koneksi.php';
if (isset($_SESSION['admin_id'])) {
    header("Location: " . $base_url . "admin/dashboard.php");
    exit;
}
$judul = "Login Admin - Moonlight Café";
include '../includes/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-midnight p-4 relative overflow-hidden">
    <!-- Dekorasi halus -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-lavender rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-amber rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
    </div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden relative z-10">
        <div class="p-8 md:p-10">
            <div class="text-center mb-8">
                <img src="<?= $base_url; ?>assets/logo-brand.png" alt="Moonlight Café Logo" class="h-16 w-auto mx-auto mb-4 object-contain">
                <h1 class="text-2xl font-bold text-midnight">Login Admin</h1>
                <p class="text-slate text-sm mt-1">Masuk ke panel administrasi.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-r-lg mb-6 text-sm flex items-center gap-2">
                    <i class='bx bx-error-circle text-lg'></i>
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Username</label>
                    <div class="relative">
                        <i class='bx bx-user absolute left-3 top-1/2 -translate-y-1/2 text-plum'></i>
                        <input type="text" name="username" class="w-full pl-10 pr-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber focus:border-transparent transition text-sm" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Password</label>
                    <div class="relative">
                        <i class='bx bx-lock-alt absolute left-3 top-1/2 -translate-y-1/2 text-plum'></i>
                        <input type="password" name="password" class="w-full pl-10 pr-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber focus:border-transparent transition text-sm" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="w-full bg-amber hover:bg-wood text-white font-semibold py-3 rounded-xl shadow-md transition duration-300 flex items-center justify-center gap-2 mt-2">
                    <i class='bx bx-log-in-circle text-lg'></i> Login
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="<?= $base_url; ?>index.php" class="text-xs text-plum hover:text-amber transition">Kembali ke Halaman Pelanggan</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>