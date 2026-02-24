<?php 
try {
    $koneksi = new mysqli("localhost", "root", "", "pengaduan");
} catch (\Throwable $th) {
    echo "ERROR: " . $th->getMessage();
}
?>