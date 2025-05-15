<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios 
    INNER JOIN detalles_usuarios_escuela 
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento_est = $_POST['documento_est'];
        $nombre = $_POST['nombre']; 
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $documento_acudiente = $_POST['documento_acudiente'];
        $id_escuela = $u['id_escuela'];
        $imagen = $_FILES['imagen']['name'];
        $temp = $_FILES['imagen']['tmp_name'];

        if (!empty($imagen)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../img/users/" . $imagen);
        } 
        else {
            $imagen = null;
        }

        $sqlInsertUser = $con->prepare("INSERT INTO estudiantes (documento_est, nombre, apellido, email, telefono, imagen, documento, id_estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($sqlInsertUser->execute([$documento_est, $nombre, $apellido, $email, $telefono, $imagen, $documento_acudiente, 2])) {
            $sqlInsertDetails = $con->prepare("INSERT INTO detalles_estudiantes_escuela (documento_est, id_escuela) VALUES (?, ?)");
            if ($sqlInsertDetails->execute([$documento_est, $id_escuela])) {
                echo '<script>alert("Estudiante creado exitosamente")</script>';
                echo '<script>window.location = "agregar.php"</script>';
            } 
            else {
                echo '<script>alert("Error al asignar la escuela al Estudiante")</script>';
            }
        } 
        else {
            echo '<script>alert("Error al crear al Estudiante")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acudientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Agregar Nuevo Estudiante</h2>
                    <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="documento_est" class="form-label">Documento</label>
                            <input type="number" class="form-control" id="documento_est" name="documento_est" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="documento_acudiente" class="form-label">Documento del Acudiente</label>
                            <input type="number" class="form-control" id="documento_acudiente" name="documento_acudiente" required>
                        </div>
                        
                        <div class="col-md-12 mt-4">
                            <h2 class="text-center">Información del Acudiente</h2>
                            <div class="mb-3">
                                <label for="nombre_acu" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_acu" name="nombre_acu" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="apellido_acu" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido_acu" name="apellido_acu" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="email_acu" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="email_acu" name="email_acu" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="telefono_acu" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="telefono_acu" name="telefono_acu" readonly>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger">Registrar Acudiente</button>
                        <a href="agregar.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        document.getElementById('documento_acudiente').addEventListener('change', function () {
            const id_usuario = this.value;
            if (id_usuario) {
                getAcudiente(id_usuario);
            } 
            else {
                document.getElementById('nombre_acu').value = '';
                document.getElementById('apellido_acu').value = '';
                document.getElementById('email_acu').value = '';
                document.getElementById('telefono_acu').value = '';
            }
        });

        function getAcudiente(id_usuario) {
            fetch(`../ajax/get_acudientes.php?id_usuario=${encodeURIComponent(id_usuario)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        document.getElementById('nombre_acu').value = '';
                        document.getElementById('apellido_acu').value = '';
                        document.getElementById('email_acu').value = '';
                        document.getElementById('telefono_acu').value = '';
                    } 
                    else {
                        document.getElementById('nombre_acu').value = data.nombre || '';
                        document.getElementById('apellido_acu').value = data.apellido || '';
                        document.getElementById('email_acu').value = data.email || '';
                        document.getElementById('telefono_acu').value = data.telefono || '';
                    }
                })
                .catch(error => {
                    console.error('Error al obtener datos:', error);
                    alert('Error al consultar el acudiente');
                    document.getElementById('nombre_acu').value = '';
                    document.getElementById('apellido_acu').value = '';
                    document.getElementById('email_acu').value = '';
                    document.getElementById('telefono_acu').value = '';
                });
        }
    </script>
</html>