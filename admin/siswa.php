<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>siswa</title>
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    label {
        padding: 10%;

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
        margin-left: 80px;
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
    <h1>Siswa</h1>
    <?php
    // Inisialisasi variabel form
    $id_siswa   = "";
    $NIS        = "";
    $kelas      = "";

    // Proses submit form (tambah/edit)
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $id     = $_POST['id'] ?? "";
        $NIS    = $_POST['NIS'];
        $kelas  = $_POST['kelas'];

        // Validasi input tidak boleh kosong
        if (empty($NIS) || empty($kelas)) {
            $error = "Semua data harus diisi";
        } else {
            // Jika id tidak kosong = update, jika kosong = insert
            if (!empty($id)) {
                // ubah data
                $stmt = $koneksi->prepare("UPDATE siswa SET NIS=?, kelas=? WHERE id=?");
                $stmt->bind_param("isi", $NIS, $kelas, $id); // i=integer, s=string, i=integer
            } else {
                // tambah data
                $stmt = $koneksi->prepare("INSERT INTO siswa (NIS, kelas) VALUES (?, ?)");
                $stmt->bind_param("is", $NIS, $kelas); // i=integer, s=string
            }

            // Eksekusi query
            if ($stmt->execute()) {
                header("Location: ?page=siswa");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
    }

    // Ambil data untuk diedit (jika ada parameter id di url)
    if (isset($_GET['id'])) {
        $id   = (int)$_GET['id'];
        $stmt = $koneksi->prepare("SELECT * FROM siswa WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Cek apakah data ditemukan
        if ($result->num_rows == 0) {
            exit("Data tidak ditemukan");
        }

        $data = $result->fetch_assoc();
        $id_siswa   = $data['id'];
        $NIS        = $data['NIS'];
        $kelas      = $data['kelas'];
    }

        if (isset($_GET['hapus_id'])) {
        // Ambil id dari url dan konversi ke integer untuk keamanan
        $hapus_id = $_GET['hapus_id'];

        $cek = $koneksi->query("SELECT id_pelaporan FROM inp_aspirasi WHERE id_pelaporan = $hapus_id");

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
    }

    ?>
<!-- form Tambah/Ubah -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id_siswa ?>">

        <label for="NIS">NIS:</label>
        <input type="number" name="NIS" value="<?= $NIS ?>" required>

        <label for="kelas">Kelas:</label>
        <input type="text" name="kelas" value="<?= $kelas ?>" required>

        <button type="submit" name="submit">
            <?= !empty($id_siswa) ? "Ubah" : "Tambah" ?>
        </button>
    </form>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Tampilkan semua data dari table siswa
        $sql = $koneksi->query("SELECT * FROM siswa");
        if ($sql->num_rows > 0) {
            $no = 1;
            while ($row = $sql->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['NIS']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                echo "<td>
                <a href='?page=siswa&id=" . $row['id'] . "'>Edit</a> |
                <a href='?page=hapus_siswa&id=" . $row['id'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
            </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center'>Belum ada data siswa</td></tr>";
        }
        ?>
    </table>

</body>

</html>