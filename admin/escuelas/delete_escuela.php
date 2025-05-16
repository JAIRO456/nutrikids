<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    $id_escuela = $_GET['id'];
    $sqlEscuelas = $con -> prepare("DELETE FROM escuelas WHERE id_escuela = ?");
    $sqlEscuelas -> execute([$id_escuela]);
    $Delete = $sqlEscuelas -> fetch();
    echo '<script>alert("Escuela Eliminado")</script>';
    echo '<script>window.location = "../escuelas.php"</script>';
?>