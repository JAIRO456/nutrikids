<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $response = [];

    // Obtener el conteo de usuarios
    $doc = $_SESSION['documento'];
    $sqlRoles = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    if ($sqlRoles->execute([$doc])) {
        $u = $sqlRoles->fetch();
        $sqlPedidos = $con->prepare("SELECT COUNT(DISTINCT detalles_menu.id_menu) AS TotalPedidos FROM detalles_menu
        INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
        INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu
        INNER JOIN usuarios ON menus.documento = usuarios.documento
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        WHERE escuelas.id_escuela = ?");
        $sqlPedidos->execute([$u['id_escuela']]);
        $sql = $sqlPedidos->fetch();
        $response['TotalPedidos'] = $sql['TotalPedidos'];

        $sqlPedidosCheck = $con->prepare("SELECT COUNT(DISTINCT detalles_menu.id_menu) AS TotalPedidosCheck FROM detalles_menu
        INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
        INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu
        INNER JOIN usuarios ON menus.documento = usuarios.documento
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        WHERE escuelas.id_escuela = ? AND detalles_menu.id_estado = 3");
        $sqlPedidosCheck->execute([$u['id_escuela']]);
        $sql = $sqlPedidosCheck->fetch();
        $response['TotalPedidosCheck'] = $sql['TotalPedidosCheck'];
        
        $sqlPedidosX = $con->prepare("SELECT COUNT(DISTINCT detalles_menu.id_menu) AS TotalPedidosX FROM detalles_menu
        INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
        INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu
        INNER JOIN usuarios ON menus.documento = usuarios.documento
        INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        WHERE escuelas.id_escuela = ? AND detalles_menu.id_estado = 4");
        $sqlPedidosX->execute([$u['id_escuela']]);
        $sql = $sqlPedidosX->fetch();
        $response['TotalPedidosX'] = $sql['TotalPedidosX'];

        // $sqlVentas = $con->prepare("SELECT SUM(pedidos.total_pedido) AS TotalVentas FROM pedidos
        // INNER JOIN estados ON pedidos.id_estado = estados.id_estado
        // INNER JOIN usuarios ON pedidos.documento = usuarios.documento
        // INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
        // INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
        // WHERE escuelas.id_escuela = ? AND pedidos.id_estado = 6 AND pedidos.fecha_ini = CURDATE()");
        // $sqlVentas->execute([$u['id_escuela']]);
        // $sql = $sqlVentas->fetch();
        // $response['TotalVentas'] = $sql['TotalVentas'];
    }

    // Devolver la respuesta en formato JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>