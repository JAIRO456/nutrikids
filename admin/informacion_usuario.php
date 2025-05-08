<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    $doc = $_GET['id'];
    $sqlUser = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado WHERE documento = $doc");
    $sqlUser -> execute();
    $u = $sqlUser -> fetch();
?>

<?php
    $sqlEstudiante = $con->prepare("SELECT * FROM estudiantes INNER JOIN usuarios ON estudiantes.documento = usuarios.documento WHERE usuarios.documento = $u[documento]");
    $sqlEstudiante->execute();
    $e = $sqlEstudiante->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/informacion_usuario.css">
    <title>Document</title>
</head>
<body>
    <main class="container-main">
        <div class="container-user-name">
            <h1><?php echo $u["nombre"];?> <?php echo $u["apellido"];?></h1>
            <div class="container-img">
                <img src="../img/users/user.png" alt="">
            
        </div>

        <div class="container-info">
            <h1>Informacion:</h1>
            <div class="container-datas">
                <h3>Documento: <br><?php echo $u['documento']; ?></h3>
                <h3>Rol: <br><?php echo $u['rol']; ?></h>
                <h3>Correo: <br><?php echo $u['email']; ?></h3>
                <h3>Telefono: <br><?php echo $u['telefono']; ?></h3>
            </div>
        </div>

        <div class="container-info-estudiantes">
            <h1>Estudiantes:</h1>
        <?php
            foreach ($e as $estudiante){ ?>

            <div class="container-estudiantes-img">
                <img src="../img/schools/logo-nutrikids.png" alt="">
            </div>
                
            <div class="container-datas-estudiantes">
                <h2>Nombre Completo</h2>
                <h3><?php echo $estudiante['nombre_est']; ?> <?php echo $estudiante['apellido_est']; ?></h3>
                <h2>Documento</h2>
                <h3><?php echo $estudiante['documento_est']; ?></h3>
                <h2>Correo</h2>
                <h3><?php echo $estudiante['email_est']; ?></h3>
                <h2>Telefono</h2>
                <h3><?php echo $estudiante['telefono_est']; ?></h3>
                <h2>Escuela</h2>
                <?php
                    $sqlSchool = $con->prepare("SELECT * FROM estudiantes INNER JOIN escuelas ON estudiantes.id_escuela = escuelas.id_escuela 
                    WHERE estudiantes.documento_est = $estudiante[documento_est]");
                    $sqlSchool->execute();
                    $sqlSchoolsEstudiante  = $sqlSchool->fetch();
                ?>  
                    <h3><?php echo $sqlSchoolsEstudiante['nombre_escuela']; ?></h3>
            </div>    
        <?php
            }
        ?>
            </div>
        </div>
    </main>
</body>
</html>