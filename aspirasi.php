<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>aspirasi</title>
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    h1 {
        color: #ffffff;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
    }

    th {
        background-color: #4f4f4f;
        color: white;
        padding: 10px;
        text-align: left;
        font-size: 14px;
    }

    td {
        padding: 8px 10px;
        font-size: 14px;
        color: yellow;
    }

    tr:hover {
        background-color: #363636;
        color: black;
    }
    a {
        text-decoration: none;
        color: red;
    }
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
        </tr>
        <?php
        $sql = $koneksi->query("SELECT
        inp_aspirasi.*,
        siswa.kelas,
        kategori.ket_kategori,
        aspirasi.status,
        aspirasi.feedback,
        aspirasi.tanggal
        FROM inp_aspirasi
        LEFT JOIN siswa ON inp_aspirasi.NIS = siswa.NIS
        LEFT JOIN kategori ON inp_aspirasi.id_kategori = kategori.id_kategori
        LEFT JOIN aspirasi ON inp_aspirasi.id_pelaporan = aspirasi.id_pelaporan
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
                echo "<td>" . $row['feedback'] . "</td>";
                echo "<td>" . $row['tanggal'] . "</td>";
                echo "</td>";
            }
        } else {
            echo "data belum ada!!";
        }
        ?>
    </table>
</body>
</html>