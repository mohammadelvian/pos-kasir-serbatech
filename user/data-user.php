<?php

require "../config/config.php";
require "../config/function.php";
require "../module/mode-user.php";


$title = "Users - Serbatech POS";
require "../template/header.php";
require "../template/navbar.php";
require "../template/sidebar.php";


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= $main_url ?>dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">user </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list fa-sm"></i> Data User</h3>
                    <div class="card-tools">
                        <a href="<?= $main_url ?>user/add-user.php" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Add User</a>
                    </div>
                </div>
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Alamat</th>
                                <th>Level</th>
                                <th style="width: 10%;">Operasi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $no = 1; // Inisialisasi variabel untuk nomor urut

                            // Mengambil semua data pengguna dari tabel 'tbl_user'. 
                            // Fungsi getData() diasumsikan menjalankan query database.
                            $users = getData("SELECT * FROM tbl_user");
                            // Memulai loop untuk menampilkan setiap baris data pengguna
                            foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><img src="../asset/image/<?= $user['foto'] ?>" class="rounded-circle" alt="" width="60px" height="60px" style="object-fit: cover;"></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['fullname'] ?></td>
                                    <td><?= $user['address'] ?></td>
                                    <td>
                                        <?php
                                        if ($user['level'] == 1) {
                                            echo "Administrator";
                                        } elseif ($user['level'] == 2) {
                                            echo "Supervisor";
                                        } else {
                                            echo "Operator";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning" title="edit user"><i class="fas fa-user-edit"></i></a>
                                        <a href="del-user.php?id=<?= $user['userid'] ?>&foto=<?= $user['foto'] ?>" class="btn btn-sm btn-danger" title="hapus user" onclick="return confirm ('Anda yakin akan menghapus user ini ?')"><i class="fas fa-user-times"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php

    require "../template/footer.php";

    ?>