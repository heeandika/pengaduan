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

        $stmt = $koneksi->prepare("SELECT * FROM admin ($username, $password) VALUES (?, ?)");
        $stmt->bind_param("is", $username, $password);
        $stmt->execute(
            header("Location: ../admin/?page=aspirasi")
        );

    }
     ?>
</body>
</html>