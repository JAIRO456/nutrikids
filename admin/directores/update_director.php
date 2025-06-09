<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    $usuario_id = $_GET['id'];
    $sqlUsuarios = $con -> prepare("SELECT * FROM usuarios
    INNER JOIN roles ON usuarios.id_rol = roles.id_rol 
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");
    $sqlUsuarios -> execute([$usuario_id]);
    $usuarios = $sqlUsuarios -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $imagen = $_FILES['imagen']['name'];
        $telefono = $_POST['telefono'];
        $id_rol = $_POST['id_rol'];
        $id_estado = $_POST['id_estado'];
        $estado_old = $usuarios['id_estado'];
        $fileName = $usuarios['imagen'];
        $id_escuela = $_POST['id_escuela'];

        // Si se sube una imagen nueva
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $fileTmp = $_FILES['imagen']['tmp_name'];
            $fileName = str_replace(' ', '_', $_FILES['imagen']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $formatType = array("jpg", "jpeg", "png");
            $ruta = '../../img/users/';
            $newruta = $ruta . basename($fileName);

            if (!in_array($fileExtension, $formatType)) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Formato de imagen no válido.');
                        });
                    </script>";
                exit;
            }
            if (!move_uploaded_file($fileTmp, $newruta)) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al subir la imagen.');
                        });
                    </script>";
                exit;
            }
            // Eliminar la imagen anterior si no es la predeterminada
            if ($usuarios['imagen'] && $usuarios['imagen'] != 'default.png') {
                $oldImagePath = $ruta . $usuarios['imagen'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $estado_old = $usuarios['id_estado'];

        $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ?, imagen = ?, id_rol = ?, id_estado = ? WHERE documento = ?");
        if ($sqlUpdate->execute([$telefono, $fileName, $id_rol, $id_estado, $usuario_id])) {
            $sqlUpdateDetails = $con->prepare("UPDATE detalles_usuarios_escuela SET id_escuela = ? WHERE documento = ?");
            if ($sqlUpdateDetails->execute([$id_escuela, $usuario_id])) {
                if ($estado_old != $id_estado && $id_estado == 1) {
                    $sqlEmail = $con->prepare("SELECT email, nombre, apellido FROM usuarios WHERE documento = ?");
                    $sqlEmail->execute([$usuario_id]);
                    $email = $sqlEmail->fetch(PDO::FETCH_ASSOC);

                    require_once '../../libraries/PHPMailer-master/config/email_estado.php';
                    if (email_estado($email['email'], $email['nombre'], $email['apellido'])) {
                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    showModal('El director se actualizo exitosamente, se ha sido activado y se le ha enviado un correo de notificación.');
                                });
                            </script>";
                        // echo '<script>alert("El director ha sido activado y se le ha enviado un correo de notificación");</script>';
                    } 
                    else {
                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    showModal('El director se actualizo exitosamente, se ha sido activado, pero hubo un error al enviar el correo.');
                                });
                            </script>";
                        // echo '<script>alert("El director ha sido activado, pero hubo un error al enviar el correo");</script>';
                    }
                }

                // echo '<script>alert("Director actualizado correctamente")</script>';
                // echo '<script>window.location.href="../directores.php"</script>';
            } 
            else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al actualizar a la nueva escuela del director.');
                        });
                    </script>";
                // echo '<script>alert("Error al actualizar la escuela del director")</script>';
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al actualizar el director.');
                        });
                </script>";
            // echo '<script>alert("Error al actualizar el director")</script>';
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 300px;
        }
        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Actualizar Director</h2>
                    <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="number" class="form-control" id="documento" name="documento" value="<?php echo $usuarios['documento']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuarios['nombre']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuarios['apellido']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuarios['email']; ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $usuarios['telefono']; ?>">
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_estado" class="form-label">Estado</label>
                                <select class="form-select" id="id_estado" name="id_estado">
                                    <option value="<?= $usuarios['id_estado']; ?>"><?= $usuarios['estado']; ?></option>
                                    <?php
                                        $sqlEstados = $con->prepare("SELECT * FROM estados WHERE id_estado != $usuarios[id_estado] ORDER BY id_estado ASC");
                                        $sqlEstados->execute();
                                        while ($row = $sqlEstados->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_estado']}'>{$row['estado']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_escuela" class="form-label">Escuela</label>
                                <select class="form-select" id="id_escuela" name="id_escuela">
                                    <option value="<?= $usuarios['id_escuela']; ?>"><?= $usuarios['nombre_escuela']; ?></option>
                                    <?php
                                        $sqlEscuelas = $con->prepare("SELECT * FROM escuelas WHERE id_escuela != $usuarios[id_escuela] ORDER BY nombre_escuela ASC");
                                        $sqlEscuelas->execute();
                                        while ($row = $sqlEscuelas->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_escuela']}'>{$row['nombre_escuela']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                        </div>                  
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger">Actualizar Administrador</button>
                            <a href="../directores.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
            <div id="msgModal" class="modal">
                <div class="modal-content">
                    <p id="Message">
                        
                    </p>
                    <button onclick="closeModal()">Cerrar</button>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    <script>
        const msgModal = document.getElementById('msgModal');
        const message = document.getElementById('Message');

        function showModal(msg) {
            message.textContent = msg;
            msgModal.style.display = 'flex';
        }
        function closeModal() {
            msgModal.style.display = 'none';
        } 
        
        function email_estado(email, nombre, apellido) {
            fetch('../../libraries/PHPMailer-master/config/email_estado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, nombre, apellido })
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } 
                else {
                    throw new Error('Error en la solicitud');
                }
            })
        }
    </script>
</html>