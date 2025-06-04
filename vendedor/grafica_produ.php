<?php
session_start();
require_once('../conex/conex.php');
require_once('../include/validate_sesion.php');
$conex = new Database;
$con = $conex->conectar();

include 'menu.php';

// Consulta: productos más vendidos y sus calorías
$productos = [];
$ventas = [];
$calorias = [];

$sql = $con->query("SELECT p.nombre_prod, 
           SUM(dpp.cantidad) AS total_vendidos,
           n.calorias
      FROM producto p
      INNER JOIN detalles_pedidos_producto dpp ON p.id_producto = dpp.id_producto
      INNER JOIN informacion_nutricional n ON p.id_producto = n.id_producto
     GROUP BY p.id_producto, p.nombre_prod, n.calorias
     ORDER BY total_vendidos DESC
     LIMIT 7
");

while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $productos[] = $row['nombre_prod'];
    $ventas[] = (int)$row['total_vendidos'];
    $calorias[] = (float)$row['calorias'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos más vendidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Productos más vendidos</h1>
        <div class="mb-3">
            <a href="ventas.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <button id="toggleChart" class="btn btn-primary">Cambiar tipo de gráfica</button>
        </div>
        <div class="d-flex justify-content-center">
            <div style="width: 800px; height: 400px;">
                <canvas id="productosChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Pasar los datos de PHP a JS
        const labels = <?php echo json_encode($productos); ?>;
        const datosVentas = <?php echo json_encode($ventas); ?>;
        const datosCalorias = <?php echo json_encode($calorias); ?>;

        let currentType = 'combo';

        const ctx = document.getElementById('productosChart').getContext('2d');
        let productosChart = createComboChart();

        document.getElementById('toggleChart').addEventListener('click', function() {
            productosChart.destroy();
            if (currentType === 'combo') {
                productosChart = createLineChart();
                currentType = 'line';
            } else {
                productosChart = createComboChart();
                currentType = 'combo';
            }
        });

        function createComboChart() {
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Vendidos',
                            data: datosVentas,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Calorías',
                            data: datosCalorias,
                            type: 'line',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 2,
                            fill: false,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Cantidad Vendida'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: {
                                display: true,
                                text: 'Calorías'
                            }
                        }
                    }
                }
            });
        }

        function createLineChart() {
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Vendidos',
                        data: datosVentas,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad Vendida'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>