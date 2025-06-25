<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    require_once('../director/functions_reportes.php');
    
    $conex = new Database;
    $con = $conex->conectar();

    $doc = $_SESSION['documento'];
    $sql = $con->prepare("SELECT escuelas.id_escuela FROM escuelas 
    INNER JOIN detalles_usuarios_escuela ON escuelas.id_escuela = detalles_usuarios_escuela.id_escuela
    WHERE detalles_usuarios_escuela.documento = ?");
    $sql->execute([$doc]);
    $escuela = $sql->fetch(PDO::FETCH_ASSOC);
    $id_escuela = $escuela['id_escuela'];
    
    if (isset($_GET['tipo'])) {
        if (ob_get_length()) ob_end_clean(); // Limpiar cualquier salida previa
        header('Content-Type: application/json');
        
        $tipo = $_GET['tipo'] ?? 'semana';
        $anio = $_GET['anio'] ?? date('Y');
        $mes = $_GET['mes'] ?? null;
    
        $response = ['labels' => [], 'data' => []];
    
        switch ($tipo) {
            case 'dia':
                $fechaFin = date('Y-m-d');
                $fechaIni = date('Y-m-d', strtotime('-7 days'));
                $ventas = obtenerVentasPorRango($con, $fechaIni, $fechaFin, $id_escuela);
    
                $periodo = new DatePeriod(
                    new DateTime($fechaIni),
                    new DateInterval('P1D'),
                    new DateTime(date('Y-m-d', strtotime($fechaFin . ' +1 day')))
                );
    
                $ventasPorDia = [];
                foreach ($ventas as $venta) {
                    $ventasPorDia[$venta['fecha']] = $venta['total'];
                }
    
                foreach ($periodo as $date) {
                    $fecha = $date->format('Y-m-d');
                    $response['labels'][] = $date->format('d M');
                    $response['data'][] = $ventasPorDia[$fecha] ?? 0;
                }
                break;
    
            case 'semana':
                $ventas = $mes ? 
                    obtenerVentasPorSemana($con, $anio, $mes, $id_escuela) : 
                    obtenerVentasPorSemana($con, $anio, $id_escue   la);
    
                foreach ($ventas as $venta) {
                    $response['labels'][] = "Semana " . $venta['semana'];
                    $response['data'][] = $venta['total'];
                }
                break;
    
            case 'mes':
                $ventas = obtenerVentasPorMes($con, $anio, $id_escuela);
    
                $meses = [
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                ];
    
                foreach ($ventas as $venta) {
                    $response['labels'][] = $meses[$venta['mes']];
                    $response['data'][] = $venta['total'];
                }
                break;
    
            case 'productos':
                $productos = obtenerProductosMasVendidos($con, 5, $id_escuela);
                foreach ($productos as $producto) {
                    $response['labels'][] = $producto['nombre_prod'];
                    $response['data'][] = $producto['total_vendido'];
                }
                break;
        }
    
        echo json_encode($response);
        exit();
    }