<?php

function insert($data)
{
    global $koneksi;

    $username = strtolower(mysqli_real_escape_string($koneksi, $data["username"]));
    $fullname = mysqli_real_escape_string($koneksi, $data['fullname']);
    $password  = mysqli_real_escape_string($koneksi, $data['password']);
    $password2  = mysqli_real_escape_string($koneksi, $data['password2']);
    $level = mysqli_real_escape_string($koneksi, $data['level']);
    $address = mysqli_real_escape_string($koneksi, $data['address']);
    $gambar = $_FILES['image']['name'];

    //jika konfirmasi password tidak sama
    if ($password !== $password2) {
        echo "<script>
            alert ('konfirmasi password tidak sesuai, user baru gagal diregistrasi !');
            </script>";
        return false;
    }
    //jika konfirmasi password sesuai maka enkripsi dg password_hash
    $pass = password_hash($password, PASSWORD_DEFAULT);

    //cek username duplikat
    $cekUsername = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");
    if (mysqli_num_rows($cekUsername) > 0) {
        echo "<script>
            alert ('username sudah terpakai, user baru gagal dieregistrasi !');
            </script>";
        return false;
    }
    //LOGIKA UPLOAD GAMBAR
    if ($gambar != null) {
        $gambar = uploadimg();
    } else {
        $gambar = 'default.png';
    }

    //gambar tidak sesuai validasi
    if ($gambar == '') {
        return false;
    }

    $sqlUser = "INSERT INTO tbl_user VALUES (null, '$username', '$fullname', '$pass', '$address', '$level', '$gambar')";
    mysqli_query($koneksi, $sqlUser);


    return mysqli_affected_rows($koneksi);
}

function delete($id, $foto)
{
    global $koneksi;


    $sqlDel = "DELETE FROM tbl_user WHERE userid = $id";
    mysqli_query($koneksi, $sqlDel);
    if ($foto != 'default.png') {
        unlink('../asset/image/' . $foto);
    }
    return mysqli_affected_rows($koneksi);
}
