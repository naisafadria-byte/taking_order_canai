<nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-lavender/30">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center max-w-6xl">
        <!-- Logo Brand -->
        <a class="flex items-center gap-3" href="<?= $base_url; ?>pelanggan/menu.php">
            <img src="<?= $base_url; ?>assets/logo-brand.png" alt="Moonlight Café Logo" class="h-10 w-auto object-contain">
            <span class="text-xl font-bold text-midnight hidden sm:block tracking-tight">Moonlight Café</span>
        </a>
        
        <div class="flex items-center gap-4">
            <?php if (isset($_SESSION['pelanggan_id'])): ?>
                <span class="text-sm text-slate hidden md:flex items-center gap-2 bg-cream px-3 py-1.5 rounded-full border border-lavender/50">
                    <i class='bx bx-user-circle text-lg text-plum'></i>
                    <span class="font-medium"><?= htmlspecialchars($_SESSION['pelanggan_nama']); ?></span>
                    <span class="text-xs text-plum bg-lavender/30 px-2 py-0.5 rounded-full">Meja: <?= htmlspecialchars($_SESSION['pelanggan_meja']); ?></span>
                </span>
                
                <a href="<?= $base_url; ?>pelanggan/keranjang.php" class="relative bg-amber hover:bg-wood text-white px-4 py-2 rounded-xl transition flex items-center gap-2 text-sm font-medium shadow-sm">
                    <i class='bx bx-cart-alt text-lg'></i> 
                    <span class="hidden sm:inline">Keranjang</span>
                    <span class="absolute -top-2 -right-2 bg-midnight text-white text-xs w-5 h-5 flex items-center justify-center rounded-full border-2 border-white shadow-sm">
                        <?= isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0; ?>
                    </span>
                </a>
                <a href="<?= $base_url; ?>pelanggan/logout_pelanggan.php" class="text-sm font-medium text-slate hover:text-amber transition flex items-center gap-1">
                    <i class='bx bx-log-out'></i> <span class="hidden sm:inline">Selesai</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>