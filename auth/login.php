<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="number" name="username" required>

        <label for="passwor">Passwprd:</label>
        <input type="text" name="password" required>

        <button type="submit" name="submit">Submit</button>
    </form>
    <?php 
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $query = $koneksi->query("SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
        $data  = $query->fetch_assoc();

        if ($data) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['password'] = $data['password'];

            header("Location: ../admin/?page=aspirasi");
            exit();
        } else {
            echo "yang bener??";
            exit();
        }
    }
     ?>
</body>
</html>