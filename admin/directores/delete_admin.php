<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    $id_usuario = $_GET['id'];
    $sqlUsuarios = $con -> prepare("DELETE FROM usuarios WHERE documento = ?");
    $sqlUsuarios -> execute([$id_usuario]);
    $Delete = $sqlUsuarios -> fetch();
    echo '<script>alert("Usuario Eliminado")</script>';
    echo '<script>window.location = "../directores.php"</script>';
?>