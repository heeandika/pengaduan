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
    $id_siswa   = "";
    $NIS        = "";
    $kelas      = "";

    if (isset($_POST['submit'])) {

        $id     = $_POST['id'] ?? "";
        $NIS    = $_POST['NIS'];
        $kelas  = $_POST['kelas'];

        if (empty($NIS) || empty($kelas)) {
            $error = "Semua data harus diisi";
        } else {

            if (!empty($id)) {
                $stmt = $koneksi->prepare("UPDATE siswa SET NIS=?, kelas=? WHERE id=?");
                $stmt->bind_param("isi", $NIS, $kelas, $id);
            } else {
                $stmt = $koneksi->prepare("INSERT INTO siswa (NIS, kelas) VALUES (?, ?)");
                $stmt->bind_param("is", $NIS, $kelas);
            }
        }
        if ($stmt->execute()) {
            header("Location: ?page=siswa");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    }

    if (isset($_GET['id'])) {
        $id   = (int)$_GET['id'] ?? "";
        $stmt = $koneksi->prepare("SELECT * FROM siswa WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            exit("data kosong");
        }
        $data = $result->fetch_assoc();

        $id_siswa   = $data['id'];
        $NIS        = $data['NIS'];
        $kelas      = $data['kelas'];
    }

    ?>
    <form action="" method="post">

        <input type="hidden" name="id" value="<?= $id_siswa ?>">

        <label for="NIS">NIS:</label>
        <input type="number" name="NIS" value="<?= $NIS ?>">

        <label for="kelas">Kelas:</label>
        <input type="text" name="kelas" value="<?= $kelas ?>">

        <button type="submit" name="submit">

            <?= !empty($id_siswa) ? "Ubah" : "Tambah" ?>
            
        </button>

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
                echo "<td>
                <a href='?page=siswa&id="         . $row['id'] . "'>Edit </a>
                <a href='?page=hapus_siswa&id="   . $row['id'] . "'onclick='return confirm(\"yakin?\")'>hapus</a>
                </td>";
                echo "</tr>";
            }
        }
        ?>

    </table>
</body>

</html>