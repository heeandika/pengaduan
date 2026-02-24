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

    h1 {
        color: #ffffff;
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
    }

    textarea {
        height: 80px;
    }
    input,
    select,
    textarea {
        width: 100%;
        height: 50px;
        margin: 10px 0;
        border-radius: 8px;
    }
</style>
    <?php
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $koneksi->query("SELECT * FROM aspirasi WHERE id_aspirasi=$id");
      }
    ?>
<body>
    <h1>Edit Aspirasi</h1>
    <form action="" method="post">
        <label for="status">Status:</label>
        <select name="status">
            <option value="menunggu">Menunggu</option>
            <option value="proses">Diproses</option>
            <option value="selesai">Selesai</option>
        </select>

        <label for="feedback">Feedback:</label>
        <textarea name="feedback"></textarea>

        <button type="submit" name="submit">Submit</button>
    </form>
    <?php
      if (isset($_POST['submit'])) {
        $status     = $_POST['status'];
        $feedback   = $_POST['feedback']; 

        if (empty($status) || empty($feedback)) {
            echo "semua data harus diisi!!";
        } else {
            $stmt = $koneksi->prepare("UPDATE aspirasi SET status=?, feedback=? WHERE id_pelaporan=?");
            $stmt->bind_param("ssi", $status, $feedback, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: ?page=aspirasi");
            } else {
                echo "gagal, coba lagi nanti!!";
            }
        }
      }
    ?>
</body>
</html>