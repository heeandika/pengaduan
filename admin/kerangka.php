<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kerangka admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        
        }

        body {
            background-color: #1D1D1D;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #424242;
            padding: 20px 0;
        }

        .sidebar h1 {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid #000000;
            margin-bottom: 15px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu a {
            padding: 12px 20px;
            text-decoration: none;
            color: #ffffff;
            font-size: 15px;
            border-left: 3px solid transparent;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .card {
            background: #848484;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h1>Panel Admin</h1>
            <div class="sidebar-menu">
                <a href="?page=aspirasi">Aspirasi</a>
                <a href="?page=siswa">Siswa</a>
                <a href="?page=kategori">Kategori</a>
                <a href="../auth/login.php" style="color: #dc3545;">Keluar</a>
            </div>
        </div>

        <div class="main-content">
            <div class="card">
                <?php include $konten ?>
            </div>
        </div>
    </div>
</body>
</html>