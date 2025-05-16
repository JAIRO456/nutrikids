<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $imagen = $_FILES['imagen']['name'];
        $temp = $_FILES['imagen']['tmp_name'];

        if (!empty($imagen)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../../img/schools/" . $imagen);
        } 
        else {
            $imagen = null;
        }

        $sqlInsertSchool = $con->prepare("INSERT INTO escuelas (nombre_escuela, email_esc, telefono_esc, imagen_esc) VALUES (?, ?, ?, ?)");
        if ($sqlInsertSchool->execute([$nombre, $email, $telefono, $imagen])) {
            echo '<script>alert("Escuela creada exitosamente")</script>';
            echo '<script>window.location = "../escuelas.php"</script>';
        } 
        else {
            echo '<script>alert("Error al crear la escuela")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Crear Escuela</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Escuela</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen">
                        </div>
                        <button type="submit" class="btn btn-danger">Registrar Escuela</button>
                        <a href="../escuelas.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>