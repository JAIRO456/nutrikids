<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    $id_producto = $_GET['id'];
    $sqlProducto = $con -> prepare("DELETE FROM producto WHERE id_producto = ?");
    $sqlProducto -> execute([$id_producto]);
    $Delete = $sqlProducto -> fetch();
    echo '<script>alert("Producto Eliminado")</script>';
    echo '<script>window.location = "../productos.php"</script>';
?>