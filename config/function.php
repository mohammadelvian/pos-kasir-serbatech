<?php

use Dom\Mysql;
use LDAP\Result;

function uploadimg($url = null)
{
    $namafile = $_FILES['image']['name'];
    $ukuran = $_FILES['image']['size'];
    $tmp = $_FILES['image']['tmp_name'];


    //validasi file gambar yg boleh diupload
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $ekstensigambarvalid)) {
        if ($url != null) {
            echo '<script>
        alert("Tipe file yang anda upload bukan gambar, data gagal diupdate !");
        document.location.href = "' . $url . '";
        </script>';
            die();
        } else {
            echo '<script>
        alert("Tipe file yang anda upload bukan gambar!");
        </script>';
            return false;
        }
    }

    //validasi ukuran gambar max 1 MB
    if ($ukuran > 1000000) {
        if ($url != null) {
            echo '<script>
        alert("Ukuran gambar melebihi 1 MB!");
        document.location.href = "' . $url . '";
        </script>';
            die();
        } else {
            echo '<script>
        alert("Ukuran gambar terlalu besar! Max 1 MB");
        </script>';
            return false;
        }
    }

    $namafilebaru = rand(10, 1000) . '-' . $namafile;
    move_uploaded_file($tmp, '../asset/image/' . $namafilebaru);
    return $namafilebaru;
}

function getData($sql)
{
    global $koneksi;


    $result = mysqli_query($koneksi, $sql);
    // KOREKSI: Tambahkan pengecekan ini
    if (!$result) {
        // Ini akan menampilkan pesan error MySQL yang spesifik
        die("Query Gagal! Error: " . mysqli_error($koneksi) . " | Query: " . $sql);
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

/**
 * Fungsi untuk mengambil data lengkap user yang sedang login
 * @return array - Mengembalikan array berisi data user dari database
 */
function userLogin()
{
    $userActive = $_SESSION["ssUserPOS"]; // Mengambil username user yang sedang aktif dari session 'ssUserPOS'
    // Menjalankan query untuk mengambil seluruh kolom dari tabel user
    // berdasarkan username yang didapat dari session.
    // [0] digunakan untuk mengambil baris pertama dari hasil query (index 0).
    $dataUser = getData("SELECT * FROM tbl_user WHERE username = '$userActive'")[0];
    // Mengembalikan data user dalam bentuk array asosiatif
    return $dataUser;
}
// cek url yg sedang aktif
function userMenu()
{
    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri_segments = explode('/', $uri_path);
    $menu         = $uri_segments[2];
    return $menu;
}

function menuHome()
{
    if (userMenu() == 'dashboard.php') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}

function menuSetting()
{
    if (userMenu() == 'user') {
        $result = 'menu-is-opening menu-open';
    } else {
        $result = null;
    }
    return $result;
}

function menuUser()
{
    if (userMenu() == 'user') {
        $result = 'active';
    } else {
        $result = null;
    }
    return $result;
}
