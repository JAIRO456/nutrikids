<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $id_tipo = $_POST['id_tipo'];
        $id_escuela = $_POST['id_escuela'];
        
        // Generar un ID único para la licencia, tendra numeros y letras, tendra 20 caracteres y cada 4 caracteres tendra un guion
        $id_licencia = bin2hex(random_bytes(10)); // Genera un ID de 20 caracteres hexadecimales
        $id_licencia = substr($id_licencia, 0, 4) . '-' . substr($id_licencia, 4, 4) . '-' . substr($id_licencia, 8, 4) . '-' . substr($id_licencia, 12, 4) . '-' . substr($id_licencia, 16, 4);

        $sqlInsert = $con->prepare("INSERT INTO licencias (id_licencia, fecha_inicio, fecha_fin, id_tipo, id_escuela) VALUES (?, ?, ?, ?, ?)");
        if ($sqlInsert->execute([$id_licencia, $fecha_inicio, $fecha_fin, $id_tipo, $id_escuela])) {
            echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Licencia creada exitosamente.');
                            setTimeout(() => {
                                window.location = '../licencias.php';
                            }, 3000);
                        });
                    </script>";
            // echo '<script>alert("Licencia registrada exitosamente")</script>';
            // echo '<script>window.location = "../licencias.php"</script>';
        } 
        else {
            echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al crear la licencia.');
                        });
                    </script>";
            // echo '<script>alert("Error al registrar la licencia")</script>';
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
                    <h2 class="text-center">Crear Licencia</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_tipo" class="form-label">Tipo de Licencia</label>
                            <select class="form-select" id="id_tipo" name="id_tipo" required>
                                <option value="">Seleccione un tipo de licencia</option>
                                <?php
                                    $sqlTipos = $con->prepare("SELECT * FROM tipo_licencia");
                                    $sqlTipos->execute();
                                    while ($tipo = $sqlTipos->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo['tipo'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_escuela" class="form-label">Escuela</label>
                            <select class="form-select" id="id_escuela" name="id_escuela" required>
                                <option value="">Seleccione una escuela</option>
                                <?php
                                    $sqlEscuelas = $con->prepare("SELECT * FROM escuelas");
                                    $sqlEscuelas->execute();
                                    while ($escuela = $sqlEscuelas->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $escuela['id_escuela'] . '">' . $escuela['nombre_escuela'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>             
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger">Registrar Licencia</button>
                            <a href="../licencias.php" class="btn btn-secondary">Cancelar</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
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