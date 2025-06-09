<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_producto = rand(100000000000, 999999999999);
        $nombre_prod = $_POST['nombre_prod'];
        $id_marca = $_POST['id_marca'];
        $precio = $_POST['precio'];
        $id_categoria = $_POST['id_categoria'];
        $descripcion = $_POST['descripcion'];

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

        $sqlInsertProduct = $con->prepare("INSERT INTO producto (id_producto, nombre_prod, descripcion, precio, imagen_prod, id_categoria, id_marca) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($sqlInsertProduct->execute([$id_producto, $nombre_prod, $descripcion, $precio, $fileName, $id_categoria, $id_marca])) {
            $sqlInsertInfoNutricional = $con->prepare("INSERT INTO informacion_nutricional (id_producto, calorias, proteinas, carbohidratos, grasas, azucares, sodio) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($sqlInsertInfoNutricional->execute([$id_producto, $calorias, $proteinas, $carbohidratos, $grasas, $azucares, $sodio])) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Producto creado exitosamente.');
                            setTimeout(() => {
                                window.location = '../productos.php';
                            }, 3000);
                        });
                    </script>";
                // echo '<script>alert("Producto creado exitosamente")</script>';
                // echo '<script>window.location = "../productos.php"</script>';
            } 
            else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Error al crear la informacion nutricional del Producto.');
                        });
                    </script>";
                // echo '<script>alert("Error al crear la informacion nutricional al Producto")</script>';
            }
        } 
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        showModal('Error al crear el Producto.');
                    });
                </script>";
            // echo '<script>alert("Error al crear el Producto")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="JsBarcode.all.min.js"></script>
    <div id="msgModal" class="modal">
                <div class="modal-content">
                    <p id="Message">
                        
                    </p>
                    <button onclick="closeModal()">Cerrar</button>
                </div>
            </div><div id="msgModal" class="modal">
                <div class="modal-content">
                    <p id="Message">
                        
                    </p>
                    <button onclick="closeModal()">Cerrar</button>
                </div>
            </div>
</head>
<body onload="document.formCreateProducts.nombre_prod.focus()">
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-4 text-center">Agregar Nuevo Producto</h2>
                    <form id="formCreateProducts" method="POST" action="" enctype="multipart/form-data">
                        <h3>Información del Producto</h3>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre_prod" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre_prod" name="nombre_prod" required>
                            </div>
                            <div class="col-md-6">
                                <label for="id_marca" class="form-label">Marca</label>
                                <select class="form-select" id="id_marca" name="id_marca" required>
                                    <option value="">Seleccione una marca</option>
                                    <?php
                                        $sqlMarcas = $con->prepare("SELECT * FROM marcas");
                                        $sqlMarcas->execute();
                                        while ($row = $sqlMarcas->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_marca']}'>{$row['marca']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label">Categoria</label>
                                <select class="form-select" id="id_categoria" name="id_categoria" required>
                                    <option value="">Seleccione una categoria</option>
                                    <?php
                                        $sqlCategorias = $con->prepare("SELECT * FROM categorias");
                                        $sqlCategorias->execute();
                                        while ($row = $sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='{$row['id_categoria']}'>{$row['categoria']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                            </div>
                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" required>
                            </div>
                        </div>

                        <h4>Información Nutricional</h4>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="calorias" class="form-label">Calorías</label>
                                <input type="number" class="form-control" id="calorias" name="calorias" required>
                            </div>
                            <div class="col-md-4">
                                <label for="proteinas" class="form-label">Proteínas (g)</label>
                                <input type="number" step="0.01" class="form-control" id="proteinas" name="proteinas" required>
                            </div>
                            <div class="col-md-4">
                                <label for="carbohidratos" class="form-label">Carbohidratos (g)</label>
                                <input type="number" step="0.01" class="form-control" id="carbohidratos" name="carbohidratos" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="grasas" class="form-label">Grasas (g)</label>
                                <input type="number" step="0.01" class="form-control" id="grasas" name="grasas" required>
                            </div>
                            <div class="col-md-4">
                                <label for="azucares" class="form-label">Azúcares (g)</label>
                                <input type="number" step="0.01" class="form-control" id="azucares" name="azucares" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sodio" class="form-label">Sodio (mg)</label>
                                <input type="number" step="0.01" class="form-control" id="sodio" name="sodio" required>
                            </div>
                        </div>          
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger">Registrar Producto</button>
                            <a href="../productos.php" class="btn btn-secondary">Cancelar</a>
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