<?php 
$id = (int)$_GET['id'];

$stmt = $koneksi->prepare("DELETE FROM kategori WHERE id_kategori=?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: ?page=kategori");
    exit();
} else {
    echo "ERROR:". $stmt->error;
}
?>