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
                        showModal('El documento ya existe, por favor ingrese otro documento.');
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
                        showModal('El correo ya existe, por favor ingrese otro correo.');
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
                                showModal('El vendedor se ha creado exitosamente, se le ha enviado un correo de notificación.');
                                setTimeout(() => {
                                    window.location = '../usuarios.php';
                                }, 3000);
                            });
                        </script>";
                } 
                else {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El vendedor se ha creado exitosamente, pero hubo un error al enviar el correo.');
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
                            showModal('Error al asignar la escuela al vendedor.');
                        });
                    </script>";
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al registrar al vendedor.');
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
    background: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}
.modal.show {
    opacity: 1;
}
.modal-content {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    width: 350px;
    max-width: 90vw;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    transform: scale(0.7) translateY(-50px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 1px solid rgba(119, 184, 133, 0.2);
    position: relative;
    overflow: hidden;
}
.modal.show .modal-content {
    transform: scale(1) translateY(0);
    opacity: 1;
}
.modal-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #77b885, #5a9c6b, #77b885);
    background-size: 200% 100%;
    animation: gradientShift 3s ease-in-out infinite;
}
@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
.modal-content p {
    margin: 0 0 20px 0;
    font-size: 1.1rem;
    color: #333;
    line-height: 1.5;
    font-weight: 500;
    animation: fadeInUp 0.6s ease-out;
}
.modal-content button {
    margin-top: 15px;
    padding: 12px 30px;
    background: linear-gradient(135deg, #77b885 0%, #5a9c6b 100%);
    color: white;
    border: none;
    border-radius: 25px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(119, 184, 133, 0.3);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out 0.2s both;
}
.modal-content button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}
.modal-content button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(119, 184, 133, 0.4);
    background: linear-gradient(135deg, #5a9c6b 0%, #4a8a5a 100%);
}
.modal-content button:hover::before {
    left: 100%;
}
.modal-content button:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(119, 184, 133, 0.3);
}
/* Efecto de brillo en el borde superior */
.modal-content::after {
    content: '';
    position: absolute;
    top: 4px;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
    animation: shimmer 2s ease-in-out infinite;
}
@keyframes shimmer {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 1; }
}
/* Efecto de pulso para el botón cuando hay éxito */
.modal-content button.success {
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% {
        box-shadow: 0 4px 15px rgba(119, 184, 133, 0.3);
    }
    50% {
        box-shadow: 0 4px 25px rgba(119, 184, 133, 0.6);
    }
    100% {
        box-shadow: 0 4px 15px rgba(119, 184, 133, 0.3);
    }
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
<body>
    <main class="container-main">
        <div class="form-container">
            <h2 class="form-title">Crear Vendedor</h2>
            <form id="form" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="x_grupo" id="x_documento">
                        <label for="documento">Documento</label>
                        <div class="x_input">
                            <input type="number" id="documento" name="documento" required>
                            <i class="form_estado fa fa-exclamation-circle"></i>
                        </div>
                        <p class="x_typerror">Documento inválido, debe ser un número de 10 dígitos.</p>
                    </div>
                    <div class="x_grupo" id="x_nombre">
                        <label for="nombre">Nombre</label>
                        <div class="x_input">
                            <input type="text" id="nombre" name="nombre" required>
                            <i class="form_estado fa fa-exclamation-circle"></i>
                        </div>
                        <p class="x_typerror">Nombre inválido, debe ser un texto, ejemplo: Juan.</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="x_grupo" id="x_apellido">
                        <label for="apellido">Apellido</label>
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
                </div>
                <div class="form-group">
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
                </div>
                <div class="button-group">
                    <a href="../usuarios.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
        <div id="msgModal" class="modal">
            <div class="modal-content">
                <p id="Message"></p>
                <button onclick="closeModal()">Cerrar</button>
            </div>
        </div>
    </main>
</body>
<script src="../../validate/validar.js"></script>    
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

    // Asegurarse de que los eventos de validación se apliquen a todos los inputs
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#form input, #form select');
        inputs.forEach((input) => {
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        });
    });
</script>
</html>