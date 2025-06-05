<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento = $_POST['documento'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $password_code = rand(1000, 9999);
        $password = password_hash($password_code, PASSWORD_DEFAULT);
        $id_escuela = $_POST['escuela'];
        $imagen = $_FILES['imagen']['name'];
        $temp = $_FILES['imagen']['tmp_name'];

        if (!empty($imagen)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../../img/users/" . $imagen);
        } 
        else {
            $imagen = null;
        }

        $sqlInsertDirector = $con->prepare("INSERT INTO usuarios (documento, nombre, apellido, email, telefono, password, imagen, id_rol, id_estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($sqlInsertDirector->execute([$documento, $nombre, $apellido, $email, $telefono, $password, $imagen, 2, 2])) {
            $sqlInsertDetails = $con->prepare("INSERT INTO detalles_usuarios_escuela (documento, id_escuela) VALUES (?, ?)");
            if ($sqlInsertDetails->execute([$documento, $id_escuela])) {
                $sqlEmailPassword = $con->prepare("SELECT email, nombre, apellido, documento, password FROM usuarios WHERE documento = ?");
                $sqlEmailPassword->execute([$documento]);
                $email = $sqlEmailPassword->fetch(PDO::FETCH_ASSOC);

                require_once '../../libraries/PHPMailer-master/config/email_password.php';
                if (email_password($email['email'], $email['nombre'], $email['apellido'], $email['documento'], $password_code)) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El director se creado exitosamente, se le ha enviado un correo de notificación.');
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
                                showModal('El director se creado exitosamente, pero hubo un error al enviar el correo.');
                            });
                        </script>";
                    // echo '<script>alert("El director se creado exitosamente, pero hubo un error al enviar el correo");</script>';
                }

                // echo '<script>window.location.href="../directores.php"</script>';
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al registrar el director.');
                    });
                </script>";
            // echo '<script>alert("Error al registrar el director")</script>';
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
                    <h2 class="text-center">Crear Director</h2>
                    <form id="formCreateAdmin" method="POST" action="" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="number" class="form-control" id="documento" name="documento" required>
                            </div>     
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-md-6">
                                <label for="escuela" class="form-label">Escuela</label>
                                <select class="form-select" id="escuela" name="escuela" required>
                                    <option value="">Seleccione una escuela</option>
                                    <?php
                                        $sqlEscuelas = $con->prepare("SELECT * FROM escuelas");
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
                            <button type="submit" class="btn btn-danger">Registrar Director</button>
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