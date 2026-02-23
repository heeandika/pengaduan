<?php
session_start();
session_destroy();
header("Locatrion: ../auth/login.php");
exit();