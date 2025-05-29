<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $doc = $_SESSION['documento'];
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");
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
            $formatType = array("jpg", "jpeg", "png");
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $formatType)) {
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
                    exit;
                }
            } 
            else {
                echo '<script>alert("Formato de imagen no válido.")</script>';
                // Redirigir a la misma página para evitar reenvío de formulario
                header("Location: cuenta.php");
                exit;
            }
        }
        else {
            $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ?, id_rol = ? WHERE documento = ?");
            $sqlUpdate->execute([$telefono, $id_rol, $usuarios['documento']]);
            echo '<script>alert("Información actualizada correctamente.")</script>';
            // Redirigir a la misma página para evitar reenvío de formulario
            header("Location: cuenta.php");
            exit;
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
            <div class="text-center mb-1">
                <h1 class="h3 mb-1 fw-normal">Mi Cuenta</h1>
                <p class="text-muted">Actualiza tu información personal</p>
                <img src="../img/users/<?= $usuarios['imagen']; ?>" alt="<?= $usuarios['nombre']; ?>" class="profile-img mb-3" style="width: 150px; height: 150px; border-radius: 50%;">
                <div class="mb-3">
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
            <div class="text-center">
                <button type="submit" class="btn btn-danger">Guardar Cambios</button>
            </div>
        
            <div class="text-center mb-4">
                <h2 class="mt-4">Información de la Escuela</h2>
                <p class="text-muted">Aquí puedes ver la información de tu escuela</p>
                <img src="../img/schools/<?= $usuarios['imagen_esc']; ?>" alt="<?= $usuarios['nombre_escuela']; ?>" class="profile-img mb-3" style="width: 150px; height: 150px; border-radius: 50%;">
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nombre_escuela" class="form-label">Nombre de la Escuela</label>
                    <input type="text" class="form-control" id="nombre_escuela" name="nombre_escuela" value="<?= $usuarios['nombre_escuela']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Correo de la Escuela</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $usuarios['email_esc']; ?>" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telefono_escuela" class="form-label">Telefono de la Escuela</label>
                    <input type="number" class="form-control" id="telefono_escuela" name="telefono_escuela" value="<?= $usuarios['telefono_esc']; ?>">
                </div>
            </div>
            <div class="text-center mb-4">
                <h2 class="mt-4">Información de la Licencia</h2>
                <p class="text-muted">Aquí puedes ver la información de tu licencia</p>
                <?php
                    $sqlLicencia = $con->prepare("SELECT * FROM licencias WHERE id_escuela = ?");
                    $sqlLicencia->execute([$usuarios['id_escuela']]);
                    $licencia = $sqlLicencia->fetch();
                ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?= $licencia['fecha_inicio']; ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?= $licencia['fecha_fin']; ?>" readonly>
                    </div>
                </div>
                <div class="text-center">
                    <button id="license-btn" class="btn btn-sm btn-warning">Renovar</button>
                </div>
            </div>
        </form>
    </main>
</body>
<script>
    // Actualizar la licencias dependiendo del id_escuela
    document.getElementById('license-btn').addEventListener('click', function(e) {
        e.preventDefault();
        const idEscuela = <?= $usuarios['id_escuela']; ?>;
        
        fetch('../ajax/update_license.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id_escuela=' + idEscuela
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                location.reload(); // Recargar la página para ver los cambios
            } 
            else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</html>
