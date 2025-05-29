<?php
<<<<<<< HEAD
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $doc = $_SESSION['documento'];
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado WHERE usuarios.documento = ?");
    $sql -> execute([$doc]);
    $usuarios = $sql -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $telefono = $_POST['telefono'];
        $id_rol = $_POST['id_rol'];

        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
            $fileTmp = $_FILES['profileImage']['tmp_name'];
            $fileName = $_FILES['profileImage']['name'];
            $fileSize = $_FILES['profileImage']['size'];
            $fileType = $_FILES['profileImage']['type'];

            $ruta = '../img/users/';
            // Remplazar los espacios en blanco
            $fileName = str_replace(' ', '_', $fileName);
            $newruta = $ruta . basename($fileName);
=======

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

>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
            $formatType = array("jpg", "jpeg", "png");
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $formatType)) {
<<<<<<< HEAD
                if (move_uploaded_file($fileTmp, $newruta)) {
                    $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ?, id_rol = ?, imagen = ? WHERE documento = ?");
                    $sqlUpdate->execute([$telefono, $id_rol, $fileName, $usuarios['documento']]);
                    echo '<script>alert("Información actualizada correctamente.")</script>';
                    // Redirigir a la misma página para evitar reenvío de formulario
                    header("Location: cuenta.php");
                }
                else {
                    echo '<script>alert("Error al subir la imagen. Inténtelo de nuevo.")</script>';
                    // Redirigir a la misma página para evitar reenvío de formulario
                    header("Location: cuenta.php");
                }
            } 
            else {
                echo '<script>alert("Formato de imagen no válido.")</script>';
                // Redirigir a la misma página para evitar reenvío de formulario
                header("Location: cuenta.php");
            }
        }
        else {
            $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ?, id_rol = ? WHERE documento = ?");
            $sqlUpdate->execute([$telefono, $id_rol, $usuarios['documento']]);
            echo '<script>alert("Información actualizada correctamente.")</script>';
            // Redirigir a la misma página para evitar reenvío de formulario
            header("Location: cuenta.php");
        }
    }
=======
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

>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>INICIO</title>
    <link rel="stylesheet" href="../styles/inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container account-container">
        <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
            <div class="text-center mb-4">
            <h1 class="h3 mb-3 fw-normal">Mi Cuenta</h1>
            <p class="text-muted">Actualiza tu información personal</p>
                <img src="../img/users/<?= $usuarios['imagen']; ?>" alt="<?= $usuarios['nombre']; ?>" class="profile-img mb-3" style="width: 150px; height: 150px; border-radius: 50%;">
                <div>
                    <input type="file" class="form-control d-inline-block w-auto" name="profileImage" id="profileImage" accept="image/*">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="documento" class="form-label">Documento</label>
                    <input type="number" class="form-control" id="documento" name="documento" value="<?= $usuarios['documento']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombres</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuarios['nombre']; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $usuarios['apellido']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $usuarios['email']; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="number" class="form-control" id="telefono" name="telefono" value="<?= $usuarios['telefono']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="id_rol" class="form-label">Rol</label>
                    <select class="form-select" id="id_rol" name="id_rol">
                        <option value="<?= $usuarios['id_rol']; ?>"><?= $usuarios['rol']; ?></option>
                        <?php
                            $sqlRoles = $con->prepare("SELECT * FROM roles WHERE id_rol != $usuarios[id_rol] ORDER BY id_rol ASC");
                            $sqlRoles->execute();
                            while ($row = $sqlRoles->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['id_rol']}'>{$row['rol']}</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <button type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </main>
</body>
</html>
=======
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
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
