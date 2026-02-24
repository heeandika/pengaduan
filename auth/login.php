<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #333333;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background: #4f4f4f;
        padding: 30px;
        border-radius: 5px;
        width: 100%;
        max-width: 350px;
        }

    h1 {
        color: white;
        text-align: center;
        margin-top: 0;
        margin-bottom: 30px;
        font-size: 24px;
    }

    label {
        display: block;
        margin-top: 15px;
        color: white;
        font-size: 14px;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #666;
        border-radius: 4px;
        background-color: #333;
        color: white;
        box-sizing: border-box;
    }

    input:focus {
        outline: none;
        border-color: #007bff;
    }

    button {
        width: 100%;
        background-color: #007bff;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 25px;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error {
        color: #ff6b6b;
        text-align: center;
        margin-top: 15px;
        padding: 10px;
        background-color: #4f4f4f;
        border-radius: 4px;
        font-size: 14px;
    }
</style>

<body>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="password" name="username" required>

        <label for="passwor">Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="submit">Submit</button>
    </form>
    <?php
    include "../koneksi.php";

    if (isset($_POST['submit'])) {
        $username = (int)$_POST['username'];
        $password = md5($_POST['password']);

        $query = $koneksi->query("SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
        $data  = $query->fetch_assoc();

        if ($data) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['password'] = $data['password'];

            header("Location: ../admin/?page=aspirasi");
            exit();
        } else {
            // header("location: login.php");
            echo "yang bener??";
            exit();
            
        }
    }
    ?>
</body>

</html>