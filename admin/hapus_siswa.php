<?php
$id = (int)$_GET['id'];

$stmt = $koneksi->prepare("DELETE FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    header("Location: ?page=siswa");
    exit();
} else {
    echo "ERROR:". $stmt->error;
}
?>
