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
            
            </script>";
}
