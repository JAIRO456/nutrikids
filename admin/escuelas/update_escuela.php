<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';


    $id_escuela = $_GET['id'];
    $sqlUsuarios = $con -> prepare("SELECT * FROM escuelas WHERE id_escuela = ?");
    $sqlUsuarios -> execute([$id_escuela]);
    $usuarios = $sqlUsuarios -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_escuela = $_POST['nombre_escuela'];
        $telefono = $_POST['telefono_esc'];
        $email = $_POST['email_esc'];
        $imagen = $_FILES['imagen']['name'];
        $temp = $_FILES['imagen']['tmp_name'];

        if (!empty($imagen)) {
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../../img/schools/" . $imagen);
        } 
        else {
            $imagen = $usuarios['imagen_esc'];
        }

        $sqlUpdate = $con->prepare("UPDATE escuelas SET nombre_escuela = ?, telefono_esc = ?, email_esc = ?, imagen_esc = ? WHERE id_escuela = ?");
        if ($sqlUpdate->execute([$nombre_escuela, $telefono, $email, $imagen, $id_escuela])) {
            echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Escuela actualizada exitosamente.');
                        });
                    </script>";
            // echo '<script>alert("Escuela actualizada exitosamente")</script>';
            // echo '<script>window.location = "../escuelas.php"</script>';
        } 
        else {
            echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al actualizar el Escuela.');
                        });
                    </script>";
            // echo '<script>alert("Error al actualizar la escuela")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <h2 class="text-center">Actualizar Escuela</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre_escuela" class="form-label">Nombre de la Escuela</label>
                            <input type="text" class="form-control" id="nombre_escuela" name="nombre_escuela" value="<?php echo $usuarios['nombre_escuela']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_esc" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email_esc" name="email_esc" value="<?php echo $usuarios['email_esc']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono_esc" class="form-label">Teléfono</label>
                            <input type="number" class="form-control" id="telefono_esc" name="telefono_esc" value="<?php echo $usuarios['telefono_esc']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen">
                        </div>
                        <div class="mb-3">
                            <label for="imagen_actual" class="form-label">Imagen Actual</label><br>
                            <img src="../../img/schools/<?= $usuarios['imagen_esc']; ?>" alt="<?= $usuarios['nombre_escuela']; ?>" class="img-thumbnail" width="200">
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger">Actualizar Escuela</button>
                            <a href="../escuelas.php" class="btn btn-secondary">Cancelar</a>
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
</html>