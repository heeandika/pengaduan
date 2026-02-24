<?php 
// Ambil id dari url dan konversi ke integer untuk keamanan
$id = (int)$_GET['id'];

// Siapkan query delete dengan prepared statement
$stmt = $koneksi->prepare("DELETE FROM kategori WHERE id_kategori=?");
$stmt->bind_param("i", $id);

// Jalankan query delete
if ($stmt->execute()) {
    // Redirect ke halaman kategori jika berhasil
    header("Location: ?page=kategori");
    exit();
} else {
    // Tampilkan pesan error jika gagal
    echo "ERROR:". $stmt->error;
}
?>