<?php
// Memulai session
session_start();

// Menghapus semua data session
session_destroy();

// Mengarahkan user ke halaman login
header("Location: ../auth/login.php");

// Keluar/berhenti dari berjalanya code
exit();
?>