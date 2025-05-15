<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    $id_licencia = $_GET['id'];
    $sqlLicencias = $con -> prepare("DELETE FROM licencias WHERE id_licencia = ?");
    $sqlLicencias -> execute([$id_licencia]);
    $Delete = $sqlLicencias -> fetch();
    echo '<script>alert("Licencia Eliminado")</script>';
    echo '<script>window.location = "../licencias.php"</script>';
?>