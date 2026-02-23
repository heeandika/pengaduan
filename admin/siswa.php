<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>siswa</title>
</head>
<body>
    <h1>Siswa</h1>
    <?php
    $id_siswa = "";
    $NIS = "";
    $kelas = "";

    if (isset($_POST['submit'])) {
        $NIS = $_POST['NIS'];
        $kelas = $_POST['kelas'];
        if (empty($NIS) || empty($kelas)) {
            $error = "harap isi semua data";
            }if (!empty($id_siswa)) {
            $id_siswa = $_POST['id_siswa'];
            // $query = "UPDATE siswa SET NIS=$NIS, kelas=$kelas WHERE id_siswa=$id_siswa";
            $x = $koneksi->query("UPDATE siswa SET NIS=$NIS, kelas=$kelas WHERE id_siswa=$id_siswa");
            if ($x) {
                header("Location: ?page=siswa");
            }
        } else {
            $y = $koneksi->query("INSERT INTO siswa (NIS, kelas) VALUES($NIS, $kelas)");
            if ($y) {
                header("Location: ?page=siswa");

            }
            
        } 
        
        if (isset($_GET['id'])) {
            $id =(int)$_GET['id'];


        }
    }
    ?>
    <form action="" method="post">
        <label for="NIS">NIS:</label>
        <input type="number" name="NIS" required>

        <label for="kelas">Kelas:</label>
        <input type="text" name="kelas" required>

        <button type="submit" name="submit">submit</button>
    </form>
    <table border="1" cellpaddong="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = $koneksi->query("SELECT * FROM siswa");
        if ($sql->num_rows > 0) {
            $no = 1;
            while ($row = $sql->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['NIS'] . "</td>";
                echo "<td>" . $row['kelas'] . "</td>";
                echo "<td>";
                echo "<a href='?page=siswa&id=" . $row['id_siswa'] . "'>Edit </a>";
                echo "<a href='?page=hapus_siswa&id=" . $row['NIS'] . "'>hapus </a>";
                echo "</td>";
                echo "</tr>";
            }
        }
        ?>

    </table>
</body>
</html>