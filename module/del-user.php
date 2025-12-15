<?php

require "../config/config.php";
require "../config/function.php";
require "../module/mode-user";

$id     = $_GET['id'];
$foto   = $_GET['foto'];



if (delete($id, $foto)) {
    echo "
            <script>
                alert ('user berhasil dihapus..'):
                document.location.href = data-user.php;
            
            </script>
    
    ";
} else {
    echo "<script>
                alert ('user gagal dihapus..'):
                document.location.href = data-user.php;
            
            <?php

            require_once __DIR__ . '/../config/config.php';
            require_once __DIR__ . '/../config/function.php';
            require_once __DIR__ . '/../module/mode-user.php';

            $id   = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            $foto = isset($_GET['foto']) ? $_GET['foto'] : '';

            // basic validation
            if ($id <= 0) {
                header('Location: ../data-user.php');
                exit;
            }

            if (delete($id, $foto)) {
                header('Location: ../data-user.php?msg=deleted');
                exit;
            } else {
                header('Location: ../data-user.php?msg=error');
                exit;
            }
