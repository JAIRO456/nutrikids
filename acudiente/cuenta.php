<?php
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

        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
            $fileTmp = $_FILES['profileImage']['tmp_name'];
            $fileName = $_FILES['profileImage']['name'];
            $fileSize = $_FILES['profileImage']['size'];
            $fileType = $_FILES['profileImage']['type'];

            $ruta = '../img/users/';
            // Remplazar los espacios en blanco
            $fileName = str_replace(' ', '_', $fileName);
            $newruta = $ruta . basename($fileName);
            $formatType = array("jpg", "jpeg", "png");
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $formatType)) {
                if (move_uploaded_file($fileTmp, $newruta)) {
                    $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ?, imagen = ? WHERE documento = ?");
                    $sqlUpdate->execute([$telefono, $fileName, $usuarios['documento']]);
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
            $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ? WHERE documento = ?");
            $sqlUpdate->execute([$telefono, $usuarios['documento']]);
            echo '<script>alert("Información actualizada correctamente.")</script>';
            // Redirigir a la misma página para evitar reenvío de formulario
            header("Location: cuenta.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Guardar Cambios</button>
            </div>
        </form>
    </main>
</body>
</html>
