<?php
// Ambil id dari url dan konversi ke integer untuk keamanan
$id = (int)$_GET['id'];

// Siapkan query delete dengan prepared statement
$stmt = $koneksi->prepare("DELETE FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);

// Jalankan query delete
if ($stmt->execute()) {
    // Redirect ke halaman siswa jika berhasil
    header("Location: ?page=siswa");
    exit();
} else {
    // Tampilkan pesan error jika gagal
    echo "ERROR:". $stmt->error;
}
?>