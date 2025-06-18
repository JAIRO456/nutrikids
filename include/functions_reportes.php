<?php
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();

    $doc = $_SESSION['documento'];
    $sql = $con->prepare("SELECT escuelas.id_escuela FROM escuelas 
    INNER JOIN detalles_usuarios_escuela ON escuelas.id_escuela = detalles_usuarios_escuela.id_escuela
    WHERE detalles_usuarios_escuela.documento = ?");
    $sql->execute([$doc]);
    $escuela = $sql->fetch(PDO::FETCH_ASSOC);
    $id_escuela = $escuela['id_escuela'];
    
    function obtenerVentasPorRango($con, $fechaIni, $fechaFin, $id_escuela) {
        $sql = $con->prepare("SELECT DATE(p.fecha_ini) as fecha, SUM(total_pedido) as total 
        FROM pedidos p
        INNER JOIN detalles_usuarios_escuela deu ON p.documento = deu.documento
        INNER JOIN usuarios u ON deu.documento = u.documento
        INNER JOIN escuelas e ON deu.id_escuela = e.id_escuela
        WHERE DATE(p.fecha_ini) BETWEEN ? AND ? AND e.id_escuela = ?
        GROUP BY DATE(p.fecha_ini) 
        ORDER BY p.fecha_ini");
        $sql->execute([$fechaIni, $fechaFin, $id_escuela]);  

        $ventas = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $ventas[] = $row;
        }   

        return $ventas;
    }

    function obtenerVentasPorMes($con, $anio, $id_escuela) {
        $sql = $con->prepare("SELECT MONTH(p.fecha_ini) as mes, SUM(total_pedido) as total 
        FROM pedidos p
        INNER JOIN detalles_usuarios_escuela deu ON p.documento = deu.documento
        INNER JOIN usuarios u ON deu.documento = u.documento
        INNER JOIN escuelas e ON deu.id_escuela = e.id_escuela
        WHERE YEAR(p.fecha_ini) = ? AND e.id_escuela = ?
        GROUP BY MONTH(p.fecha_ini) 
        ORDER BY mes");
        $sql->execute([$anio, $id_escuela]);

        $ventas = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $ventas[] = $row;
        }

        return $ventas;
    }

    function obtenerVentasPorSemana($con, $anio, $mes = null, $id_escuela) {
        $query = "SELECT WEEK(p.fecha_ini, 1) as semana, SUM(total_pedido) as total 
        FROM pedidos p
        INNER JOIN detalles_usuarios_escuela deu ON p.documento = deu.documento
        INNER JOIN usuarios u ON deu.documento = u.documento
        INNER JOIN escuelas e ON deu.id_escuela = e.id_escuela
        WHERE YEAR(p.fecha_ini) = ? AND e.id_escuela = ?";

        if ($mes) {
            $query .= " AND MONTH(p.fecha_ini) = ?";
        }

        $query .= " GROUP BY WEEK(p.fecha_ini, 1) ORDER BY semana";

        $sql = $con->prepare($query);

        if ($mes) {
            $sql->execute([$anio, $mes, $id_escuela]);
        } else {
            $sql->execute([$anio, $id_escuela]);
        }

        $ventas = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $ventas[] = $row;
        }

        return $ventas;
    }

    function obtenerAniosDisponibles($con) {
        $sql = $con->query("SELECT DISTINCT YEAR(p.fecha_ini) as anio FROM pedidos p
        INNER JOIN detalles_usuarios_escuela deu ON p.documento = deu.documento
        INNER JOIN usuarios u ON deu.documento = u.documento
        INNER JOIN escuelas e ON deu.id_escuela = e.id_escuela
        WHERE e.id_escuela = ?
        ORDER BY p.fecha_ini DESC");

        $anios = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $anios[] = $row['anio'];
        }

        return $anios;
    }

    function obtenerProductosMasVendidos($con, $limit = 10, $id_escuela) {
        $sql = $con->prepare("SELECT pr.nombre_prod, SUM(dpp.cantidad) as total_vendido
        FROM detalles_pedidos_producto dpp
        JOIN producto pr ON dpp.id_producto = pr.id_producto
        INNER JOIN detalles_usuarios_escuela deu ON dpp.documento = deu.documento
        INNER JOIN usuarios u ON deu.documento = u.documento
        INNER JOIN escuelas e ON deu.id_escuela = e.id_escuela
        WHERE e.id_escuela = ?
        GROUP BY pr.nombre_prod
        ORDER BY total_vendido DESC
        LIMIT ?");
        $sql->execute([$id_escuela, $limit]);

        $productos = [];
        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = $row;
        }

        return $productos;
    }
?>