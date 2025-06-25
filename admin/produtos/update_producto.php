<?php
    session_start();
    require_once('../../database/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

    $id_producto = $_GET['id'];
    $sqlProducto = $con->prepare("SELECT * FROM producto 
    INNER JOIN categorias ON producto.id_categoria = categorias.id_categoria 
    INNER JOIN marcas ON producto.id_marca = marcas.id_marca
    INNER JOIN informacion_nutricional ON producto.id_producto = informacion_nutricional.id_producto 
    WHERE producto.id_producto = ?");
    $sqlProducto->execute([$id_producto]);
    $producto = $sqlProducto->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_prod = $_POST['nombre_prod'];
        $id_marca = $_POST['id_marca'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        $descripcion = $_POST['descripcion'];
        $fileName = $producto['imagen_prod'];

        $calorias = $_POST['calorias'];
        $proteinas = $_POST['proteinas'];
        $carbohidratos = $_POST['carbohidratos'];
        $grasas = $_POST['grasas'];
        $azucares = $_POST['azucares'];
        $sodio = $_POST['sodio'];

        // Si se sube una imagen nueva
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $fileTmp = $_FILES['imagen']['tmp_name'];
            $fileName = str_replace(' ', '_', $_FILES['imagen']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $formatType = array("jpg", "jpeg", "png");
            $ruta = '../../img/products/';
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
            // Eliminar la imagen anterior si no es la predeterminada
            if ($producto['imagen_prod'] && $producto['imagen_prod'] != 'default.png') {
                $oldImagePath = $ruta . $producto['imagen_prod'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $sqlUpdateProduct = $con->prepare("UPDATE producto SET nombre_prod=?, descripcion=?, precio=?, imagen_prod=?, id_categoria=?, id_marca=? WHERE id_producto=?");
        if ($sqlUpdateProduct->execute([$nombre_prod, $descripcion, $precio, $fileName, $id_categoria, $id_marca, $id_producto])) {
            $sqlUpdateInfoNutricional = $con->prepare("UPDATE informacion_nutricional SET calorias=?, proteinas=?, carbohidratos=?, grasas=?, azucares=?, sodio=? WHERE id_producto=?");
            if ($sqlUpdateInfoNutricional->execute([$calorias, $proteinas, $carbohidratos, $grasas, $azucares, $sodio, $id_producto])) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Producto actualizado exitosamente.', 'success');
                            setTimeout(() => {
                                window.location = '../productos.php';
                            }, 3000);
                        });
                    </script>";
            } 
            else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al actualizar la información nutricional del Producto.', 'error');
                        });
                    </script>";
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al actualizar el Producto.', 'error');
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
    <title>Actualizar Producto</title>
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
        .section-title {
            grid-column: 1 / -1;
            font-size: 1.2rem;
            color: #5a8b66;
            margin: 20px 0 10px 0;
            font-weight: bold;
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
        .x_input input, .x_input select, .x_input textarea {
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
        .x_input textarea {
            height: 100px;
            resize: vertical;
            padding-right: 40px;
        }
        .x_input input:focus, .x_input select:focus, .x_input textarea:focus {
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
        .x_grupo-incorrecto .x_input input, .x_grupo-incorrecto .x_input select, .x_grupo-incorrecto .x_input textarea {
            border: 2px solid #bb2929;
            background: #fff0f0;
        }
        .x_grupo-correcto .x_input input, .x_grupo-correcto .x_input select, .x_grupo-correcto .x_input textarea {
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
<body onload="document.getElementById('nombre_prod').focus()">
    <main class="container-main">
        <div class="form-container">
            <h2 class="form-title">Actualizar Producto</h2>
            <form id="form" class="form" method="POST" action="" enctype="multipart/form-data">
                <span class="section-title">Información del Producto</span>
                <div class="x_grupo" id="x_nombre_prod">
                    <label for="nombre_prod">Nombre</label>
                    <div class="x_input">
                        <input type="text" id="nombre_prod" name="nombre_prod" value="<?php echo $producto['nombre_prod']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Nombre inválido, debe ser un texto.</p>
                </div>
                <div class="x_grupo" id="x_id_marca">
                    <label for="id_marca">Marca</label>
                    <div class="x_input">
                        <select id="id_marca" name="id_marca" required>
                            <option value="">Seleccione una marca</option>
                            <?php
                                $sqlMarcas = $con->prepare("SELECT * FROM marcas");
                                $sqlMarcas->execute();
                                while ($rowMarca = $sqlMarcas->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($rowMarca['id_marca'] == $producto['id_marca']) ? 'selected' : '';
                                    echo "<option value='{$rowMarca['id_marca']}' {$selected}>{$rowMarca['marca']}</option>";
                                }
                            ?>
                        </select>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Debe seleccionar una marca.</p>
                </div>
                <div class="x_grupo" id="x_precio">
                    <label for="precio">Precio</label>
                    <div class="x_input">
                        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Precio inválido.</p>
                </div>
                <div class="x_grupo" id="x_id_categoria">
                    <label for="id_categoria">Categoría</label>
                    <div class="x_input">
                        <select id="id_categoria" name="id_categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <?php
                                $sqlCategorias = $con->prepare("SELECT * FROM categorias");
                                $sqlCategorias->execute();
                                while ($rowCategoria = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($rowCategoria['id_categoria'] == $producto['id_categoria']) ? 'selected' : '';
                                    echo "<option value='{$rowCategoria['id_categoria']}' {$selected}>{$rowCategoria['categoria']}</option>";
                                }
                            ?>
                        </select>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Debe seleccionar una categoría.</p>
                </div>
                <div class="x_grupo" id="x_descripcion">
                    <label for="descripcion">Descripción</label>
                    <div class="x_input">
                        <textarea id="descripcion" name="descripcion" required><?php echo $producto['descripcion']; ?></textarea>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Descripción inválida.</p>
                </div>
                <div class="x_grupo" id="x_imagen">
                    <label for="imagen">Imagen</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                    <small>Deje vacío para mantener la imagen actual</small>
                </div>
                <span class="section-title">Información Nutricional</span>
                <div class="x_grupo" id="x_calorias">
                    <label for="calorias">Calorías</label>
                    <div class="x_input">
                        <input type="number" id="calorias" name="calorias" value="<?php echo $producto['calorias']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Calorías inválidas.</p>
                </div>
                <div class="x_grupo" id="x_proteinas">
                    <label for="proteinas">Proteínas (g)</label>
                    <div class="x_input">
                        <input type="number" step="0.01" id="proteinas" name="proteinas" value="<?php echo $producto['proteinas']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Proteínas inválidas.</p>
                </div>
                <div class="x_grupo" id="x_carbohidratos">
                    <label for="carbohidratos">Carbohidratos (g)</label>
                    <div class="x_input">
                        <input type="number" step="0.01" id="carbohidratos" name="carbohidratos" value="<?php echo $producto['carbohidratos']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Carbohidratos inválidos.</p>
                </div>
                <div class="x_grupo" id="x_grasas">
                    <label for="grasas">Grasas (g)</label>
                    <div class="x_input">
                        <input type="number" step="0.01" id="grasas" name="grasas" value="<?php echo $producto['grasas']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Grasas inválidas.</p>
                </div>
                <div class="x_grupo" id="x_azucares">
                    <label for="azucares">Azúcares (g)</label>
                    <div class="x_input">
                        <input type="number" step="0.01" id="azucares" name="azucares" value="<?php echo $producto['azucares']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Azúcares inválidos.</p>
                </div>
                <div class="x_grupo" id="x_sodio">
                    <label for="sodio">Sodio (mg)</label>
                    <div class="x_input">
                        <input type="number" step="0.01" id="sodio" name="sodio" value="<?php echo $producto['sodio']; ?>" required>
                        <i class="form_estado fa fa-exclamation-circle"></i>
                    </div>
                    <p class="x_typerror">Sodio inválido.</p>
                </div>
                <div class="form1-buttons">
                    <button onclick="window.location.href='../productos.php'" class="btn btn-secondary" type="button"><i class="fa-solid fa-arrow-left"></i> Volver</button>
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
        showModal('Procesando actualización...', 'loading');
    });
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#form input, #form select, #form textarea');
        inputs.forEach((input) => {
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        });
    });
    </script>
    <script src="../../validate/validar.js"></script>
</body>
</html>