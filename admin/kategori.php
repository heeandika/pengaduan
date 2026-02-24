<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kategori</title>
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    h1 {
        color: #333333;
    }

    form {
        background: #4f4f4f;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        color: white;
    }

    input {
        border-radius: 10px;
        border: none;
        padding: 3px 30px;
        font-size: 16px;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    h1 {
        color: #ffffff;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        height: 40vh;
    }

    th {
        background-color: #4f4f4f;
        color: white;
        padding: 10px;
        text-align: left;
        font-size: 17px;
    }

    td {
        padding: 8px 10px;
        font-size: 20px;
        color: yellow;
    }

    tr:hover,
    a:hover {
        background-color: #363636;
        color: black;
    }

    a {
        text-decoration: none;
        color: red;
    }
</style>

<body>
    <h1>kategori</h1>
    <?php
    // Inisialisasi variabel
    $id_kategori    = "";
    $ket_kategori   = "";

    // Proses submit form (tambah/edit)
    if (isset($_POST['submit'])) {

        // Ambil data dari form
        $id             = $_POST['id'] ?? "";
        $ket_kategori   = $_POST['ket_kategori'];

        // Validasi input tidak boleh kosong
        if (empty($ket_kategori)) {
            $error = "Semua data harus diisi";
        } else {
            // Jika id tidak kosong = update, jika kosong = insert
            if (!empty($id)) {
                // Ubah data
                $stmt = $koneksi->prepare("UPDATE kategori SET ket_kategori=? WHERE id_kategori=?");
                $stmt->bind_param("si", $ket_kategori, $id);
            } else {
                // Tambah data
                $stmt = $koneksi->prepare("INSERT INTO kategori (ket_kategori) VALUES (?)");
                $stmt->bind_param("s", $ket_kategori);
            }

            // Eksekusi query
            if ($stmt->execute()) {
                header("Location: ?page=kategori");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    }

    // Ambil data untuk diedit (jika ada id di url)
    if (isset($_GET['id'])) {
        $id   = (int)$_GET['id'];
        $stmt = $koneksi->prepare("SELECT * FROM kategori WHERE id_kategori=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Cek apakah data ditemukan
        if ($result->num_rows == 0) {
            exit("Data tidak ditemukan");
        }

        $data = $result->fetch_assoc();
        $id_kategori    = $data['id_kategori'];
        $ket_kategori   = $data['ket_kategori'];
    }
    ?>

    <!-- Form tambah/ubah -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id_kategori ?>">
        <label for="ket_kategori">Kategori:</label>
        <input type="text" name="ket_kategori" value="<?= $ket_kategori ?>">
        <button type="submit" name="submit">
            <?= !empty($id_kategori) ? "Ubah" : "Tambah" ?>
        </button>
    </form>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Tampilkan semua data dari table kategori
        $sql = $koneksi->query("SELECT * FROM kategori");
        if ($sql->num_rows > 0) {
            $no = 1;
            while ($row = $sql->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['ket_kategori']) . "</td>";
                echo "<td>
                <a href='?page=kategori&id=" . $row['id_kategori'] . "'>Edit</a> |
                <a href='?page=hapus_kategori&id=" . $row['id_kategori'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
            </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3' style='text-align:center'>Belum ada data kategori</td></tr>";
        }
        ?>
    </table>
</body>

</html>