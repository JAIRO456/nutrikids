<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $productos = isset($_POST['productos']) ? json_decode($_POST['productos'], true) : [];
    $nombre_menu = $_POST['nombre_menu'];

    $total_precio = 0;
    foreach ($productos as $producto) {
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
                $sqlInsertDetsMenu = $con->prepare("INSERT INTO detalles_menu (cantidad, id_menu, id_producto, id_estado, subtotal) 
                VALUES (?, ?, ?, ?, ?)");
                $sqlInsertDetsMenu->execute([$cantidad, $idMenu, $id_producto, 2, $subtotal]);
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