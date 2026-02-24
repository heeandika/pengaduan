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

    label {
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
        padding: 20px 25px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        box-shadow: 5px 6px #8fc5ff;
        font-size: 15px;

    }

    textarea {
        height: 90px;
        width: 100%;
        margin: 10px 0;
        padding: 10PX;
    }

    input,
    select {
        width: 100%;
        height: 50px;
        margin: 10px 0;
        border-radius: 8px;
        border: none;
        font-size: 20px;
    }

    select {
        padding-left: 40%;
        font-size: 30px;
        display: flex;
        justify-content: center;
    }
</style>
<?php
// Proses submit form input aspirasi
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $NIS = $_POST['NIS'];
    $id_kategori = $_POST['id_kategori'] ?? "";
    $lokasi = $_POST['lokasi'];
    $ket = $_POST['ket'];
    $status = "pending"; // Status default
    $feedback = ""; // Feedback kosong di awal
    $waktu = date("Y-m-d H:i:s"); // Waktu sekarang

    // Cek apakah NIS terdaftar di tabel siswa
    $result = $koneksi->query("SELECT * FROM siswa WHERE NIS=$NIS");
    if ($result->num_rows > 0) {
        echo "NIS sudah ada!!";
    } else {
        echo "NIS belum ada!!";
        exit();
    }

    // Insert ke tabel inp_aspirasi
    $stmt = $koneksi->prepare("INSERT INTO inp_aspirasi (NIS, id_kategori, lokasi, ket) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $NIS, $id_kategori, $lokasi, $ket);

    if ($stmt->execute()) {
        // Ambil id_pelaporan yang baru saja diinsert
        $id = $stmt->insert_id;
        
        // Insert ke tabel aspirasi
        $stmt1 = $koneksi->prepare("INSERT INTO aspirasi (id_pelaporan, status, tanggal, feedback, id_kategori) VALUES (?, ?, ?, ?, ?)");
        $stmt1->bind_param("isssi", $id, $status, $waktu, $feedback, $id_kategori);
        
        if ($stmt1->execute()) {
            // Redirect ke halaman aspirasi jika berhasil
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

        <label for="id_kategori">Kategori</label>
        <select name="id_kategori">
            <option>---- pilih kategori ----</option>
<?php
            // Ambil data kategori dari database
            $result = $koneksi->query("SELECT * FROM kategori ORDER BY ket_kategori");
            if ($result->num_rows > 0) {
                // Tampilkan semua kategori sebagai option
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