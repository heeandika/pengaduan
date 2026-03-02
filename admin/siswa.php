<?php
// =========== PROSES HAPUS (DI LUAR) ===========
if (isset($_GET['hapus_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];

    // CEK 1: Ambil data siswa
    $stmt1 = $koneksi->prepare("SELECT NIS, kelas FROM siswa WHERE id = ?");
    $stmt1->bind_param("i", $hapus_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows == 0) {
        echo "<script>alert('Data siswa tidak ditemukan!');window.location='?page=siswa';</script>";
        exit();
    }

    $data_siswa = $result1->fetch_assoc();
    $NIS_siswa = $data_siswa['NIS'];
    $kelas_siswa = $data_siswa['kelas'];

    // CEK 2: Apakah NIS dipakai di tabel inp_aspirasi?
    $stmt2 = $koneksi->prepare("SELECT id_pelaporan FROM inp_aspirasi WHERE NIS = ?");
    $stmt2->bind_param("i", $NIS_siswa);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) {
        $jumlah = $result2->num_rows;
        echo "<script>
                alert('Siswa dengan NIS $NIS_siswa (Kelas $kelas_siswa) TIDAK BISA dihapus!\\n\\n' +
                      'Siswa ini memiliki $jumlah data aspirasi.\\n' +
                      'Hapus atau pindahkan data aspirasi tersebut terlebih dahulu.');
                window.location='?page=siswa';
            </script>";
        exit();
    } else {
        // Hapus Siswa (aman)
        $stmt3 = $koneksi->prepare("DELETE FROM siswa WHERE id = ?");
        $stmt3->bind_param("i", $hapus_id);

        if ($stmt3->execute()) {
            echo "<script>
                    alert('Siswa dengan NIS $NIS_siswa (Kelas $kelas_siswa) berhasil dihapus!');
                    window.location='?page=siswa';
                </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus: " . addslashes($stmt3->error) . "');
                    window.location='?page=siswa';
                </script>";
        }
        exit();
    }
}

// =========== PROSES TAMBAH/EDIT ===========
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
        // Cek apakah NIS sudah ada (untuk insert)
        if (empty($id)) {
            $cek_nis = $koneksi->prepare("SELECT id FROM siswa WHERE NIS = ?");
            $cek_nis->bind_param("i", $NIS);
            $cek_nis->execute();
            $result_cek = $cek_nis->get_result();

            if ($result_cek->num_rows > 0) {
                $error = "NIS $NIS sudah terdaftar!";
            }
        }

        if (!isset($error)) {
            // Jika id tidak kosong = update, jika kosong = insert
            if (!empty($id)) {
                // Ubah data
                $stmt = $koneksi->prepare("UPDATE siswa SET NIS=?, kelas=? WHERE id=?");
                $stmt->bind_param("isi", $NIS, $kelas, $id);
            } else {
                // Tambah data
                $stmt = $koneksi->prepare("INSERT INTO siswa (NIS, kelas) VALUES (?, ?)");
                $stmt->bind_param("is", $NIS, $kelas);
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
}

// Ambil data untuk diedit (jika ada parameter id di url)
if (isset($_GET['id']) && !isset($_GET['hapus_id'])) {
    $id   = (int)$_GET['id'];
    $stmt = $koneksi->prepare("SELECT * FROM siswa WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $id_siswa   = $data['id'];
        $NIS        = $data['NIS'];
        $kelas      = $data['kelas'];
    } else {
        echo "<div class='error'>Data tidak ditemukan</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>siswa</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        h1 {
            color: #333333;
        }

        input {
            border-radius: 10px;
            border: none;
            padding: 3px 30px;
            font-size: 16px;
            margin-left: 2%;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 2%;
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

        .info-box {
            background: #4f4f4f;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
            color: white;
        }

        form {
            background: #4f4f4f;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: white;
        }
    </style>

</head>


<body>
    <h1>Manajemen Data Siswa</h1>


    <!-- Form Tambah/Ubah -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id_siswa ?>">

        <label for="NIS">NIS (Nomor Induk Siswa):</label>
        <input type="number" name="NIS" value="<?= $NIS ?>" required placeholder="Contoh: 12345">

        <label for="kelas">Kelas:</label>
        <input type="text" name="kelas" value="<?= $kelas ?>" required placeholder="Contoh: XII RPL 1">

        <button type="submit" name="submit">
            <?= !empty($id_siswa) ? "✏️ Ubah Data" : "➕ Tambah Data" ?>
        </button>

        <?php if (!empty($id_siswa)): ?>
            <a href="?page=siswa" style="color: #ff6b6b; margin-left: 10px;">Batal</a>
        <?php endif; ?>
    </form>

    <!-- Tampilkan pesan error jika ada -->
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Tabel Daftar Siswa -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Tampilkan semua data dari table siswa
        $sql = $koneksi->query("SELECT * FROM siswa ORDER BY NIS");
        if ($sql->num_rows > 0) {
            $no = 1;
            while ($row = $sql->fetch_assoc()) {
                // Cek apakah siswa ini punya aspirasi
                $cek_aspirasi = $koneksi->query("SELECT COUNT(*) as total FROM inp_aspirasi WHERE NIS = " . $row['NIS']);
                $total_aspirasi = $cek_aspirasi->fetch_assoc()['total'];

                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['NIS']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                echo "<td>";
                echo "<a href='?page=siswa&id=" . $row['id'] . "'>Edit</a> | ";

                if ($total_aspirasi > 0) {
                    // Jika punya aspirasi, link hapus disable dengan tooltip
                    echo "<span style='color: #666; cursor: not-allowed;' title='Tidak bisa dihapus karena memiliki $total_aspirasi data aspirasi'>Hapus</span>";
                } else {
                    // Jika tidak dipakai, tampilkan link hapus
                    echo "<a href='?page=siswa&hapus_id=" . $row['id'] . "' 
                          onclick='return confirm(\"Yakin ingin menghapus siswa " . $row['id'] . "?\")'>Hapus</a>";
                }

                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center; padding: 20px;'>Belum ada data siswa</td></tr>";
        }
        ?>
    </table>

    <!-- Info Box -->
    <div class="info-box">
        <strong>ℹ️ Informasi:</strong>
        <ul style="margin-top: 5px; margin-left: 20px;">
            <li>Siswa yang memiliki data aspirasi TIDAK BISA dihapus</li>
            <li>Hapus atau pindahkan aspirasi siswa terlebih dahulu sebelum menghapus data siswa</li>
        </ul>
    </div>
</body>

</html>