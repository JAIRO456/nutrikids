<?php

session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

?>

<?php
    $id_producto = $_GET['id_producto'];
    $sqlDeleteProduts = $con -> prepare("DELETE FROM producto WHERE id_producto = $id_producto");
    $sqlDeleteProduts -> execute();
    $dp = $sqlDeleteProduts -> fetch();
    echo '<script>alert("Producto Eliminado")</script>';
    echo '<script>window.location = "productos.php"</script>';
?>