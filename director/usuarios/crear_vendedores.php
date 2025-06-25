<?php
    session_start();
    require_once('../../database/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios 
    INNER JOIN detalles_usuarios_escuela 
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    function generatePassword() {
        $minusculas = 'abcdefghijklmnopqrstuvwxyz';
        $mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeros = '0123456789';
        $especiales = '#_-+';

        $todosCaracteres = $minusculas . $mayusculas . $numeros . $especiales;

        $contrasena = $minusculas[rand(0, strlen($minusculas) - 1)];
        $contrasena .= $mayusculas[rand(0, strlen($mayusculas) - 1)];
        $contrasena .= $numeros[rand(0, strlen($numeros) - 1)];
        $contrasena .= $especiales[rand(0, strlen($especiales) - 1)];

        for ($i = strlen($contrasena); $i < 8; $i++) {
            $contrasena .= $todosCaracteres[rand(0, strlen($todosCaracteres) - 1)];
        }

        return $contrasena;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre']; 
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $contrasena_original = generatePassword();
        $password = password_hash($contrasena_original, PASSWORD_DEFAULT);
        $id_escuela = $u['id_escuela'];

        // Validar documento
        $sqlDocumento = $con->prepare("SELECT documento FROM usuarios WHERE documento = ?");
        $sqlDocumento->execute([$documento]);
        if ($sqlDocumento->fetch(PDO::FETCH_ASSOC)) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('El documento ya existe, por favor ingrese otro documento.', 'error');
                    });
                </script>";
            exit;
        }

        // Validar correo
        $sqlEmail = $con->prepare("SELECT email FROM usuarios WHERE email = ?");
        $sqlEmail->execute([$email]);
        if ($sqlEmail->fetch(PDO::FETCH_ASSOC)) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('El correo ya existe, por favor ingrese otro correo.', 'error');
                    });
                </script>";
            exit;
        }

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
        }
        else {
            $fileName = 'default.png';
        }

        $sqlInsertVendedor = $con->prepare("INSERT INTO usuarios (documento, nombre, apellido, email, telefono, password, imagen, id_rol, id_estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($sqlInsertVendedor->execute([$documento, $nombre, $apellido, $email, $telefono, $password, $fileName, 3, 2])) {
            $sqlInsertDetails = $con->prepare("INSERT INTO detalles_usuarios_escuela (documento, id_escuela) VALUES (?, ?)");
            if ($sqlInsertDetails->execute([$documento, $id_escuela])) {
                $sqlEmailPassword = $con->prepare("SELECT email, nombre, apellido, documento FROM usuarios WHERE documento = ?");
                $sqlEmailPassword->execute([$documento]);
                $email = $sqlEmailPassword->fetch(PDO::FETCH_ASSOC);

                require_once '../../libraries/PHPMailer-master/config/email_password.php';
                if (email_password($email['email'], $email['nombre'], $email['apellido'], $email['documento'], $contrasena_original)) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El vendedor se ha creado exitosamente, se le ha enviado un correo de notificación.', 'success');
                                setTimeout(() => {
                                    window.location = '../usuarios.php';
                                }, 3000);
                            });
                        </script>";
                } 
                else {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El vendedor se ha creado exitosamente, pero hubo un error al enviar el correo.', 'error');
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
                            showModal('Error al asignar la escuela al vendedor.', 'error');
                        });
                    </script>";
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al registrar al vendedor.', 'error');
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
    <title>Vendedores</title>
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
        .x_input input {
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
        .x_input input:focus {
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
        .x_grupo-incorrecto .x_input input {
            border: 2px solid #bb2929;
            background: #fff0f0;
        }
        .x_grupo-correcto .x_input input {
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
            <h2 class="form-title">Crear Vendedor</h2>
            <form id="form" class="form" method="POST" action="" enctype="multipart/form-data">
                <div class="x_grupo" id="x_documento">
                    <label for="documento">Documento</label>
                    <div class="x_input">
                        <input type="number" id="documento" name="documento" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Documento inválido, debe ser un número de 10 dígitos.</p>
                </div>
                <div class="x_grupo" id="x_nombre">
                    <label for="nombre">Nombres</label>
                    <div class="x_input">
                        <input type="text" id="nombre" name="nombre" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Nombre inválido, debe ser un texto, ejemplo: Juan.</p>
                </div>
                <div class="x_grupo" id="x_apellido">
                    <label for="apellido">Apellidos</label>
                    <div class="x_input">
                        <input type="text" id="apellido" name="apellido" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Apellido inválido, debe ser un texto, ejemplo: Perez.</p>
                </div>
                <div class="x_grupo" id="x_email">
                    <label for="email">Correo</label>
                    <div class="x_input">
                        <input type="email" id="email" name="email" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Correo inválido, debe ser un correo electrónico, ejemplo: ejemplo@gmail.com.</p>
                </div>
                <div class="x_grupo" id="x_telefono">
                    <label for="telefono">Teléfono</label>
                    <div class="x_input">
                        <input type="number" id="telefono" name="telefono" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Teléfono inválido, debe ser un número de 10 dígitos, ejemplo: 3178901234.</p>
                </div>
                <div class="x_grupo">
                    <label for="imagen">Imagen</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>
                <div class="form1-buttons">
                    <button onclick="window.location.href='../usuarios.php'" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Volver</button>
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
    document.getElementById('form').addEventListener('submit', function(e) {
        // Mostrar modal de carga
        showModal('Procesando actualización...', 'loading');
    });

    // Asegurarse de que los eventos de validación se apliquen a todos los inputs
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#form input, #form select');
        inputs.forEach((input) => {
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        });
    });
</script>
</body>
<script src="../../validate/validar.js"></script>    
</html>