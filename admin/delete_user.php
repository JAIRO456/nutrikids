<?php

session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

?>

<?php
    $doc = $_GET['id'];
    $sqlUser = $con -> prepare("DELETE FROM usuarios WHERE documento = $doc");
    $sqlUser -> execute();
    $u = $sqlUser -> fetch();
    echo '<script>alert("Usuario Eliminado")</script>';
    echo '<script>window.location = "roles.php"</script>';
?>

