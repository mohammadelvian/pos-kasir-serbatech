<?php

use Dom\Mysql;

function uploadimg()
{
    $namafile = $_FILES['image']['name'];
    $ukuran = $_FILES['image']['size'];
    $tmp = $_FILES['image']['tmp_name'];


    //validasi file gambar yg boleh diupload
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $ekstensigambarvalid)) {
        echo '<script>
        alert("Tipe file yang anda upload bukan gambar!");
        </script>';
        return false;
    }

    //validasi ukuran gambar max 1 MB
    if ($ukuran > 1000000) {
        echo '<script>
        alert("Ukuran gambar terlalu besar! Max 1 MB");
        </script>';
        return false;
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

// function delete($id, $foto)
// {
//     global $koneksi;
//     // sanitize inputs
//     $id = (int) $id;
//     $foto = basename($foto);

//     if ($id <= 0) {
//         return false;
//     }

//     $sqlDel = "DELETE FROM tbl_user WHERE userid = $id";
//     $res = mysqli_query($koneksi, $sqlDel);

//     if ($res) {
//         if ($foto && $foto !== 'default.png') {
//             $path = __DIR__ . '/../asset/image/' . $foto;
//             if (is_file($path)) {
//                 @unlink($path);
//             }
//         }
//         return true;
//     }

//     return false;
// }
