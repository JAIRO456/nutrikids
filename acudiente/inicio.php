<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $hoy = date('Y-m-d');
    $doc = $_SESSION['documento'];
    $sqlStudent = $con -> prepare("SELECT estudiantes.nombre, estudiantes.apellido, estudiantes.documento_est, estudiantes.imagen FROM estudiantes 
    INNER JOIN usuarios ON estudiantes.documento = usuarios.documento WHERE usuarios.documento = ?");
    $sqlStudent -> execute([$doc]);
    $Students = $sqlStudent -> fetchAll(PDO::FETCH_ASSOC);

    $nutrientes_est = [];
    foreach ($Students as $estudiante) {
        $documento_est = $estudiante['documento_est'];
        $sqlNutrientes = $con -> prepare("SELECT SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad), 
        SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad), 
        SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad), 
        SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad), 
        SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad), 
        SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad), 
        detalles_pedidos_producto.cantidad
        FROM informacion_nutricional 
        INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
        INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
        INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
        WHERE detalles_pedidos_producto.documento_est = ? AND pedidos.id_pedidos = 6
        AND pedidos.fecha_ini <= ? AND pedidos.fecha_fin >= ?
        AND FIND_IN_SET(LOWER(DAYNAME(?)), LOWER(pedidos.dia))");
        $sqlNutrientes -> execute([$documento_est, $hoy, $hoy, $hoy]);

        $nutrientes = [
            'calorias' => 0,
            'proteinas' => 0,
            'carbohidratos' => 0,
            'grasas' => 0,
            'azucares' => 0,
            'sodio' => 0
        ];

        $row = $sqlNutrientes->fetch(PDO::FETCH_NUM);
        if ($row) {
            $nutrientes['calorias'] = $row[0] ?? 0;
            $nutrientes['proteinas'] = $row[1] ?? 0;
            $nutrientes['carbohidratos'] = $row[2] ?? 0;
            $nutrientes['grasas'] = $row[3] ?? 0;
            $nutrientes['azucares'] = $row[4] ?? 0;
            $nutrientes['sodio'] = $row[5] ?? 0;
        }

        $nutrientes_est[] = [
            'nombre' => $estudiante['nombre'] . ' ' . $estudiante['apellido'],
            'nutrientes' => $nutrientes
        ];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Acudiente - NutriKids</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .estudiantes {
            margin-bottom: 20px;
        }
        .estudiante {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        canvas {
            max-width: 100%;
            height: auto;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, Acudiente</h1>
        <div class="estudiantes">
            <h2>Tus Estudiantes</h2>
            <?php foreach ($Students as $estudiante): ?>
                <div class="estudiante">
                    <?php echo htmlspecialchars($estudiante['nombre'] . ' ' . $estudiante['apellido']); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <h2>Nutrientes Consumidos Hoy (<?php echo date('d/m/Y'); ?>)</h2>
        <canvas id="nutrientesChart"></canvas>
    </div>

    <script>
        const nutrientesData = <?php echo json_encode($nutrientes_est); ?>;
        
        const ctx = document.getElementById('nutrientesChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: nutrientesData.map(est => est.nombre),
                datasets: [
                    {
                        label: 'Calorías (kcal)',
                        data: nutrientesData.map(est => est.nutrientes.calorias),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Proteínas (g)',
                        data: nutrientesData.map(est => est.nutrientes.proteinas),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Carbohidratos (g)',
                        data: nutrientesData.map(est => est.nutrientes.carbohidratos),
                        backgroundColor: 'rgba(255, 206, 86, 0.5)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Grasas (g)',
                        data: nutrientesData.map(est => est.nutrientes.grasas),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Azúcares (g)',
                        data: nutrientesData.map(est => est.nutrientes.azucares),
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Sodio (mg)',
                        data: nutrientesData.map(est => est.nutrientes.sodio),
                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Consumo de Nutrientes por Estudiante - Hoy'
                    }
                },
                scales: {
                    x: {
                        stacked: false
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad'
                        }
                    }
                },
                responsive: true,
                
            }
        });
    </script>
</body>
</html>