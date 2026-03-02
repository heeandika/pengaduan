<?php
// =========== SEMUA PROSES PHP DI ATAS ===========
// Tidak boleh ada HTML/echo sebelum ini!

// =========== PROSES HAPUS ===========
if (isset($_GET['hapus_id'])) {
    $hapus_id = (int)$_GET['hapus_id'];

    // CEK 1: Ambil data kategori
    $stmt1 = $koneksi->prepare("SELECT ket_kategori FROM kategori WHERE id_kategori = ?");
    $stmt1->bind_param("i", $hapus_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows == 0) {
        echo "<script>alert('ID Kategori tidak ditemukan!');window.location='?page=kategori';</script>";
        exit();
    }

    $data_kategori = $result1->fetch_assoc();
    $nama_kategori = $data_kategori['ket_kategori'];

    // CEK 2: Apakah kategori dipakai di inp_aspirasi?
    $stmt2 = $koneksi->prepare("SELECT id_pelaporan FROM inp_aspirasi WHERE id_kategori = ?");
    $stmt2->bind_param("i", $hapus_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) {
        $jumlah = $result2->num_rows;
        echo "<script>
            alert('Kategori \"$nama_kategori\" tidak bisa dihapus!\\nDigunakan di $jumlah data aspirasi.');
            window.location='?page=kategori';
        </script>";
        exit();
    } else {
        // Hapus kategori
        $stmt3 = $koneksi->prepare("DELETE FROM kategori WHERE id_kategori = ?");
        $stmt3->bind_param("i", $hapus_id);

        if ($stmt3->execute()) {
            echo "<script>
                alert('Kategori \"$nama_kategori\" berhasil dihapus!');
                window.location='?page=kategori';
            </script>";
        } else {
            echo "<script>
                alert('Gagal menghapus: " . addslashes($stmt3->error) . "');
                window.location='?page=kategori';
            </script>";
        }
        exit();
    }
}

// =========== PROSES TAMBAH/EDIT ===========
// Inisialisasi variabel
$id_kategori = "";
$ket_kategori = "";

// Proses submit form (tambah/edit)
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $id = $_POST['id'] ?? "";
    $ket_kategori = $_POST['ket_kategori'];

    // Validasi input tidak boleh kosong
    if (empty($ket_kategori)) {
        $error = "Semua data harus diisi";
    } else {
        // Cek apakah nama kategori sudah ada (untuk insert)
        if (empty($id)) {
            $cek_kategori = $koneksi->prepare("SELECT id_kategori FROM kategori WHERE ket_kategori = ?");
            $cek_kategori->bind_param("s", $ket_kategori);
            $cek_kategori->execute();
            $result_cek = $cek_kategori->get_result();

            if ($result_cek->num_rows > 0) {
                $error = "Kategori '$ket_kategori' sudah terdaftar!";
            }
        }

        if (!isset($error)) {
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
}

// Ambil data untuk diedit (jika ada id di url)
if (isset($_GET['id']) && !isset($_GET['hapus_id'])) {
    $id = (int)$_GET['id'];
    $stmt = $koneksi->prepare("SELECT * FROM kategori WHERE id_kategori=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah data ditemukan
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $id_kategori = $data['id_kategori'];
        $ket_kategori = $data['ket_kategori'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

// =========== HTML MULAI DARI SINI ===========
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
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
    <h1>Manajemen Kategori</h1>

    <!-- Form tambah/ubah -->
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id_kategori ?>">
        <label for="ket_kategori">Nama Kategori:</label>
        <input type="text" name="ket_kategori" value="<?= htmlspecialchars($ket_kategori) ?>" 
               placeholder="Contoh: Sekolah" required>
        <button type="submit" name="submit">
            <?= !empty($id_kategori) ? "✏️ Ubah Kategori" : "➕ Tambah Kategori" ?>
        </button>
        <?php if (!empty($id_kategori)): ?>
            <a href="?page=kategori" style="color: #ff6b6b; margin-left: 10px;">Batal</a>
        <?php endif; ?>
    </form>

    <!-- Tampilkan pesan error jika ada -->
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <!-- Tabel Daftar Kategori -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php
        // Tampilkan semua data dari table kategori
        $sql = $koneksi->query("SELECT * FROM kategori ORDER BY ket_kategori");
        if ($sql->num_rows > 0) {
            $no = 1;
            while ($row = $sql->fetch_assoc()) {
                // Cek apakah kategori ini dipakai di inp_aspirasi
                $cek_pakai = $koneksi->query("SELECT COUNT(*) as total FROM inp_aspirasi WHERE id_kategori = " . $row['id_kategori']);
                $total_pakai = $cek_pakai->fetch_assoc()['total'];

                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['ket_kategori']) . "</td>";
                echo "<td>";
                echo "<a href='?page=kategori&id=" . $row['id_kategori'] . "'>Edit</a> | ";

                if ($total_pakai > 0) {
                    // Jika dipakai, link hapus disable
                    echo "<span style='color: #666; cursor: not-allowed;' 
                          title='Tidak bisa dihapus karena digunakan di $total_pakai data aspirasi'>Hapus</span>";
                } else {
                    // Jika tidak dipakai, tampilkan link hapus
                    echo "<a href='?page=kategori&hapus_id=" . $row['id_kategori'] . "' 
                          onclick='return confirm(\"Yakin ingin menghapus kategori " . $row['ket_kategori'] . "?\")'>Hapus</a>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3' style='text-align:center; padding: 20px;'>Belum ada data kategori</td></tr>";
        }
        ?>
    </table>

    <!-- Info Box -->
    <div class="info-box">
        <strong>ℹ️ Informasi:</strong>
        <ul style="margin-top: 5px; margin-left: 20px;">
            <li>Kategori yang sudah digunakan di data aspirasi TIDAK BISA dihapus</li>
            <li>Hapus atau pindahkan aspirasi terlebih dahulu sebelum menghapus kategori</li>
            <li>Gunakan fitur Edit untuk mengubah nama kategori</li>
        </ul>
    </div>
</body>

</html>