<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>siswa</title>
</head>
<body>
    <h1>Kategori</h1>
    <table>
        <tr>
            <th>NO</th>
            <th>Kategori</th>
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
                echo "<a href='?page=hapus_siswa&id=" . $row['id_kategori'] . "'>hapus</a>";
                echo "</tr>";
            }
        }
        ?>

    </table>
</body>
</html>