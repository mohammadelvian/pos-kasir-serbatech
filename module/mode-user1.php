<?php

function insert($data)
{
    global $koneksi;

    // 1. Ambil input text (Bersihkan biar aman dari SQL Injection)
    $username  = strtolower(mysqli_real_escape_string($koneksi, $data['username']));
    $fullname  = mysqli_real_escape_string($koneksi, $data['fullname']);
    $password  = mysqli_real_escape_string($koneksi, $data['password']);
    $password2 = mysqli_real_escape_string($koneksi, $data['password2']);
    $level     = mysqli_real_escape_string($koneksi, $data['level']);
    $address   = mysqli_real_escape_string($koneksi, $data['address']);

    // 2. Cek Konfirmasi Password
    if ($password !== $password2) {
        echo "<script>
        alert('Konfirmasi password tidak sesuai, user baru gagal diregistrasi!');
        </script>";
        return false;
    }

    // 3. Enkripsi Password
    $pass = password_hash($password, PASSWORD_DEFAULT);

    // 4. Cek Username Duplikat
    $CekUsername = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");
    if (mysqli_num_rows($CekUsername) > 0) {
        echo "<script>
        alert('Username sudah terdaftar, silahkan gunakan username lain!');
        </script>";
        return false;
    }

    // 5. PROSES UPLOAD GAMBAR (Perbaikan Logika)
    // Cek apakah ada file yang diupload di $_FILES, bukan di $data
    $nama_file_gambar = $_FILES['image']['name'];

    if ($nama_file_gambar != '') {
        // Jika ada file, jalankan fungsi upload
        $gambar = uploadimg();

        // Jika upload gagal (format salah/size besar), hentikan proses
        if ($gambar == false) {
            return false;
        }
    } else {
        // Jika tidak upload gambar, pakai default
        $gambar = 'default.png';
    }

    // 6. SIMPAN KE DATABASE (Perbaikan Fatal Error)
    $sqlUser = "INSERT INTO tbl_user VALUES (null, '$username', '$fullname', '$pass', '$address', '$level', '$gambar')";

    // --- INI YANG SEBELUMNYA KURANG ---
    mysqli_query($koneksi, $sqlUser);

    // 7. Kembalikan jumlah baris yang terpengaruh (1 = sukses, 0 = gagal)
    return mysqli_affected_rows($koneksi);
}
