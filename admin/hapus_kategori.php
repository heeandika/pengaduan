<?php
if (isset($_GET['hapus_id'])) {
    // Ambil id dari url dan konversi ke integer untuk keamanan
    $id = (int)$_GET['id'];
    $hapus_id = $_GET['hapus_id'];

    $cek = $koneksi->query("SELECT id FROM inp_aspirasi AND aspirasi WHERE id = $hapus_id");

    if ($cek->num_rows > 0) {
        echo "<script>alert('ID Sedang Digunakan!!');window.location='?page=kategori';</script>";

    } else {
        $hapuslah = $koneksi->query("DELETE FROM kategori WHERE id_kategori=$hapus_id");

        if ($hapuslah) {
            echo "<script>alert('Data kategori berhasil dihapus!!');window.location='?page=kategori';</script>";
        } else {
            echo "<script>alert('Coba lagi  !!');window.location='?page=kategori';</script>";
            exit();

        }
    }

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
        echo "ERROR:" . $stmt->error;
    }
}
?>

