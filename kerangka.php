<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerangka siswa</title>
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

        .navbar {
            background-color: #424242;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        h1{
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
            text-decoration: none;
        }

        .navbar-menu{
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar-menu a{
            text-decoration: none;
            color: #f7f7f7;
            font-size: 16px;
            padding: 8px 12px;
            transition: all 0.3s ease;
            border-radius: 4px;
        }
        .card{
            background-color: #424242;
            border-radius: 8px;
            padding: 20px;
            margin: 20px;
        }

    </style>
</head>
<body>
    <nav class="navbar">
        <h1 >panel siswa</h1>
        <div class="navbar-menu">
            <a href="?page=aspirasi" class="active">Aspirasi</a>
            <a href="?page=input">Input Aspirasi</a>
        </div>
    </nav>

    <div class="card">
        <?php include $konten ?>
    </div>
</body>
</html>