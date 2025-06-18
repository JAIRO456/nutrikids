<?php
    session_start();
    require_once '../database/conex.php';
    require_once '../include/validate_sesion.php';
    $conex =new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $id_estudiante = $_GET['id_estudiante'];
    $dia = $_GET['dia'];
    $estado = isset($_GET['id_estado']) ? $_GET['id_estado'] : null;

    if (empty($id_estudiante) || empty($dia)) {
        echo json_encode(['error' => 'ID de estudiante o día no proporcionados.']);
        exit;
    }

    $sql = $con->prepare("SELECT 
        menus.id_menu, 
        producto.nombre_prod, 
        detalles_pedidos_producto.subtotal, 
        detalles_pedidos_producto.cantidad,
        pedidos.dia
    FROM detalles_pedidos_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
    WHERE detalles_pedidos_producto.documento_est = ? 
    AND FIND_IN_SET(?, pedidos.dia) > 0
    ORDER BY producto.nombre_prod ASC");

    try {
        $sql->execute([$id_estudiante, $dia]);
        $pedidos = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($pedidos)) {
            echo json_encode(['error' => 'No hay pedidos registrados para este estudiante en este día.']);
            exit;
        }

        $id_menu = $pedidos[0]['id_menu'];
        $response = [];
        
        foreach ($pedidos as $pedido) { 
            $response[] = [ 
                'nombre_prod' => $pedido['nombre_prod'],
                'cantidad' => $pedido['cantidad'],
                'subtotal' => number_format($pedido['subtotal'], 2),
            ];
        }
        
        echo json_encode(['pedidos' => $response]);
        
    } catch (PDOException $e) {
        error_log("Error en la consulta SQL: " . $e->getMessage());
        echo json_encode(['error' => 'Error al obtener los pedidos. Por favor, intente nuevamente.']);
        exit;
    }

    if (isset($id_menu) && $estado !== null) {
        $sqlUpdateMenu = $con->prepare("UPDATE detalles_menu SET id_estado = ? WHERE id_menu = ?");
        $sqlUpdateMenu->execute([$estado, $id_menu]);
        
        $sql = $con->prepare("SELECT menus.id_menu, menus.nombre_menu, estudiantes.nombre AS nombre_est, 
        estudiantes.apellido AS apellido_est, 
        usuarios.nombre AS nombre_usu, 
        usuarios.apellido AS apellido_usu, 
        usuarios.email, detalles_menu.id_estado
        FROM detalles_menu
        INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu
        INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
        INNER JOIN usuarios ON menus.documento = usuarios.documento
        INNER JOIN estudiantes ON estudiantes.documento = usuarios.documento
        WHERE menus.id_menu = ?");
        $sql->execute([$id_menu]);
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($result)) {
            $email_data = $result[0]; // Obtener la primera fila
            
            require_once '../libraries/PHPMailer-master/config/email_menu_estado.php';
            if (email_menu_estado(
                $email_data['email'],
                $email_data['nombre_usu'],
                $email_data['apellido_usu'],
                $email_data['nombre_est'],
                $email_data['apellido_est'],
                $email_data['nombre_menu'],
                $email_data['id_estado'],
                $con
            )) {
                echo json_encode(['success' => 'El correo se ha enviado correctamente.']);
            } else {
                echo json_encode(['error' => 'Error al enviar el correo.']); 
            }
        } else {
            echo json_encode(['error' => 'No se encontraron datos para enviar el correo.']);
        }
    }
?>