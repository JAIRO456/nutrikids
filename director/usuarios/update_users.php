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
        $telefono = $_POST['telefono'];
        $id_rol = $_POST['id_rol'];
        $id_estado = $_POST['id_estado'];
        $estado_old = $usuarios['id_estado'];
        $fileName = $usuarios['imagen'];

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

        $sqlUpdate = $con->prepare("UPDATE usuarios SET telefono = ?, imagen = ?, id_rol = ?, id_estado = ? WHERE documento = ?");
        if ($sqlUpdate->execute([$telefono, $fileName, $id_rol, $id_estado, $usuario_id])) {
            if ($estado_old != $id_estado && $id_estado == 1) {
                $sqlEmail = $con->prepare("SELECT email, nombre, apellido FROM usuarios WHERE documento = ?");
                $sqlEmail->execute([$usuario_id]);
                $email = $sqlEmail->fetch(PDO::FETCH_ASSOC);

                require_once '../../libraries/PHPMailer-master/config/email_estado.php';
                if (email_estado($email['email'], $email['nombre'], $email['apellido'])) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El usuario se ha actualizado exitosamente, se ha sido activado y se le ha enviado un correo de notificación.');
                                setTimeout(() => {
                                    window.location = '../usuarios.php';
                                }, 3000);
                            });
                        </script>";
                } 
                else {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El usuario se ha actualizado exitosamente, se ha sido activado, pero hubo un error al enviar el correo.');
                                setTimeout(() => {
                                    window.location = '../usuarios.php';
                                }, 3000);
                            });
                        </script>";
                }
            } 
            else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('El usuario se ha actualizado exitosamente.');
                            setTimeout(() => {
                                window.location = '../usuarios.php';
                            }, 3000);
                        });
                    </script>";
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al actualizar el usuario.');
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
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --primary-color: #28a745;
            --danger-color: #dc3545;
            --secondary-color: #6c757d;
            --text-color: #333;
            --border-color: #ddd;
            --shadow: 0 2px 4px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f8f9fa;
        }

        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            animation: fadeIn 0.5s ease-in;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            margin-top: 20px;
        }

        .form-title {
            text-align: center;
            color: var(--text-color);
            margin-bottom: 30px;
            font-size: 2em;
            animation: slideDown 0.5s ease-out;
        }

        .form-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .x_grupo {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            transition: var(--transition);
        }

        input:focus, select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
        }

        input[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-success {
            background-color: var(--primary-color);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

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
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            width: 350px;
            animation: scaleIn 0.3s ease;
        }

        .modal button {
            padding: 10px 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: var(--transition);
        }

        .modal button:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        .x_input {
            position: relative;
            width: 100%;
            height: 40px;
        }

        .x_grupo .form_estado {
            position: absolute;
            right: 20px;
            transform: translate(10px, 10px);
        }

        .x_grupo-correcto .form_estado {
            color: #1ed12d;
        }

        .x_grupo-incorrecto .form_estado {
            color: #bb2929;
        }

        .x_grupo-correcto .x_input {
            border: 3px solid #1ed12d;
        }

        .x_grupo-incorrecto .x_input {
            border: 3px solid #bb2929;
        }

        .bi-check-circle-fill {
            color: #1ed12d;
        }

        .bi-exclamation-circle-fill {
            color: #bb2929;
        }

        .x_error-block {
            display: block;
            color: red;
            font-size: 14px;
        }

        .x_typerror {
            display: none;
        }

        .x_typerror-block {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .form-group {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
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
                                <input type="text" class="form-control" id="documento" name="documento" value="<?php echo $usuarios['documento']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombres</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuarios['nombre']; ?>" readonly>
                            </div>    
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuarios['apellido']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <div class="x_input">
                                    <input type="number" id="telefono" name="telefono" value="<?php echo $usuarios['telefono']; ?>" required>
                                    <i class="form_estado fa fa-exclamation-circle"></i>
                                </div>
                                <p class="x_typerror">Teléfono inválido, debe ser un número de 10 dígitos, ejemplo: 3178901234.</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <div class="x_input">
                                    <input type="email" id="email" name="email" value="<?php echo $usuarios['email']; ?>" required>
                                    <i class="form_estado fa fa-exclamation-circle"></i>
                                </div>
                                <p class="x_typerror">Correo inválido, debe ser un correo electrónico, ejemplo: ejemplo@gmail.com.</p>
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_rol" class="form-label">Rol</label>
                                <select class="form-select" id="id_rol" name="id_rol" required>
                                    <option value="<?php echo $usuarios['id_rol']; ?>"><?php echo $usuarios['rol']; ?></option>
                                    <?php
                                        $sqlRoles = $con->prepare("SELECT * FROM roles WHERE id_rol > 2 ORDER BY id_rol ASC");
                                        $sqlRoles->execute();
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
                                    <option value="<?php echo $usuarios['id_estado']; ?>"><?php echo $usuarios['estado']; ?></option>
                                    <?php
                                        $sqlEstados = $con->prepare("SELECT * FROM estados WHERE id_estado != $usuarios[id_estado] ORDER BY id_estado ASC");
                                        $sqlEstados->execute();
                                        $estados = $sqlEstados->fetchAll();
                                        foreach ($estados as $estado) {
                                            echo "<option value='{$estado['id_estado']}'>{$estado['estado']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="button-group">
                            <a href="../usuarios.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Guardar</button>
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