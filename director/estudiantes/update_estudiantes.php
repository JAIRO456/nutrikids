<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    $usuario_id = $_GET['id'];
    $sqlestudiantes = $con -> prepare("SELECT * FROM estudiantes  
    INNER JOIN estados ON estudiantes.id_estado = estados.id_estado
    INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
    INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela
    WHERE estudiantes.documento_est = ?");
    $sqlestudiantes -> execute([$usuario_id]);
    $estudiantes = $sqlestudiantes -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $telefono = $_POST['telefono'];
        $id_rol = $_POST['id_rol'];
        $id_estado = $_POST['id_estado'];
        $estado_old = $estudiantes['id_estado'];
        $fileName = $estudiantes['imagen'];

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
            if ($estudiantes['imagen'] && $estudiantes['imagen'] != 'default.png') {
                $oldImagePath = $ruta . $estudiantes['imagen'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        // Actualizar usuario (con o sin imagen nueva)
        $sqlUpdate = $con->prepare("UPDATE estudiantes SET telefono = ?, imagen = ?, id_rol = ?, id_estado = ? WHERE documento = ?");
        if ($sqlUpdate->execute([$telefono, $fileName, $id_rol, $id_estado, $usuario_id])) {
            if ($estado_old != $id_estado && $id_estado == 1) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded',function() {
                            showModal('El Estudiante se actualizóexitosamente.');
                        });
                    </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al actualizar el Estudiante.');
                    });
                </script>";
            }
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al actualizar el usuario, los campos son erroneos.');
                    });
                </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>estudiantes</title>
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
<body onload="document.form.documento.focus()">
    <main class="container-main">
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Actualizar Usuario</h2>
                    <form id="form" method="POST" action="" enctype="multipart/form-data">
                        <h3 class="mb-2">Información del Usuario</h3>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $estudiantes['documento']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $estudiantes['nombre']; ?>" readonly>
                            </div>    
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $estudiantes['apellido']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $estudiantes['telefono']; ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $estudiantes['email']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_rol" class="form-label">Rol</label>
                                <select class="form-select" id="id_rol" name="id_rol" required>
                                    <option value="<?php echo $estudiantes['id_rol']; ?>"><?php echo $estudiantes['rol']; ?></option>
                                    <?php
                                        $sqlRoles = $con->prepare("SELECT * FROM roles WHERE id_rol > 2 AND id_rol != ?");
                                        $sqlRoles->execute([$estudiantes['id_rol']]);
                                        $roles = $sqlRoles->fetchAll();
                                        foreach ($roles as $rol) {
                                            echo "<option value='{$rol['id_rol']}'>{$rol['rol']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_estado" class="form-label">Estado</label>
                                <select class="form-select" id="id_estado" name="id_estado" required>
                                    <option value="<?php echo $estudiantes['id_estado']; ?>"><?php echo $estudiantes['estado']; ?></option>
                                    <?php
                                        $sqlEstados = $con->prepare("SELECT * FROM estados WHERE id_estado != ?");
                                        $sqlEstados->execute([$estudiantes['id_estado']]);
                                        $estados = $sqlEstados->fetchAll();
                                        foreach ($estados as $estado) {
                                            echo "<option value='{$estado['id_estado']}'>{$estado['estado']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-danger mt-3">Actualizar Usuario</button>
                                <a href="../estudiantes.php" class="btn btn-secondary mt-3">Cancelar</a>
                            </div>
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