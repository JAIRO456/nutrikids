<?php

session_start();
require_once('../conex/conex.php');
require_once('../include/inicio.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    $doc = $_SESSION['documento'];
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado WHERE usuarios.documento = '$doc'");
    $sql -> execute();
    $u = $sql -> fetch();
?>

<?php
    $sqlEstudiante = $con->prepare("SELECT * FROM estudiantes INNER JOIN usuarios ON estudiantes.documento = usuarios.documento
    WHERE usuarios.documento = $u[documento]");
    $sqlEstudiante->execute();
    $e = $sqlEstudiante->fetchAll(PDO::FETCH_ASSOC);
?>



<?php
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $fileTmp = $_FILES['imagen']['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileSize = $_FILES['imagen']['size'];
            $fileType = $_FILES['imagen']['type'];

            $ruta = '../img/users/';
            $newruta = $ruta . basename($fileName);

            $formatType = array("jpg", "jpeg", "png");
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $formatType)) {
                // Mover la imagen al directorio de subida
                if (move_uploaded_file($fileTmp, $newruta)) {
                    // Si la imagen se ha subido correctamente, guardamos el nombre de la imagen en la base de datos
                    $sqlInsert = $con->prepare("UPDATE usuarios SET imagen = '$fileName' WHERE documento = $u[documento]");
                    $sqlInsert->execute();
                } 
                
                else {
                    echo '<script>alert("Error al subir la imagen. Inténtelo de nuevo.")</script>';
                }
            } 
            
            else {
                echo '<script>alert("Formato de imagen no válido.")</script>';
            }

    }

    // if (file_exists($u['imagen']) && is_file($u['imagen'])) {
    //     echo "<img src='../img/users/".$u['imagen']."' class='imagen' alt=''>";
    // }
     
    // else {
    //     echo "<img src='../img/users/user.png' class='imagen' alt=''>";
    // }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/cuenta.css">
    <title>Document</title>
</head>
<body>
    <main class="container-main">    
        <div class="container-img">
            <?php 
                if (file_exists($u['imagen']) && is_file($u['imagen'])) {
                    echo "<img src='../img/users/".$u['imagen']."' class='imagen' alt=''>";
                }
                 
                else {
                    echo "<img src='../img/users/user.png' class='imagen' alt=''>";
                }
            ?>
            <div class='container-name'>
                <h1>Bienvenido <?php echo $u['nombre']; ?> <?php echo $u['apellido']; ?></h1>
            </div>
        </div>

    <!-- Formulario para actualizar información del usuario: -->
    <!-- Cambio de contraseña: -->

        <div class="container-info">
            <h2>Informacion:</h2>
            <div class="container-datas">
                <h3>Documento: <br><?php echo $u['documento']; ?></h3>
                <h3>Correo: <br><?php echo $u['email']; ?></h3>
                <h3>Rol: <br><?php echo $u['rol']; ?></h>
            </div>
        </div>

        <div class="container-update">
            <h2>Actualizar datos</h2>
            <div class="container-datas">
                <h3>Contraseña: <br><?php echo $u['documento']; ?></h3>
                <h3>Correo: <br><?php echo $u['email']; ?></h3>
                <h3>Telefono: <br><?php echo $u['telefono']; ?></h3>
            </div>
        </div>

        <div class="container-info-estudiantes">
            <h2>Estudiantes:</h2>
            <div class="container-estudiantes">
                <?php
                    foreach ($e as $estudiante){ ?>
                        <h2>Imagen</h2>
                        <img src="../img/users/<?php echo $estudiante['imagen_est']; ?>" alt="">
                        <h2>Nombres</h2>
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
                        // <?php echo $sqlSchoolsEstudiante['imagen_esc']; 
                    ?>  
                        <div class="container-img-logo">
                            <img class="logo-schools" src="../img/schools/logo-nutrikids.png" alt="">
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