<?php

    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();

    include 'menu.php';

    // Consulta: suma de ventas por mes
    $meses = [];
    $totales = [];
    $sql = $con->query("SELECT MONTH(fecha_ini) as mes, SUM(total_pedido) as total 
                        FROM pedidos 
                        GROUP BY mes 
                        ORDER BY mes");
    $nombres_meses = [1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $meses[] = $nombres_meses[(int)$row['mes']];
        $totales[] = (float)$row['total'];
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
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Ventas</h1>
        <div class="mb-3">
            <a href="ventas.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>
        <div class="d-flex justify-content-center">
            <div style="width: 1020px;">
                <canvas id="ventasChart" width="10000" height="5000"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Pasar los datos de PHP a JS
        const labels = <?php echo json_encode($meses); ?>;
        const data = <?php echo json_encode($totales); ?>;

        // Crear la gráfica
        const ctx = document.getElementById('ventasChart').getContext('2d');
        const ventasChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ventas',
                    data: data,
                    fill: false,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.1,
                    pointBackgroundColor: 'rgba(255,99,132,1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>