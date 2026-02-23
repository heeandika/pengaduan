<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>input aspirasi</title>
</head>
<style>
    label{
        display: block;
    }

    h1{
        padding-bottom: 20px;
    }
</style>
<?php 
if (isset($_POST['submit'])) {
    $NIS = $_POST['NIS'];
    $ket_kategori = $_POST['ket_kategori'];
    $lokasi = $_POST['lokasi'];
    $ket = $_POST['ket'];
    $status = "menunggu";
    $feedbech = "";
    $waktu = "Y-m-d H:i:s";

    if (isset($_POST['NIS'])) {
        $stmt = $koneksi->prepare("SELECT * FROM siswa ($NIS, $kelas) VALUES (?, ?");
        $stmt->bind_param("is", $NIS, $kelas);
        if ($stmt->execute()) {
            echo "NIS sudah terdaftar";
        } else {
            echo "NIS belum terdaftar!!";
        }
    }

    
}
 ?>
<body>
    <h1>Input aspirasi</h1>
    <form action="" method="post">
        <label for="NIS">NIS:</label>
        <input type="number" name="NIS" required>

        <label for="ket_kategori">Kategori</label>
        <select name="ket_kategori">
            <option>-- pilih kategori --</option>
            <?php 
            // $sql = $koneksi->query("SELECT * FROM kategori WHERE id_kategori = $id");
            // if ($sql->num_rows > 0) {
            //     while ($hasil = $sql->fetch_assoc()) {
            //         echo "<option value='". $hasil['id_kategori'] . "'>". $hasil['ket_kategori'] . "</option>";
            //         exit;
            //     } 
            // }  
             ?>
        </select>

        <label for="lokasi">Lokasi:</label>
        <input type="text" name="lokasi" required>

        <label for="ket">Keterangan</label>
        <textarea name="ket"></textarea>

        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>