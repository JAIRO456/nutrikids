<?php
    session_start();
    require_once('../../conex/conex.php');
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre']; 
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $password = password_hash(rand(1000, 9999), PASSWORD_DEFAULT);
        $id_escuela = $u['id_escuela'];

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

        $sqlInsertDirector = $con->prepare("INSERT INTO usuarios (documento, nombre, apellido, email, telefono, password, imagen, id_rol, id_estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($sqlInsertDirector->execute([$documento, $nombre, $apellido, $email, $telefono, $password, $fileName, 3, 2])) {
            $sqlInsertDetails = $con->prepare("INSERT INTO detalles_usuarios_escuela (documento, id_escuela) VALUES (?, ?)");
            $sqlInsertDetails = $con->prepare("INSERT INTO detalles_usuarios_escuela (documento, id_escuela) VALUES (?, ?)");
            if ($sqlInsertDetails->execute([$documento, $id_escuela])) {
                $sqlEmailPassword = $con->prepare("SELECT email, nombre, apellido, documento, password FROM usuarios WHERE documento = ?");
                $sqlEmailPassword->execute([$documento]);
                $email = $sqlEmailPassword->fetch(PDO::FETCH_ASSOC);

                require_once '../../libraries/PHPMailer-master/config/email_password.php';
                if (email_password($email['email'], $email['nombre'], $email['apellido'], $email['documento'], $password_code)) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El Vendedor se creado exitosamente, se le ha enviado un correo de notificación.');
                                setTimeout(() => {
                                    window.location = '../directores.php';
                                }, 3000);
                            });
                        </script>";
                    // echo '<script>alert("El director ha sido activado y se le ha enviado un correo de notificación");</script>';
                } 
                else {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El Vendedor se creado exitosamente, pero hubo un error al enviar el correo.');
                            });
                        </script>";
                    // echo '<script>alert("El director se creado exitosamente, pero hubo un error al enviar el correo");</script>';
                }

                // echo '<script>window.location.href="../directores.php"</script>';
            }
            else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al asignar la escuela al Vendedor.');
                    });
                </script>";
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al registrar al Vendedor.');
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
    <title>Directores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Agregar Nuevo Vendedor</h2>
                    <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento</label>
                            <input type="number" class="form-control" id="documento" name="documento" required>
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
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Crear Vendedor</button>
                            <a href="../agregar.php" class="btn btn-secondary">Cancelar</a>
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
    
    function email_password(email, nombre, apellido, documento, password_code) {
        fetch('../../PHPMailer-master/config/email_password.php', {
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