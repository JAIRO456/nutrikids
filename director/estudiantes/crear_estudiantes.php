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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento_est = $_POST['documento_est'];
        $nombre = $_POST['nombre']; 
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $documento_acudiente = $_POST['documento_acudiente'];
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

        $sqlInsertUser = $con->prepare("INSERT INTO estudiantes (documento_est, nombre, apellido, email, telefono, imagen, documento, id_estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($sqlInsertUser->execute([$documento_est, $nombre, $apellido, $email, $telefono, $fileName, $documento_acudiente, 2])) {
            $sqlInsertDetails = $con->prepare("INSERT INTO detalles_estudiantes_escuela (documento_est, id_escuela) VALUES (?, ?)");
            if ($sqlInsertDetails->execute([$documento_est, $id_escuela])) {
                echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('El Estudiante se creado exitosamente.');
                                setTimeout(() => {
                                    window.location = '../agregar.php';
                                }, 3000);
                            });
                        </script>";
            } 
            else {
                echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showModal('Error al crear al Estudiante.');
                            });
                        </script>";
            }
        } 
        else {
            echo '<script>alert("Error al crear al Estudiante, los datos son erroneos.")</script>';
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
    <style>
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
    </style>
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

                        <hr class="mb-4">
                        
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
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Registrar Estudiante</button>
                            <a href="agregar.php" class="btn btn-secondary">Cancelar</a>
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
</script>
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
            fetch(`../../ajax/get_acudientes.php?id_usuario=${encodeURIComponent(id_usuario)}`)
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