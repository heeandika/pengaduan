<?php
include "koneksi.php";

// Cek apakah ada parameter page di url
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    
    // Routing berdasarkan nilai page
    switch ($page) {
        case 'aspirasi':
            $konten = "aspirasi.php";
            break;
        case 'input':
            $konten = "input.php";
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