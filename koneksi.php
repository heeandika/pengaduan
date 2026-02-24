<?php 
// Koneksi ke database menggunakan mysqli
try {
    $koneksi = new mysqli("localhost", "root", "", "pengaduan");
} catch (\Throwable $th) {
    // Tampilkan pesan error jika koneksi gagal
    echo "ERROR: " . $th->getMessage();
}
?>