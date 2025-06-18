<?php
    session_start();
    require_once('../../database/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    $id_escuela = $_GET['id'];
    $sqlescuelas = $con -> prepare("SELECT * FROM escuelas WHERE id_escuela = ?");
    $sqlescuelas -> execute([$id_escuela]);
    $escuelas = $sqlescuelas -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_escuela = $_POST['nombre_escuela'];
        $telefono = $_POST['telefono_esc'];
        $email = $_POST['email_esc'];
        $fileName = $escuelas['imagen_esc'];

        // Si se sube una imagen nueva
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $fileTmp = $_FILES['imagen']['tmp_name'];
            $fileName = str_replace(' ', '_', $_FILES['imagen']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $formatType = array("jpg", "jpeg", "png");
            $ruta = '../../img/schools/';
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
            if ($escuelas['imagen_esc'] && $escuelas['imagen_esc'] != 'default.png') {
                $oldImagePath = $ruta . $escuelas['imagen_esc'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $sqlUpdate = $con->prepare("UPDATE escuelas SET nombre_escuela = ?, telefono_esc = ?, email_esc = ?, imagen_esc = ? WHERE id_escuela = ?");
        if ($sqlUpdate->execute([$nombre_escuela, $telefono, $email, $fileName, $id_escuela])) {
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
    <title>Actualizar Escuela</title>
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

        .form-field {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 500;
        }

        input, select {
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

        .img-thumbnail {
            max-width: 200px;
            border-radius: 5px;
            box-shadow: var(--shadow);
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
<body>
    <main class="container-main">
        <div class="form-container">
            <h2 class="form-title">Actualizar Escuela</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-field">
                        <label for="nombre_escuela">Nombre de la Escuela</label>
                        <input type="text" id="nombre_escuela" name="nombre_escuela" value="<?php echo $escuelas['nombre_escuela']; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="email_esc">Correo Electrónico</label>
                        <input type="email" id="email_esc" name="email_esc" value="<?php echo $escuelas['email_esc']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-field">
                        <label for="telefono_esc">Teléfono</label>
                        <input type="number" id="telefono_esc" name="telefono_esc" value="<?php echo $escuelas['telefono_esc']; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="imagen">Imagen</label>
                        <input type="file" id="imagen" name="imagen">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-field">
                        <label for="imagen_actual">Imagen Actual</label>
                        <img src="../../img/schools/<?= $escuelas['imagen_esc']; ?>" alt="<?= $escuelas['nombre_escuela']; ?>" class="img-thumbnail">
                    </div>
                </div>
                <div class="button-group">
                    <a href="../escuelas.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
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