<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>input aspirasi</title>
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    h2 {
        color: yellow;
    }
    label{
        display: block;
        text-decoration: underline #ffeb38;
        font-size: 25px;
    }

    form {
        padding: 20px;
        margin-bottom: 20px;
        color: white;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        box-shadow: 5px 6px #8fc5ff;

    }

    textarea {
        height: 90px;
        width: 100%;
        margin: 10px 0;
    }
    input,
    select {
        width: 100%;
        height: 50px;
        margin: 10px 0;
        border-radius: 8px;
        border: none;
    }
</style>
<?php
if (isset($_POST['submit'])) {
    $NIS = $_POST['NIS'];
    $id_kategori = $_POST['id_kategori']?? "";
    $ket_kategori = $_POST['ket_kategori'];
    $lokasi = $_POST['lokasi'];
    $ket = $_POST['ket'];
    $status = "panding";
    $feedback = "";
    $waktu = date("Y-m-d H:i:s");

    $result = $koneksi->query("SELECT * FROM siswa WHERE NIS=$NIS");
    if ($result->num_rows > 0) {
        echo "NIS sudah ada!!";
    } else {
        echo "NIS belum ada!!";
        exit();
    }

    $stmt = $koneksi->prepare("INSERT INTO inp_aspirasi (NIS, id_kategori, lokasi, ket) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $NIS, $id_kategori, $lokasi, $ket);
    
    if ($stmt->execute()) {
        var_dump($stmt->insert_id);
        $id = $stmt->insert_id;
        $stmt1 = $koneksi->prepare("INSERT INTO aspirasi (id_pelaporan, status, tanggal, feedback, id_kategori) VALUES (?, ?, ?, ?, ?)");
        $stmt1->bind_param("isssi", $id, $status, $tanggal, $waktu, $id_kategori);
        if ($stmt1->execute()) {
            header("Location: ?page=aspirasi");
        } else {
            echo "Error: " . $stmt1->error;
        }
    }
}
?>

<body>
    <h2>Input aspirasi</h2>
    <form action="" method="post">
        <label for="NIS">NIS:</label>
        <input type="number" name="NIS" required>

        <label for="ket_kategori">Kategori</label>
        <select name="id_kategori">
            <option>-- pilih kategori --</option>
            <?php
            $result = $koneksi->query("SELECT * FROM kategori ORDER BY ket_kategori");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='$row[id_kategori]'>$row[ket_kategori]</option>";
                }
            } else {
                echo "Kategori tidak tersedia";
            }
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