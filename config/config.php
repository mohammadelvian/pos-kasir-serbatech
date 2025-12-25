<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

$host   = 'localhost';
$user   = 'root';
$pass   = '';
$dbname = 'kasir';
// Aktifkan ini untuk melihat pesan error jika koneksi gagal

$koneksi    = mysqli_connect($host, $user, $pass, $dbname);
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
// if (mysqli_connect_errno()) {
//     echo "gagal koneksi ke datanase";
//     exit();
// } else {
//     echo "berhasil koneksi ke database";
// }

$main_url = 'http://localhost/pos-kasir/';
