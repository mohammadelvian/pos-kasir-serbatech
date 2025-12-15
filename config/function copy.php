<?php

/**
 * Fungsi untuk menangani proses upload file gambar.
 * Melakukan validasi tipe file, ukuran, dan memindahkan file ke direktori tujuan.
 *
 * @return string|false Mengembalikan nama file baru jika upload sukses, atau false jika gagal validasi.
 */
function uploadimg()
{
    // Mengambil informasi file yang diupload dari superglobal $_FILES['image']
    $namafile = $_FILES['image']['name'];      // Nama asli file yang diupload
    $ukuran = $_FILES['image']['size'];        // Ukuran file dalam bytes
    $tmp = $_FILES['image']['tmp_name'];       // Lokasi sementara file di server

    // --- 1. VALIDASI TIPE FILE (Ekstensi) ---

    // Daftar ekstensi gambar yang valid/diizinkan untuk diupload
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png', 'gif'];

    // Memecah nama file berdasarkan titik (.) untuk mendapatkan bagian ekstensi
    $ekstensigambar = explode('.', $namafile);

    // Mengambil elemen terakhir dari array (ekstensi), lalu mengubahnya menjadi huruf kecil
    $ekstensigambar = strtolower(end($ekstensigambar));

    // Memeriksa apakah ekstensi file ada dalam daftar ekstensi yang valid
    if (!in_array($ekstensigambar, $ekstensigambarvalid)) {
        // Jika tipe file tidak valid (bukan gambar)
        echo '<script>
        alert("Tipe file yang anda upload bukan gambar!");
        </script>';
        return false; // Menghentikan fungsi dan menandakan kegagalan
    }

    // --- 2. VALIDASI UKURAN FILE ---

    // Memeriksa apakah ukuran file melebihi batas maksimum (1.000.000 bytes = 1 MB)
    if ($ukuran > 1000000) {
        // Jika ukuran terlalu besar
        echo '<script>
        alert("Ukuran gambar terlalu besar! Max 1 MB");
        </script>';
        return false; // Menghentikan fungsi dan menandakan kegagalan
    }

    // --- 3. PEMINDAHAN (Upload) FILE ---

    // Membuat nama file baru yang unik (random number + nama asli)
    // Hal ini penting untuk menghindari duplikasi nama file di folder tujuan
    $namafilebaru = rand(10, 1000) . '-' . $namafile;

    // Memindahkan file dari lokasi sementara ($tmp) ke lokasi tujuan permanen
    // Direktori tujuan: '../asset/image/'
    move_uploaded_file($tmp, '../asset/image/' . $namafilebaru);

    // Mengembalikan nama file baru yang telah disimpan di server
    return $namafilebaru;
}
