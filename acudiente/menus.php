<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();
    
    $documento = $_SESSION['documento'];
    
    $nombre_menu = $_POST['nombre_menu'];
    
    if (empty($nombre_menu)) {
        throw new Exception("El nombre del menú es requerido.");
        exit();
    }
    if (strlen($nombre_menu) > 50) {
        throw new Exception("El nombre del menú no puede tener más de 50 caracteres.");
        exit();
    }
    
    // Procesar los días
    $dias = [];
    if (isset($_POST['dias'])) {
        if (is_string($_POST['dias'])) {
            // Si viene como JSON
            $dias = json_decode($_POST['dias'], true);
        } else {
            // Si viene como array de checkboxes
            $dias = $_POST['dias'];
        }
    }
    
    if (empty($dias) || !is_array($dias)) {
        throw new Exception("Debe seleccionar al menos un día, si no selecciona ninguno, el menu no se guardara.");
        exit();
    }
    
    // Procesar los productos
    $productos = [];
    if (isset($_POST['productos']) && !empty($_POST['productos'])) {
        $productos_raw = $_POST['productos'];
        
        if (is_string($productos_raw)) {
            $productos = json_decode($productos_raw, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar JSON de productos: " . json_last_error_msg());
            }
        } else {
            $productos = $productos_raw;
        }
    }
    
    if (empty($productos) || !is_array($productos)) {
        throw new Exception("Debe seleccionar al menos un producto, si no selecciona ninguno, el menu no se guardara.");
        exit();
    }

    $total_precio = 0;
    foreach ($productos as $producto) {
        if (!is_array($producto) || !isset($producto['precio']) || !isset($producto['cantidad'])) {
            throw new Exception("Formato de producto inválido: " . print_r($producto, true));
        }
        $total_precio += floatval($producto['precio']) * intval($producto['cantidad']);
    }

    $sqlInsertMenu = $con->prepare("INSERT INTO menus (nombre_menu, precio, documento) VALUES (?, ?, ?)");
    if ($sqlInsertMenu->execute([$nombre_menu, $total_precio, $documento])) {
        $idMenu = $con->lastInsertId();
        
        foreach ($productos as $producto) {
            $id_producto = intval($producto['id_producto']);
            $cantidad = intval($producto['cantidad']);
            $precio = floatval($producto['precio']);
            $subtotal = $precio * $cantidad;

            $sql = $con->prepare("SELECT precio FROM producto WHERE id_producto = ?");
            $sql->execute([$id_producto]);
            $verif = $sql->fetch(PDO::FETCH_ASSOC);

            if ($verif) {
                // Para cada día seleccionado, crear un registro separado
                foreach ($dias as $dia) {
                    $sqlInsertDetsMenu = $con->prepare("INSERT INTO detalles_menu (cantidad, dias, id_menu, id_producto, id_estado, subtotal) 
                    VALUES (?, ?, ?, ?, ?, ?)");
                    $sqlInsertDetsMenu->execute([$cantidad, $dia, $idMenu, $id_producto, 2, $subtotal]);
                }
            } 
            else {
                throw new Exception("Product with ID $id_producto not found.");
            }
        }

        header("Location: categorias.php");
        exit();
    }
    else {
        throw new Exception("Failed to insert menu.");
    }
?>