<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>aspirasi</title>
</head>
<style>
    
</style>
<h1>aspirasi</h1>
<body>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>Kelas</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Feedbeck</th>
            <th>Waktu</th>
            <th>Edit</th>
        </tr>
        <?php 
        $sql = $koneksi->query("SELECT
        input_aspirasi.*,
        siswa.kelas,
        kategori.ket_kategori,
        aspirasi.status,
        aspirasi.feedbeck,
        aspirasi.waktu
        FROM input_aspirasi
        LEFT JOIN siswa ON input_aspirasi.NIS = siswa.NIS
        LEFT JOIN kategori ON input_aspirasi.id_kategori = kategori.id_kategori
        LEFT JOIN aspirasi ON input_aspirasi.id_pelaporan = aspirasi.id_aspirasi
        ");

        if ($sql->num_rows > 0) {
            $no = 1;
            while ($row = $sql->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['NIS'] . "</td>";
                echo "<td>" . $row['kelas'] . "</td>";
                echo "<td>" . $row['ket_kategori'] . "</td>";
                echo "<td>" . $row['lokasi'] . "</td>";
                echo "<td>" . $row['ket'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['feedbeck'] . "</td>";
                echo "<td>" . $row['waktu'] . "</td>";
                echo "<a href = '?page=edit_aspirasi&id=" . $row['id_pelaporan'] . "'>Edit</a>";
                echo "</td>";
            }
        } else {
            echo "data belum ada!!";
        }
         ?>
         <a href=></a>
    </table>
</body>
</html>