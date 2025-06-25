<?php
    session_start();
    require_once('../database/conex.php');
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
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
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

        $sqlUpdate = $con->prepare("UPDATE usuarios SET email = ?, telefono = ?, imagen = ? WHERE documento = ?");
        if ($sqlUpdate->execute([$email, $telefono, $fileName, $doc])) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Información actualizada correctamente.', 'success');
                        setTimeout(() => {
                            window.location = 'cuenta.php';
                        }, 2000);
                    });
                </script>";
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al actualizar la información.', 'error');
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
    <title>Mi Cuenta</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }

        .account-container {
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin: 20px auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-header h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .section-header p {
            color: #6c757d;
            font-size: 16px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e9ecef;
            margin: 0 auto 20px;
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
            color: #2c3e50;
            background-color: #f8f9fa;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            background-color: white;
        }

        .form-group input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .file-input {
            text-align: center;
            margin-bottom: 20px;
        }

        .file-input input[type="file"] {
            max-width: 300px;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-md-6 {
            flex: 1;
            min-width: 300px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-warning {
            background-color: #ffc107;
            color: #2c3e50;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
        }

        hr {
            border: 0;
            border-top: 1px solid #e9ecef;
            margin: 30px 0;
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

        /* Asegurar que los SVGs se muestren correctamente */
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

        @media (max-width: 768px) {
            .account-container {
                padding: 20px;
            }

            .col-md-6 {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="account-container">
        <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
            <div class="section-header">
                <h1>Mi Cuenta</h1>
                <p>Actualiza tu información personal</p>
                <img src="../img/users/<?= $usuarios['imagen']; ?>" alt="<?= $usuarios['nombre']; ?>" class="profile-img">
                <div class="file-input">
                    <input type="file" name="imagen" id="imagen" accept="image/*">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="documento">Documento</label>
                        <input type="number" id="documento" name="documento" value="<?= $usuarios['documento']; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombres</label>
                        <input type="text" id="nombre" name="nombre" value="<?= $usuarios['nombre']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="apellido">Apellidos</label>
                        <input type="text" id="apellido" name="apellido" value="<?= $usuarios['apellido']; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Correo</label>
                        <input type="email" id="email" name="email" value="<?= $usuarios['email']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="number" id="telefono" name="telefono" value="<?= $usuarios['telefono']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_rol">Rol</label>
                        <input type="text" id="id_rol" name="id_rol" value="<?= $usuarios['rol']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>

            <hr>

            <div class="section-header">
                <h2>Información de la Escuela</h2>
                <p>Aquí puedes ver la información de tu escuela</p>
                <img src="../img/schools/<?= $usuarios['imagen_esc']; ?>" alt="<?= $usuarios['nombre_escuela']; ?>" class="profile-img">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre_escuela">Nombre de la Escuela</label>
                        <input type="text" id="nombre_escuela" name="nombre_escuela" value="<?= $usuarios['nombre_escuela']; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email_esc">Correo de la Escuela</label>
                        <input type="email" id="email_esc" name="email_esc" value="<?= $usuarios['email_esc']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono_escuela">Teléfono de la Escuela</label>
                        <input type="number" id="telefono_escuela" name="telefono_escuela" value="<?= $usuarios['telefono_esc']; ?>" readonly>
                    </div>
                </div>
            </div>

            <hr>

            <div class="section-header">
                <h2>Información de la Licencia</h2>
                <p>Aquí puedes ver la información de tu licencia</p>
            </div>
            <?php
                $sqlLicencia = $con->prepare("SELECT * FROM licencias WHERE id_escuela = ?");
                $sqlLicencia->execute([$usuarios['id_escuela']]);
                $licencia = $sqlLicencia->fetch();
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= $licencia['fecha_inicio']; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_fin">Fecha de Fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" value="<?= $licencia['fecha_fin']; ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button id="license-btn" class="btn btn-warning">Renovar</button>
            </div>
        </form>
        <div id="msgModal" class="modal">
            <div class="modal-content">
                <!-- SVG Check -->
                <svg id="check-svg" class="status-icon" style="display: none;" width="50" height="50" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#28a745" stroke-width="3"/>
                    <path d="M15 25 L22 32 L35 18" fill="none" stroke="#28a745" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                <!-- SVG X -->
                <svg id="x-svg" class="status-icon" style="display: none;" width="50" height="50" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#dc3545" stroke-width="3"/>
                    <path d="M18 18 L32 32 M32 18 L18 32" fill="none" stroke="#dc3545" stroke-width="3" stroke-linecap="round"/>
                </svg>

                <!-- SVG Loading -->
                <svg id="loading-svg" class="status-icon" style="display: none;" width="50" height="50" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#007bff" stroke-width="3" stroke-linecap="round" stroke-dasharray="31.4 125.6">
                        <animateTransform attributeName="transform" type="rotate" values="0 25 25;360 25 25" dur="1s" repeatCount="indefinite"/>
                    </circle>
                </svg>
                <p id="Message"></p>
                <button onclick="closeModal()">Cerrar</button>
            </div>
        </div>
    </main>
</body>
<script>
    const msgModal = document.getElementById('msgModal');
    const message = document.getElementById('Message');
    const checkSvg = document.getElementById('check-svg');
    const xSvg = document.getElementById('x-svg');
    const loadingSvg = document.getElementById('loading-svg');

    function showModal(msg, type) {
        // Remover todas las clases show primero
        checkSvg.classList.remove('show');
        xSvg.classList.remove('show');
        loadingSvg.classList.remove('show');
        
        // Agregar la clase show al SVG correspondiente según el tipo
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

    // Manejar el envío del formulario con loading
    document.getElementById('formCreateAdmin').addEventListener('submit', function(e) {
        // Mostrar modal de carga
        showModal('Procesando actualización...', 'loading');
    });

    // Actualizar la licencias dependiendo del id_escuela
    document.getElementById('license-btn').addEventListener('click', function(e) {
        e.preventDefault();
        const idEscuela = <?= $usuarios['id_escuela']; ?>;
        
        // Mostrar modal de carga
        showModal('Procesando renovación de licencia...', 'loading');
        
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
                showModal(data.message, 'success');
                setTimeout(() => {
                    location.reload(); // Recargar la página para ver los cambios
                }, 2000);
            } 
            else {
                showModal(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Error al procesar la renovación de licencia.', 'error');
        });
    });
</script>
</html>
