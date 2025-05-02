<?php

require_once('../conex/conex.php');
require_once('../include/validate_login.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    // $doc = $_SESSION['documento'];
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado INNER JOIN escuelas ON usuarios.id_escuela = escuelas.id_escuela WHERE usuarios.documento = 1234567891");
    $sql -> execute();
    $u = $sql -> fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/adm_menu.css">
</head>
<body>
    <header class="container-header">
        <label for="" class="user"><?php echo $u['nombre']; ?> <?php echo $u['apellido']; ?>, <?php echo $u['rol']; ?>.</label>
        <a href="cuenta.php"><i class="icono bi bi-person-circle"></i></a>
    </header>
</body>
</html>
    