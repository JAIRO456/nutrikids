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
                            showModal('Licencia creada exitosamente.', 'success');
                            setTimeout(() => {
                                window.location = '../licencias.php';
                            }, 3000);
                        });
                    </script>";
        } 
        else {
            echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al crear la licencia.', 'error');
                        });
                    </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
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
        .x_input input, .x_input select {
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
        .x_input input:focus, .x_input select:focus {
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
        .x_grupo-incorrecto .x_input input, .x_grupo-incorrecto .x_input select {
            border: 2px solid #bb2929;
            background: #fff0f0;
        }
        .x_grupo-correcto .x_input input, .x_grupo-correcto .x_input select {
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
            <h2 class="form-title">Crear Licencia</h2>
            <form id="form" class="form" action="" method="POST" enctype="multipart/form-data">
                <div class="x_grupo" id="x_fecha_inicio">
                    <label for="fecha_inicio">Fecha Inicio</label>
                    <div class="x_input">
                        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Fecha de inicio inválida.</p>
                </div>
                <div class="x_grupo" id="x_fecha_fin">
                    <label for="fecha_fin">Fecha Fin</label>
                    <div class="x_input">
                        <input type="date" id="fecha_fin" name="fecha_fin" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Fecha de fin inválida.</p>
                </div>
                <div class="x_grupo" id="x_id_tipo">
                    <label for="id_tipo">Tipo de Licencia</label>
                    <div class="x_input">
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
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Debe seleccionar un tipo de licencia.</p>
                </div>
                <div class="x_grupo" id="x_id_escuela">
                    <label for="id_escuela">Escuela</label>
                    <div class="x_input">
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
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Debe seleccionar una escuela.</p>
                </div>
                <div class="form1-buttons">
                    <button onclick="window.location.href='../licencias.php'" class="btn btn-secondary" type="button"><i class="fa-solid fa-arrow-left"></i> Volver</button>
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
        checkSvg.classList.remove('show');
        xSvg.classList.remove('show');
        loadingSvg.classList.remove('show');
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
    document.getElementById('form').addEventListener('submit', function(e) {
        showModal('Procesando creación...', 'loading');
    });
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#form input, #form select');
        inputs.forEach((input) => {
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        });
    });
    </script>
    <script src="../../validate/validar.js"></script>
</body>
</html>