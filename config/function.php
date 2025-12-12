<?php

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
