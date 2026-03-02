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
        height: 40vh;
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
        font-size: 13px;
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
            <th>Aksi</th>
        </tr>
        <?php
        // Query untuk mengambil data aspirasi dengan join ke tabel lain
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

        // Cek apakah ada data yang ditemukan
        if ($sql->num_rows > 0) {
            $no = 1;
            // Looping untuk menampilkan semua data
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
                echo "<td>";

                // CEK STATUS: Jika status SELESAI, button edit HILANG
                if ($row['status'] == 'selesai') {
                    // Tampilkan teks atau icon bahwa sudah selesai
                    echo "<span style='color: green; font-weight: bold;'>✓ Selesai</span>";
                } else {
                    // Tampilkan button edit
                    echo "<a href='?page=edit_aspirasi&id=" . $row['id_pelaporan'] . "'>Edit</a>";
                }

                echo "</td>";
                echo "</tr>";
            }
        } else {
            // Tampilkan pesan jika tidak ada data
            echo "<tr><td colspan='10' style='text-align:center'>data belum ada!!</td></tr>";
        }
        ?>
    </table>
</body>

</html>