<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kategori</title>
</head>

<body>
    <h1>kategori</h1>
    <?php
    $id_kategori    = "";
    $ket_kategori   = "";

    if (isset($_POST['submit'])) {

        $id             = $_POST['id'] ?? "";;
        $ket_kategori   = $_POST['ket_kategori'];

        if (empty($ket_kategori)) {
            $error = "Semua data harus diisi";
        } else {

            if (!empty($id)) {
                $stmt = $koneksi->prepare("UPDATE kategori SET ket_kategori=? WHERE id_kategori=?");
                $stmt->bind_param("si", $ket_kategori, $id);
            } else {
                $stmt = $koneksi->prepare("INSERT INTO kategori (ket_kategori) VALUES (?)");
                $stmt->bind_param("s", $ket_kategori);
            }
        }
        if (!$stmt->execute()) {
            header("Location: ?page=kategori");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    }

    if (isset($_GET['id'])) {
        $id   = (int)$_GET['id'] ?? "";
        $stmt = $koneksi->prepare("SELECT * FROM kategori WHERE id_kategori=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            exit("data kosong");
        }
        $data = $result->fetch_assoc();

        $id_kategori    = $data['id_kategori'];
        $ket_kategori   = $data['ket_kategori'];
    }

    ?>
    <form action="" method="post">

        <input type="hidden" name="id" value="<?= $id_kategori ?>">

        <label for="ket_kategori">Kategori:</label>
        <input type="text" name="ket_kategori" value="<?= $ket_kategori ?>">

        <button type="submit" name="submit">

            <?= !empty($id_kategori) ? "Ubah" : "Tambah" ?>
            
        </button>

    </form>
    <table border="1" cellpaddong="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>kategori</th>
            <th>Aksi</th>
        </tr>
        <?php
        $sql = $koneksi->query("SELECT * FROM kategori");
        if ($sql->num_rows > 0) {
            $no = 1;
            while ($row = $sql->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['ket_kategori'] . "</td>";
                echo "<td>
                <a href='?page=kategori&id="         . $row['id_kategori'] . "'>Edit </a>
                <a href='?page=hapus_kategori&id="   . $row['id_kategori'] . "'onclick='return confirm(\"yakin?\")'>hapus</a>
                </td>";
                echo "</tr>";
            }
        }
        ?>

    </table>
</body>

</html>