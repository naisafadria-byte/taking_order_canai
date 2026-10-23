<?php
require_once 'config/koneksi.php';
$judul = "Selamat Datang - Moonlight Café";
include 'includes/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-cream p-4">
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row border border-lavender/20">
        
        <!-- Sisi Kiri: Branding & Logo -->
        <div class="md:w-1/2 bg-midnight p-10 flex flex-col justify-center items-center text-center relative overflow-hidden">
            <!-- Dekorasi halus -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-lavender rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-0 w-60 h-60 bg-amber rounded-full blur-3xl"></div>
            </div>
            
            <div class="relative z-10">
                <img src="<?= $base_url; ?>assets/logo-brand.png" alt="Moonlight Café Logo" class="w-32 h-32 object-contain mx-auto mb-6 drop-shadow-lg">
                <h1 class="text-3xl font-bold text-moon mb-3">Moonlight Café</h1>
                <p class="text-lavender text-sm leading-relaxed max-w-xs mx-auto">Nikmati suasana malam yang hangat dengan secangkir kopi pilihan dan hidangan lezat kami.</p>
            </div>
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-midnight">Selamat Datang</h2>
                <p class="text-slate text-sm mt-1">Silakan isi data diri Anda untuk mulai memesan.</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded-r-lg mb-6 text-sm flex items-center gap-2">
                    <i class='bx bx-error-circle text-lg'></i>
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="proses/simpan_pelanggan.php" method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <i class='bx bx-user absolute left-3 top-1/2 -translate-y-1/2 text-plum'></i>
                        <input type="text" name="nama" class="w-full pl-10 pr-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber focus:border-transparent transition text-sm" placeholder="Masukkan nama Anda" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">Nomor Meja</label>
                    <div class="relative">
                        <i class='bx bx-grid-alt absolute left-3 top-1/2 -translate-y-1/2 text-plum'></i>
                        <input type="text" name="no_meja" class="w-full pl-10 pr-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber focus:border-transparent transition text-sm" placeholder="Contoh: A01" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate mb-1.5">No. HP <span class="text-plum font-normal">(Opsional)</span></label>
                    <div class="relative">
                        <i class='bx bx-phone absolute left-3 top-1/2 -translate-y-1/2 text-plum'></i>
                        <input type="text" name="no_hp" class="w-full pl-10 pr-4 py-2.5 bg-cream border border-lavender/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber focus:border-transparent transition text-sm" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <button type="submit" class="w-full bg-amber hover:bg-wood text-white font-semibold py-3 rounded-xl shadow-md transition duration-300 flex items-center justify-center gap-2 mt-2">
                    Mulai Pesan <i class='bx bx-right-arrow-alt text-xl'></i>
                </button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>