<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul) ? $judul : 'Moonlight Café'; ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Google Fonts: Poppins untuk kesan modern & elegan -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        midnight: '#2A253B', // Teks utama, background gelap
                        slate: '#3D3752',    // Varian gelap
                        moon: '#FFF1C5',     // Aksen terang
                        butter: '#FCE38A',   // Aksen kuning
                        lavender: '#C6B1D6', // Aksen ungu pastel
                        plum: '#A890B8',     // Ungu medium
                        cream: '#FAF5EE',    // Background utama terang
                        wood: '#E8A87C',     // Aksen hangat
                        amber: '#D9825B'     // Tombol utama / CTA
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAF5EE; color: #2A253B; }
        /* Scrollbar halus */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #FAF5EE; }
        ::-webkit-scrollbar-thumb { background: #C6B1D6; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #A890B8; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">