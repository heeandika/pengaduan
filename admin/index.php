<?php
include "../koneksi.php";

// Cek apakah ada parameter page di url
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    
    // Routing berdasarkan nilai page
    switch ($page) {
        case 'aspirasi':
            $konten = "aspirasi.php";
            break;
        case 'siswa':
            $konten = "siswa.php";
            break;
        case 'kategori':
            $konten = "kategori.php";
            break;
        case 'logout':
            $konten = "logout.php";
            break;
        case 'hapus_siswa':
            $konten = "hapus_siswa.php";
            break;
        case 'hapus_kategori':
            $konten = "hapus_kategori.php";
            break;
        case 'edit_aspirasi':
            $konten = "edit_aspirasi.php";
            break;
        
        default:
            $konten = "404.php"; // Halaman tidak ditemukan
            break;
    }
    
    // Tampilkan konten yang sesuai
    if ($konten === "404.php") {
        include "404.php";
    } else {
        include "kerangka.php"; // File template utama
    }
} else {
    // Jika tidak ada parameter page, tampilkan 404
    include "404.php";
}
?>