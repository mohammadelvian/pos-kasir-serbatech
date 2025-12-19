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

function selectUser1($level)
{
    $result = null;
    if ($level == 1) {
        $result = "selected";
    }

    return $result;
}

function selectUser2($level)
{
    $result = null;
    if ($level == 2) {
        $result = "selected";
    }

    return $result;
}

function selectUser3($level)
{
    $result = null;
    if ($level == 3) {
        $result = "selected";
    }

    return $result;
}


function Update($data)
{
    global $koneksi;

    $iduser     = mysqli_real_escape_string($koneksi, $data['id']);
    $username = strtolower(mysqli_real_escape_string($koneksi, $data["username"]));
    $fullname = mysqli_real_escape_string($koneksi, $data['fullname']);
    $level = mysqli_real_escape_string($koneksi, $data['level']);
    $address = mysqli_real_escape_string($koneksi, $data['address']);
    $gambar = $_FILES['image']['name'];
    $fotoLama = mysqli_real_escape_string($koneksi, $data['oldImg']);

    //cek username sekarang (yg sedang di update)
    $queryUsername = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE userid = $iduser");
    $dataUsername = mysqli_fetch_assoc($queryUsername);
    //untuk menyimpan user yg sedang di update
    $curUsername = $dataUsername['username'];

    //cek username baru
    $newUsername = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");

    if ($username !== $curUsername) {
        if (mysqli_num_rows($newUsername)) {
            echo "<script>
            alert('username sudah terpakai, update data user gagal !');
            </script>";
            return false;
        }
    }

    //Memeriksa apakah ada file gambar baru yang diunggah ($gambar tidak sama dengan null)
    // Jika ada gambar baru, siapkan URL/path untuk proses upload (atau fungsi uploadimg)
    $url = "data-user.php";
    if ($gambar    != null) {
        $url        = "data-user.php";
        // Panggil fungsi kustom untuk mengunggah dan memproses gambar baru
        // Hasilnya (biasanya nama file baru atau path) disimpan di $imgUser
        $imgUser    = uploadimg($url);
        // Cek apakah foto lama BUKAN foto default ('default.png')    
        if ($fotoLama != 'default.png') {
            // Jika foto lama adalah foto kustom (bukan default), 
            // @unlink digunakan untuk menghapus file foto lama dari server.
            // Tanda @ berfungsi untuk menekan error jika file tidak ditemukan.
            @unlink('../asset/image/' . $fotoLama);
        }
    } else {
        // Jika tidak ada file gambar baru yang diunggah ($gambar sama dengan null)
        // Pertahankan nama file/path gambar yang lama
        $imgUser = $fotoLama;
    }

    mysqli_query($koneksi, "UPDATE tbl_user SET
                            username    = '$username',
                            fullname    = '$fullname',
                            address     = '$address',
                            level       = '$level',
                            foto        = '$imgUser'
                            WHERE userid= $iduser
                            ");
    return mysqli_affected_rows($koneksi);
}
