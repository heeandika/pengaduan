<?php
include "../koneksi.php";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
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
            $konten = "404.php";
            break;
    } if ($konten === "404.php") {
        include "404.php";
    } else {
        include "kerangka.php";
    }
} else {
    include "404.php";
}