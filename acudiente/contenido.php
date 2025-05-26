<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $metodo_pago = $_POST['id_met_pago'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Insertar en la tabla pedidos
        $sqlInsertPedidos = $con->prepare("INSERT INTO pedidos (dia, documento, total_pedido, id_met_pago, fecha_ini, fecha_fin, id_estado)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sqlInsertPedidos->execute([$dias, $documento, $total_precio, $metodo_pago, $fecha_ini, $fecha_fin, 1]);
        
        if ($stmt->execute()) {
            $mensaje = "Pago registrado exitosamente";
            // Redirigir a la página de pagos
            header("Location: pagos.php");
        } 
        else {
            $mensaje = "Error al registrar el pago";
            // Redirigir a la página de pagos
            header("Location: pagos.php");
        }
    }
?>