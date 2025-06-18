<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $documento = $_SESSION['documento'];

    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    $sqlPedidos = $con->prepare("SELECT COUNT(DISTINCT detalles_menu.id_menu) AS total_pedidos 
    FROM pedidos 
    INNER JOIN detalles_pedidos_producto ON pedidos.id_pedidos = detalles_pedidos_producto.id_pedido 
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu 
    INNER JOIN detalles_menu ON menus.id_menu = detalles_menu.id_menu 
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est 
    INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est 
    INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela 
    WHERE escuelas.id_escuela = ? AND detalles_menu.id_estado = 1 AND DATE(pedidos.fecha_ini) = CURDATE() AND DATE(pedidos.fecha_fin) = CURDATE()");
    $sqlPedidos->execute([$u['id_escuela']]);
    $pedidos = $sqlPedidos->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo-nutrikids2.png" type="image/png">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #6c757d;
            --background-color: #f3f4f6;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: var(--background-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 75px;
            padding: 1rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            transition: transform var(--transition-speed);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .stat-card {
            background: var(--primary-color);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card h5 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            animation: countUp 1s ease-out;
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="grid">
            <div class="stat-card">
                <h5>Pedidos</h5>
                <p class="number" id="TotalPedidos">
                    <i class="fa-solid fa-archive"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Entregados</h5>
                <p class="number" id="TotalPedidosCheck">
                    <i class="fa-solid fa-calendar-check"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>No Entregados</h5>
                <p class="number" id="TotalPedidosX">
                    <i class="fa-solid fa-calendar-xmark"></i>
                </p>
            </div>
        </div>
        <div class="report-section">
            <h2>Reportes Pedidos</h2>
            <div class="chart-container" style="height:350px; width: 100%; place-items: center;">
                <canvas id="ChartPedidos"></canvas>
            </div>
        </div>
    </main>
</body>
<script>
    const ctx = document.getElementById('ChartPedidos').getContext('2d');
    const ChartPedidos = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pedidos', 'Entregados', 'No Entregados'],
            datasets: [{
                label: 'Pedidos',
                data: [120, 80, 40],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>
    function updateCounts() {
        fetch('../ajax/get_counts3.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('TotalPedidos').innerHTML = `<i class="fa-solid fa-archive"></i> ${data.TotalPedidos}`;
                document.getElementById('TotalPedidosCheck').innerHTML = `<i class="fa-solid fa-calendar-check"></i> ${data.TotalPedidosCheck}`;
                document.getElementById('TotalPedidosX').innerHTML = `<i class="fa-solid fa-calendar-xmark"></i> ${data.TotalPedidosX}`;
                // document.getElementById('TotalVentas').innerHTML = `<i class="bi bi-bar-chart-fill"></i> ${data.TotalVentas}`;
            })
            .catch(error => console.error('Error al obtener datos:', error));
    }
    // Cargar los datos al inicio
    document.addEventListener('DOMContentLoaded', function () {
        updateCounts();
    });
</script>
</html>