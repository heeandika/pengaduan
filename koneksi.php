<?php 
try {
    $koneksi = new mysqli("localhost", "root", "", "pengaduan_sekolah");
} catch (\Throwable $th) {
    echo "ERROR: " . $th->getMessage();
}
?>