<?php
session_start();
require_once('../conex/conex.php');
require_once('../include/validate_sesion.php');
$conex = new Database;
$con = $conex->conectar();

include 'menu.php';

function obtenerVentasPorRango($con, $fechaIni, $fechaFin) {
    $sql = $con->prepare("SELECT DATE(p.fecha_ini) as fecha, SUM(total_pedido) as total 
    FROM pedidos p
    WHERE DATE(p.fecha_ini) BETWEEN ? AND ? 
    GROUP BY DATE(p.fecha_ini) 
    ORDER BY p.fecha_ini");
    $sql->execute([$fechaIni, $fechaFin]);

    $ventas = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $ventas[] = $row;
    }

    return $ventas;
}

function obtenerVentasPorMes($con, $anio) {
    $sql = $con->prepare("SELECT MONTH(p.fecha_ini) as mes, SUM(total_pedido) as total 
    FROM pedidos p
    WHERE YEAR(p.fecha_ini) = ? 
    GROUP BY MONTH(p.fecha_ini) 
    ORDER BY mes");
    $sql->execute([$anio]);
    
    $ventas = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $ventas[] = $row;
    }

    return $ventas;
}

function obtenerVentasPorSemana($con, $anio, $mes = null) {
    $query = "SELECT WEEK(p.fecha_ini, 1) as semana, SUM(total_pedido) as total 
    FROM pedidos p
    WHERE YEAR(p.fecha_ini) = ?";
    
    if ($mes) {
        $query .= " AND MONTH(p.fecha_ini) = ?";
    }
    
    $query .= " GROUP BY WEEK(p.fecha_ini, 1) ORDER BY semana";
    
    $sql = $con->prepare($query);
    
    if ($mes) {
        $sql->execute([$anio, $mes]);
    } else {
        $sql->execute([$anio]);
    }
    
    $ventas = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $ventas[] = $row;
    }
    
    return $ventas;
}

function obtenerAniosDisponibles($con) {
    $sql = $con->query("SELECT DISTINCT YEAR(fecha_ini) as anio FROM pedidos ORDER BY anio DESC");
    
    $anios = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $anios[] = $row['anio'];
    }

    return $anios;
}

function obtenerProductosMasVendidos($con, $limit = 10) {
    $sql = $con->prepare("SELECT pr.nombre_prod, SUM(dpp.cantidad) as total_vendido
    FROM detalles_pedidos_producto dpp
    JOIN producto pr ON dpp.id_producto = pr.id_producto
    GROUP BY pr.nombre_prod
    ORDER BY total_vendido DESC
    LIMIT ?");
    $sql->execute([$limit]);
    
    $productos = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $productos[] = $row;
    }

    return $productos;
}

// Obtener años disponibles para el select
$anios = obtenerAniosDisponibles($con);
$anioActual = date('Y');

// Si es una solicitud AJAX para datos del gráfico
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
            $ventas = obtenerVentasPorRango($con, $fechaIni, $fechaFin);

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
                obtenerVentasPorSemana($con, $anio, $mes) : 
                obtenerVentasPorSemana($con, $anio);

            foreach ($ventas as $venta) {
                $response['labels'][] = "Semana " . $venta['semana'];
                $response['data'][] = $venta['total'];
            }
            break;

        case 'mes':
            $ventas = obtenerVentasPorMes($con, $anio);

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
            $productos = obtenerProductosMasVendidos($con, 5);
            foreach ($productos as $producto) {
                $response['labels'][] = $producto['nombre_prod'];
                $response['data'][] = $producto['total_vendido'];
            }
            break;
    }

    echo json_encode($response);
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f3f4f6;
        }
        .grafico-container {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn-generar {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-2">
        <h1 class="text-center mb-2">Reporte de Ventas</h1>
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="tipo" class="form-label">Tipo de Reporte</label>
                <select id="tipo" class="form-select">
                    <option value="dia">Últimos 7 días</option>
                    <option value="semana">Semanas</option>
                    <option value="mes">Meses</option>
                    <option value="productos">Productos más vendidos</option>
                </select>
            </div>
            <div class="col-md-3" id="grupo-anio">
                <label for="anio" class="form-label">Año</label>
                <select id="anio" class="form-select">
                    <?php foreach ($anios as $anio): ?>
                        <option value="<?= $anio ?>" <?= $anio == $anioActual ? 'selected' : '' ?>>
                            <?= $anio ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3" id="grupo-mes">
                <label for="mes" class="form-label">Mes</label>
                <select id="mes" class="form-select">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button id="actualizar" class="btn btn-primary btn-generar">Generar Reporte</button>
            </div>
        </div>
        <div class="grafico-container">
            <canvas id="graficoVentas"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
            const tipoSelect = document.getElementById('tipo');
            const anioSelect = document.getElementById('anio');
            const mesSelect = document.getElementById('mes');
            const grupoMes = document.getElementById('grupo-mes');
            const grupoAnio = document.getElementById('grupo-anio');
            const actualizarBtn = document.getElementById('actualizar');

            // Configurar gráfico inicial
            const ctx = document.getElementById('graficoVentas').getContext('2d');
            let graficoVentas = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Ventas',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Monto de Ventas (COP)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Periodo'
                            }
                        }
                    }
                }
            });

            // Mostrar/ocultar controles según el tipo de reporte
            function actualizarControles() {
                const tipo = tipoSelect.value;
                
                if (tipo === 'semana') {
                    grupoMes.style.display = 'block';
                    grupoAnio.style.display = 'block';
                } else if (tipo === 'mes') {
                    grupoMes.style.display = 'none';
                    grupoAnio.style.display = 'block';
                } else if (tipo === 'dia') {
                    grupoMes.style.display = 'none';
                    grupoAnio.style.display = 'none';
                } else if (tipo === 'productos') {
                    grupoMes.style.display = 'none';
                    grupoAnio.style.display = 'none';
                }
            }

            // Cargar datos del gráfico
            function cargarDatos() {
                const tipo = tipoSelect.value;
                const anio = anioSelect.value;
                const mes = tipo === 'semana' ? mesSelect.value : null;

                fetch(`?tipo=${tipo}&anio=${anio}${mes ? '&mes=' + mes : ''}`)
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar título y tipo de gráfico según el tipo de reporte
                        let yTitle = 'Monto de Ventas (COP)';
                        let xTitle = 'Periodo';
                        let chartType = 'bar';
                        let label = 'Ventas';
                        
                        if (tipo === 'dia') {
                            xTitle = 'Últimos 7 días';
                            label = 'Ventas por día';
                        } else if (tipo === 'semana') {
                            xTitle = 'Semanas';
                            label = 'Ventas por semana';
                        } else if (tipo === 'mes') {
                            xTitle = 'Meses';
                            label = 'Ventas por mes';
                        } else if (tipo === 'productos') {
                            xTitle = 'Productos';
                            yTitle = 'Unidades vendidas';
                            label = 'Productos más vendidos';
                            chartType = 'bar';
                        }

                        // Destruir el gráfico anterior si existe
                        if (graficoVentas) {
                            graficoVentas.destroy();
                        }

                        // Crear nuevo gráfico
                        graficoVentas = new Chart(ctx, {
                            type: chartType,
                            data: {
                                labels: data.labels,
                                datasets: [{
                                    label: label,
                                    data: data.data,
                                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: yTitle
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: xTitle
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Manejar cambios en el tipo de reporte
            tipoSelect.addEventListener('change', actualizarControles);

            // Cargar datos iniciales y configurar controles
            actualizarControles();
            cargarDatos();

            // Actualizar gráfico al hacer clic en el botón
            actualizarBtn.addEventListener('click', cargarDatos);
        });
    </script>
</body>
</html>