<?php
    session_start();
    require_once('../../database/conex.php');
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {;
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
                            showModal('Formato de imagen no válido.', 'error');
                        });
                    </script>";
                exit;
            }
            if (!move_uploaded_file($fileTmp, $newruta)) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al subir la imagen.', 'error');
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
                                    showModal('El director se actualizó exitosamente, se ha sido activado y se le ha enviado un correo de notificación.', 'success');
                                    setTimeout(() => {
                                        window.location = '../directores.php';
                                    }, 3000);
                                });
                            </script>";
                    } 
                    else {
                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    showModal('El director se actualizó exitosamente, se ha sido activado, pero hubo un error al enviar el correo.', 'error');
                                    setTimeout(() => {
                                        window.location = '../directores.php';
                                    }, 3000);
                                });
                            </script>";
                    }
                }
            } 
            else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al actualizar a la nueva escuela del director.', 'error');
                        });
                    </script>";
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al actualizar el director.', 'error');
                        });
                </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #28a745;
            --danger-color: #dc3545;
            --secondary-color: #6c757d;
            --text-color: #333;
            --border-color: #ddd;
            --shadow: 0 2px 4px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
            --background-color: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            margin-top: 100px;
            padding: 1rem;
            box-shadow: var(--card-shadow);
            transition: transform var(--transition-speed);
            overflow: hidden;
            background-color: #fff;
            border-radius: 10px;
        }
        .form-title {
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .form {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .x_grupo {
            margin-bottom: 20px;
            text-align: left;
        }
        .x_grupo label {
            font-weight: 600;
            color: #77b885;
            margin-bottom: 6px;
            display: block;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
        .x_input {
            position: relative;
            width: 100%;
        }
        .x_input input, .x_input select {
            width: 100%;
            height: 44px;
            padding: 0 40px 0 14px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: #f7fafc;
            font-size: 1rem;
            color: #333;
            outline: none;
            transition: border 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .x_input input:focus, .x_input select:focus {
            border-color: #77b885;
            box-shadow: 0 0 0 2px #8dc2bf33;
            background: #f0fdfb;
        }
        .form_estado {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            pointer-events: none;
        }
        .x_typerror {
            display: none;
        }
        .x_typerror-block {
            color: #bb2929;
            font-size: 0.95rem;
            margin-top: 4px;
            display: block;
        }
        .x_grupo-incorrecto .x_input input, .x_grupo-incorrecto .x_input select {
            border: 2px solid #bb2929;
            background: #fff0f0;
        }
        .x_grupo-correcto .x_input input, .x_grupo-correcto .x_input select {
            border: 2px solid #1ed12d;
            background: #f0fff0;
        }
        .x_grupo-incorrecto .form_estado {
            color: #bb2929;
        }
        .x_grupo-correcto .form_estado {
            color: #1ed12d;
        }
        .form1-buttons {
            display: flex;
            gap: 12px;
            margin-top: 10px;
            justify-content: center;
            align-items: center;
        }
        button {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }
        button:hover {
            filter: brightness(0.95);
            transform: translateY(-2px) scale(1.03);
        }
        .btn-success {
            background-color: #77b885;
            color: white;
        }
        .btn-success:hover {
            background-color: #5a8b66;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 30px;
            border: 1px solid #888;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        .status-icon {
            margin: 0 auto 20px;
            display: block;
            width: 50px;
            height: 50px;
            vertical-align: middle;
        }
        .status-icon circle {
            fill: none;
        }
        .status-icon path {
            fill: none;
        }
        #check-svg, #x-svg, #loading-svg {
            display: none;
        }
        #check-svg.show, #x-svg.show, #loading-svg.show {
            display: block !important;
        }
        .modal-content p {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .modal-content button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .modal-content button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        @media (max-width: 600px) {
            .container-main {
                padding: 5%;
            }     
            .form {
                grid-template-columns: repeat(1, 1fr);
            }
            .form1-buttons {
                flex-direction: column;
                width: 100%;
            }       
            .form1-buttons button {
                width: 100%;
            }
            .title2 {
                font-size: 1.5rem;
            }       
            .subtitle {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <main class="container-main">
        <div class="form-container">
            <h2 class="form-title">Actualizar Director</h2>
            <form id="form" class="form" method="POST" action="" enctype="multipart/form-data">
                <div class="x_grupo">
                    <label for="documento">Documento</label>
                    <div class="x_input">
                        <input type="number" id="documento" name="documento" value="<?php echo $usuarios['documento']; ?>" readonly>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="x_grupo">
                    <label for="nombre">Nombre</label>
                    <div class="x_input">
                        <input type="text" id="nombre" name="nombre" value="<?php echo $usuarios['nombre']; ?>" readonly>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="x_grupo">
                    <label for="apellido">Apellido</label>
                    <div class="x_input">
                        <input type="text" id="apellido" name="apellido" value="<?php echo $usuarios['apellido']; ?>" readonly>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="x_grupo">
                    <label for="email">Correo</label>
                    <div class="x_input">
                        <input type="email" id="email" name="email" value="<?php echo $usuarios['email']; ?>" readonly>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="x_grupo" id="x_telefono">
                    <label for="telefono">Teléfono</label>
                    <div class="x_input">
                        <input type="number" id="telefono" name="telefono" value="<?php echo $usuarios['telefono']; ?>">
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Teléfono inválido, debe ser un número de 10 dígitos, ejemplo: 3178901234.</p>
                </div>
                <div class="x_grupo">
                    <label for="id_rol">Rol</label>
                    <div class="x_input">
                        <select id="id_rol" name="id_rol">
                            <option value="<?= $usuarios['id_rol']; ?>"><?= $usuarios['rol']; ?></option>
                            <?php
                                $sqlRoles = $con->prepare("SELECT * FROM roles WHERE id_rol != $usuarios[id_rol] ORDER BY id_rol ASC");
                                $sqlRoles->execute();
                                while ($row = $sqlRoles->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['id_rol']}'>{$row['rol']}</option>";
                                }
                            ?>
                        </select>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="x_grupo">
                    <label for="id_estado">Estado</label>
                    <div class="x_input">
                        <select id="id_estado" name="id_estado">
                            <option value="<?= $usuarios['id_estado']; ?>"><?= $usuarios['estado']; ?></option>
                            <?php
                                $sqlEstados = $con->prepare("SELECT * FROM estados WHERE id_estado != $usuarios[id_estado] ORDER BY id_estado ASC");
                                $sqlEstados->execute();
                                while ($row = $sqlEstados->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['id_estado']}'>{$row['estado']}</option>";
                                }
                            ?>
                        </select>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="x_grupo">
                    <label for="id_escuela">Escuela</label>
                    <div class="x_input">
                        <select id="id_escuela" name="id_escuela">
                            <option value="<?= $usuarios['id_escuela']; ?>"><?= $usuarios['nombre_escuela']; ?></option>
                            <?php
                                $sqlEscuelas = $con->prepare("SELECT * FROM escuelas WHERE id_escuela != $usuarios[id_escuela] ORDER BY nombre_escuela ASC");
                                $sqlEscuelas->execute();
                                while ($row = $sqlEscuelas->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$row['id_escuela']}'>{$row['nombre_escuela']}</option>";
                                }
                            ?>
                        </select>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                </div>
                <div class="x_grupo">
                    <label for="imagen">Imagen</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>
                <div class="form1-buttons">
                    <button onclick="window.location.href='../directores.php'" class="btn btn-secondary" type="button"><i class="fa-solid fa-arrow-left"></i> Volver</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
        <div id="msgModal" class="modal">
            <div class="modal-content">
                <svg id="check-svg" class="status-icon" viewBox="0 0 52 52"><circle cx="26" cy="26" r="25" fill="none"/><path d="M14 27l7 7 16-16" fill="none" stroke="#28a745" stroke-width="4"/></svg>
                <svg id="x-svg" class="status-icon" viewBox="0 0 52 52"><circle cx="26" cy="26" r="25" fill="none"/><path d="M16 16l20 20M36 16L16 36" fill="none" stroke="#dc3545" stroke-width="4"/></svg>
                <svg id="loading-svg" class="status-icon" viewBox="0 0 50 50"><circle cx="25" cy="25" r="20" fill="none" stroke="#007bff" stroke-width="5" stroke-dasharray="31.4 31.4" transform="rotate(-90 25 25)"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/></circle></svg>
                <p id="Message"></p>
                <button onclick="closeModal()">Cerrar</button>
            </div>
        </div>
    </main>
    <script>
    const msgModal = document.getElementById('msgModal');
    const message = document.getElementById('Message');
    const checkSvg = document.getElementById('check-svg');
    const xSvg = document.getElementById('x-svg');
    const loadingSvg = document.getElementById('loading-svg');

    function showModal(msg, type) {
        checkSvg.classList.remove('show');
        xSvg.classList.remove('show');
        loadingSvg.classList.remove('show');
        if (type === 'success') {
            checkSvg.classList.add('show');
        } else if (type === 'error') {
            xSvg.classList.add('show');
        } else if (type === 'loading') {
            loadingSvg.classList.add('show');
        }
        message.textContent = msg;
        msgModal.style.display = 'flex';
    }
    function closeModal() {
        msgModal.style.display = 'none';
    }

    document.getElementById('form').addEventListener('submit', function(e) {
        // Mostrar modal de carga
        showModal('Procesando actualización...', 'loading');
    });
    // Validación en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#form input, #form select');
        inputs.forEach((input) => {
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        });
    });
    </script>
    <script src="../../validate/validar.js"></script>
</body>
</html>