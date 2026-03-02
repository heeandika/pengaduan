    <?php
    // VARIABEL UNTUK MENYIMPAN DATA
    $id = 0;
    $current_status = "";
    $current_feedback = "";
    $nis = "";
    $kategori = "";
    $lokasi = "";
    $keterangan = "";

    // CEK APAKAH ADA ID YANG DIKIRIM VIA URL
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id']; // Konversi ke integer untuk keamanan

        // AMBIL DATA ASPIRASI DENGAN JOIN (prepared statement)
        $stmt = $koneksi->prepare("
            SELECT 
                aspirasi.*,
                inp_aspirasi.NIS,
                inp_aspirasi.lokasi,
                inp_aspirasi.ket as keterangan,
                kategori.ket_kategori
            FROM aspirasi 
            LEFT JOIN inp_aspirasi ON aspirasi.id_pelaporan = inp_aspirasi.id_pelaporan
            LEFT JOIN kategori ON aspirasi.id_kategori = kategori.id_kategori
            WHERE aspirasi.id_pelaporan = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // CEK APAKAH DATA DITEMUKAN
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $current_status = $data['status'];
            $current_feedback = $data['feedback'];
            $nis = $data['NIS'];
            $kategori = $data['ket_kategori'];
            $lokasi = $data['lokasi'];
            $keterangan = $data['keterangan'];
        } else {
            echo "<div class='error'>Data tidak ditemukan!</div>";
            echo "<a href='?page=aspirasi'>Kembali ke halaman aspirasi</a>";
            exit();
        }
    } else {
        echo "<div class='error'>ID tidak ditemukan!</div>";
        echo "<a href='?page=aspirasi'>Kembali ke halaman aspirasi</a>";
        exit();
    }

    // PROSES UPDATE DATA
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $status     = $_POST['status'];
        $feedback   = $_POST['feedback'];

        // Validasi: pastikan semua data tidak kosong
        if (empty($status) || empty($feedback)) {
            echo "<div class='error'>Semua data harus diisi!!</div>";
        } else {
            // Gunakan prepared statement untuk mencegah sql injection
            $stmt = $koneksi->prepare("UPDATE aspirasi SET status=?, feedback=? WHERE id_pelaporan=?");
            $stmt->bind_param("ssi", $status, $feedback, $id); // "ssi" = string, string, integer

            if ($stmt->execute()) {
                // Cek apakah ada data yang terupdate
                if ($stmt->affected_rows > 0) {
                    // Redirect ke halaman aspirasi jika berhasil
                    header("Location: ?page=aspirasi");
                    exit(); // Hentikan eksekusi setelah redirect
                } else {
                    echo "<div class='error'>Tidak ada perubahan data!</div>";
                }
            } else {
                echo "<div class='error'>Error: " . $stmt->error . "</div>";
            }
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aspirasi</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #333;
            padding: 20px;
        }

        h1 {
            color: #ffffff;
            margin-bottom: 20px;
        }

        h2 {
            color: yellow;
        }

        label {
            display: block;
            text-decoration: underline #ffeb38;
            font-size: 25px;
            color: white;
            margin-top: 20px;
        }

        form {
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            background: #4f4f4f;
            border-radius: 5px;
        }

        .button_update {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 5px 6px #8fc5ff;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
        }

        .button_update:hover {
            background-color: #0056b3;
        }

        .button_delete {
            background-color: #b70000;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 5px 6px #420000;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
        }

        .button_delete:hover {
            background-color: #7a0000;
        }

        textarea {
            height: 90px;
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #666;
            background-color: #333;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
        }

        input,
        select {
            width: 100%;
            height: 50px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #666;
            background-color: #333;
            color: white;
            font-size: 16px;
            padding: 0 10px;
            box-sizing: border-box;
        }

        select {
            font-size: 16px;
            padding: 0 10px;
        }

        select option {
            background-color: #4f4f4f;
            color: white;
        }

        .error {
            color: #ff6b6b;
            background: #4f4f4f;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }

        .info {
            background: #4f4f4f;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }

        .info p {
            margin: 5px 0;
            color: white;
        }

        .info span {
            color: yellow;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Edit Aspirasi</h1>


    <!-- TAMPILAN FORM DENGAN DATA LAMA -->
    <form action="" method="post">
        <!-- INFO ASPIRASI -->
        <div class="info">
            <h3 style="color: white; margin-top: 0;">Informasi Aspirasi:</h3>
            <p><span>NIS:</span> <?= htmlspecialchars($nis) ?></p>
            <p><span>Kategori:</span> <?= htmlspecialchars($kategori) ?></p>
            <p><span>Lokasi:</span> <?= htmlspecialchars($lokasi) ?></p>
            <p><span>Keterangan:</span> <?= htmlspecialchars($keterangan) ?></p>
        </div>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="panding" <?= ($current_status == 'panding') ? 'selected' : '' ?>>MENUNGGU</option>
            <option value="diproses" <?= ($current_status == 'DALAM PROSES') ? 'selected' : '' ?>>DALAM PROSES</option>
            <option value="selesai" <?= ($current_status == 'selesai') ? 'selected' : '' ?>>SELESAI</option>
        </select>

        <label for="feedback">Feedback:</label>
        <textarea name="feedback" placeholder="Masukkan feedback..." required><?= htmlspecialchars($current_feedback) ?></textarea>

        <button type="submit" name="submit" class="button_update">Update Aspirasi</button>
        <a href="?page=aspirasi" style="color: #ff6b6b; margin-left: 10px;" class="button_delete">Batal</a>
    </form>

    <?php if ($current_status == 'SELESAI'): ?>
        <div class="info" style="border-left-color: #28a745;">
            <p style="color: #28a745;">ⓘ Aspirasi ini sudah SELESAI. Anda tetap bisa mengubah feedback jika diperlukan.</p>
        </div>
    <?php endif; ?>
</body>

</html>