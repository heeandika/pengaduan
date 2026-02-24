<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit aspirasi</title>
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
        padding: 8px;
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
// Cek apakah ada id yang dikirim via url
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ambil data aspirasi berdasarkan id
    $stmt = $koneksi->query("SELECT * FROM aspirasi WHERE id_pelaporan=$id");
}
?>

<body>
    <h1>Edit Aspirasi</h1>
    <form action="" method="post">
        <label for="status">Status:</label>
        <select name="status">
            <option value="MENUNGGU">MENUNGGU</option>
            <option value="DALAM PROSES">DALAM PROSES</option>
            <option value="SELESAI">SELESAI</option>
        </select>

        <label for="feedback">Feedback:</label>
        <textarea name="feedback"></textarea>

        <button type="submit" name="submit">Submit</button>
    </form>
    <?php
    // Cek apakah form sudah disubmit
    if (isset($_POST['submit'])) {
        // Ambil data dari form
        $status     = $_POST['status'];
        $feedback   = $_POST['feedback'];

        // Validasi: pastikan semua data tidak kosong
        if (empty($status) || empty($feedback)) {
            echo "semua data harus diisi!!";
        } else {
            // Gunakan prepared statement untuk mencegah sql injection
            $stmt = $koneksi->prepare("UPDATE aspirasi SET status=?, feedback=? WHERE id_pelaporan=?");
            $stmt->bind_param("ssi", $status, $feedback, $id); // "ssi" = string, string, integer
            $stmt->execute();

            // Cek apakah ada data yang terupdate
            if ($stmt->affected_rows > 0) {
                // Redirect ke halaman aspirasi jika berhasil
                header("Location: ?page=aspirasi");
                exit(); // Hentikan eksekusi setelah redirect
            } else {
                echo "gagal, coba lagi nanti!!";
            }
        }
    }
    ?>
</body>

</html>