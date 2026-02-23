<?php
include "koneksi.php";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'aspirasi':
            $konten = "aspirasi.php";
            break;
        case 'input':
            $konten = "input.php";
            break;
        
        default:
            $konten = "404.php";
            break;
    } if ($konten === "404.php") {
        include "404.php";
    } else {
        include "kerangka.php";
    }
} else {
    include "404.php";
}