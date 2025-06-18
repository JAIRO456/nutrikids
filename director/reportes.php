<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    require_once('../include/functions_reportes.php');
    
    $conex = new Database;
    $con = $conex->conectar();

    //include 'menu.php';

    // Obtener años disponibles para el select
    $anios = obtenerAniosDisponibles($con);
    $anioActual = date('Y');

    // Obtener ventas por mes para el año seleccionado
    $anioSeleccionado = isset($_POST['anio']) ? $_POST['anio'] : $anioActual;
    $ventasPorMes = obtenerVentasPorMes($con, $anioSeleccionado, $id_escuela);

    // Convertir los datos a un formato más fácil de usar en la vista
    $meses = [];
    $nombresMeses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    foreach ($ventasPorMes as $venta) {
        $meses[$nombresMeses[$venta['mes']]] = $venta['total'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Ventas</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        *   {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            padding-top: 60px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .chart-container {
            margin: 20px 0;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .text-right {
            text-align: right;
        }
        
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 2px solid #ddd;
        }
        
        form {
            margin-bottom: 20px;
        }
        
        select, button {
            padding: 8px 12px;
            margin-right: 10px;
        }
        
        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reportes de Ventas</h1>
        <form action="reportes.php" method="post">
            <label for="anio">Año:</label>
            <select name="anio" id="anio">
                <?php foreach ($anios as $anio): ?>
                    <option value="<?php echo $anio; ?>" <?php echo ($anio == $anioSeleccionado) ? 'selected' : ''; ?>>
                        <?php echo $anio; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <div class="chart-container">
            <canvas id="ventasChart"></canvas>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Ventas</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalVentas = 0;
                foreach ($meses as $mes => $ventas): 
                    $totalVentas += $ventas;
                ?>
                    <tr>
                        <td><?php echo $mes; ?></td>
                        <td class="text-right">$<?php echo number_format($ventas, 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>$<?php echo number_format($totalVentas, 2, ',', '.'); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ventasChart').getContext('2d');
            
            // Preparar datos para la gráfica
            const labels = <?php echo json_encode(array_keys($meses)); ?>;
            const data = <?php echo json_encode(array_values($meses)); ?>;
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas por Mes',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Ventas por Mes - <?php echo $anioSeleccionado; ?>'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('es-CO', {
                                            style: 'currency',
                                            currency: 'COP'
                                        }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('es-CO', {
                                        style: 'currency',
                                        currency: 'COP',
                                        maximumFractionDigits: 0
                                    }).format(value);
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html> 