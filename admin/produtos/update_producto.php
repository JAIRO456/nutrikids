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
            if ($usuarios['imagen'] && $usuarios['imagen'] != 'default.png') {
                $oldImagePath = $ruta . $usuarios['imagen'];
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
                            showModal('Producto actualizado exitosamente.');
                        });
                    </script>";
                // echo '<script>alert("Producto actualizado exitosamente")</script>';
                // echo '<script>window.location = "../productos.php"</script>';
            } 
            else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al actualizar la información nutricional del Producto.');
                        });
                    </script>";
                // echo '<script>alert("Error al actualizar la información nutricional del Producto")</script>';
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al actualizar el Producto.');
                    });
                </script>";
            // echo '<script>alert("Error al actualizar el Producto")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
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

        .section-title {
            color: var(--text-color);
            margin: 30px 0 20px;
            font-size: 1.5em;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
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
<body onload="document.formUpdateProducts.nombre_prod.focus()">
    <main class="container-main">
        <div class="form-container">
            <h2 class="form-title">Actualizar Producto</h2>
            <form id="formUpdateProducts" method="POST" action="" enctype="multipart/form-data">
                <h3 class="section-title">Información del Producto</h3>
                <div class="form-group">
                    <div class="form-field">
                        <label for="nombre_prod">Nombre</label>
                        <input type="text" id="nombre_prod" name="nombre_prod" value="<?php echo $producto['nombre_prod']; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="id_marca">Marca</label>
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
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-field">
                        <label for="precio">Precio</label>
                        <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="id_categoria">Categoria</label>
                        <select id="id_categoria" name="id_categoria" required>
                            <option value="">Seleccione una categoria</option>
                            <?php
                                $sqlCategorias = $con->prepare("SELECT * FROM categorias");
                                $sqlCategorias->execute();
                                while ($rowCategoria = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($rowCategoria['id_categoria'] == $producto['id_categoria']) ? 'selected' : '';
                                    echo "<option value='{$rowCategoria['id_categoria']}' {$selected}>{$rowCategoria['categoria']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-field">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" style="height: 195px;" required><?php echo $producto['descripcion']; ?></textarea>
                    </div>
                    <div class="form-field">
                        <label for="imagen">Imagen</label>
                        <input type="file" id="imagen" name="imagen">
                        <small>Deje vacío para mantener la imagen actual</small>
                    </div>
                </div>

                <h3 class="section-title">Información Nutricional</h3>
                <div class="form-group">
                    <div class="form-field">
                        <label for="calorias">Calorías</label>
                        <input type="number" id="calorias" name="calorias" value="<?php echo $producto['calorias']; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="proteinas">Proteínas (g)</label>
                        <input type="number" step="0.01" id="proteinas" name="proteinas" value="<?php echo $producto['proteinas']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-field">
                        <label for="carbohidratos">Carbohidratos (g)</label>
                        <input type="number" step="0.01" id="carbohidratos" name="carbohidratos" value="<?php echo $producto['carbohidratos']; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="grasas">Grasas (g)</label>
                        <input type="number" step="0.01" id="grasas" name="grasas" value="<?php echo $producto['grasas']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-field">
                        <label for="azucares">Azúcares (g)</label>
                        <input type="number" step="0.01" id="azucares" name="azucares" value="<?php echo $producto['azucares']; ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="sodio">Sodio (mg)</label>
                        <input type="number" step="0.01" id="sodio" name="sodio" value="<?php echo $producto['sodio']; ?>" required>
                    </div>
                </div>
                <div class="button-group">
                    <a href="../productos.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Volver</a>
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