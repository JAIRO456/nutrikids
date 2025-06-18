<?php
    session_start();
    require_once('../../database/conex.php');
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
    <title>Licencias</title>
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
            <h2 class="form-title">Crear Licencia</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-field">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    <div class="form-field">
                        <label for="fecha_fin">Fecha Fin</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-field">
                        <label for="id_tipo">Tipo de Licencia</label>
                        <select id="id_tipo" name="id_tipo" required>
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
                    <div class="form-field">
                        <label for="id_escuela">Escuela</label>
                        <select id="id_escuela" name="id_escuela" required>
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
                </div>
                <div class="button-group">
                    <a href="../licencias.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
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