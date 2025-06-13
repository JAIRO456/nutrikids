<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $hoy = date('Y-m-d');
    $doc = $_SESSION['documento'];
    
    $sqlPedidos = $con -> prepare("SELECT * FROM pedidos 
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_pedidos_producto ON pedidos.id_pedidos = detalles_pedidos_producto.id_pedido
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN estados ON pedidos.id_estado = estados.id_estado
    WHERE pedidos.documento = ? ORDER BY pedidos.id_pedidos DESC LIMIT 5");
    $sqlPedidos -> execute([$doc]);
    $pedidos = $sqlPedidos -> fetchAll(PDO::FETCH_ASSOC);

    $sqlStudent = $con -> prepare("SELECT estudiantes.nombre, estudiantes.apellido, estudiantes.documento_est, estudiantes.imagen, estudiantes.telefono, estudiantes.email FROM estudiantes 
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            padding-top: 80px; /* Añadido para compensar el navbar fijo */
        }
        .container {
            max-width: 100%;
            margin: auto;
            background: white;
            padding: 5px 40px 5px 40px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .estudiantes {
            border-radius: 10px;
            border: 1px solid #ddd;
            background-color:rgb(255, 255, 255);
            margin-bottom: 20px;
        }
        .estudiante {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            align-items: center;
            justify-content: center;
            place-items: center;
            width: 100%;
            height: 50px;
        }
        .estudiante-nutrientes {
            margin-top: 20px;
            width: 100%;
            height: 350px;
            place-items: center;
        }
        .estudiante-nutrientes canvas {
            width: 100%;
            height: 300px;
        }
        .estudiantes-grid {
            padding-top: 20px;
            width: 700px;
            height: 250px;
            place-items: center;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .estudiante-card {
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #fff;
            padding: 5px;
            width: 250px;
            height: 250px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .estudiante-card:hover {
            transform: translateY(-5px);
        }
        
        .estudiante-imagen {
            width: 100%;
            height: 120px;
            overflow: hidden;
        }
        .estudiante-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .estudiante-info {
            margin-top: 10px;
            width: 100%;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .estudiante-imagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .estudiante-info {
            padding: 15px;
        }
        
        .estudiante-info h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 18px;
        }
        
        .estudiante-info p {
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <div class="estudiantes-grid">
            <?php foreach ($Students as $estudiante): ?>
                <div class="estudiante-card">
                    <div class="estudiante-imagen">
                        <?php if(!empty($estudiante['imagen'])): ?>
                            <img src="../img/users/<?= $estudiante['imagen']; ?>" alt="Foto estudiante">
                        <?php else: ?>
                            <img src="../img/users/default.png" alt="Foto por defecto">
                        <?php endif; ?>
                    </div>
                    <div class="estudiante-info">
                        <h3><?= $estudiante['nombre'] . ' ' . $estudiante['apellido']; ?></h3>
                        <p>Documento: <?= $estudiante['documento_est']; ?></p>
                        <button type="button" class="btn btn-primary" onclick="showUpdateForm(<?= $estudiante['documento_est']; ?>)">Actualizar</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="estudiantes shadow-lg p-3 mb-5 bg-white rounded">
            <h2>Tus Estudiantes</h2>
            <?php foreach ($Students as $estudiante): ?>
                <div class="estudiante">
                    <?= $estudiante['nombre'] . ' ' . $estudiante['apellido']; ?>
                </div>
            <?php endforeach; ?>
            <div class="estudiante-nutrientes">
                <h2>Nutrientes Consumidos Hoy (<?php echo date('d/m/Y'); ?>)</h2>
                <canvas id="nutrientesChart"></canvas>
            </div>
        </div>
    <div class="pagos-recientes shadow-lg p-3 mb-5 bg-white rounded">
        <h2>Historial de Pagos Recientes</h2>
        <div class="tabla-pagos">
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Estudiante</th>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($pedidos)): ?>
                        <?php foreach($pedidos as $pedido): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($pedido['fecha_ini'])) ?></td>
                                <td><?= $pedido['nombre'] . ' ' . $pedido['apellido'] ?></td>
                                <td><?= $pedido['nombre_menu'] ?></td>
                                <td>$<?= number_format($pedido['total_pedido'], 2, ',', '.') ?></td>
                                <td><span class="badge <?= $pedido['estado'] == 'Pagado' ? 'badge-success' : 'badge-warning' ?>"><?= $pedido['estado'] ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay pagos recientes para mostrar</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div id="updateForm" style="display: none;">
        <h2>Actualizar Información</h2>
        <span id="closeForm" onclick="closeUpdateForm()">X</span>
        <form id="updateForm">
            <input type="hidden" id="documento_est" name="documento_est">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= $estudiante['nombre'] ?>">
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-control" value="<?= $estudiante['apellido'] ?>">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" class="form-control" value="<?= $estudiante['telefono'] ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= $estudiante['email'] ?>">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <script>
        function showUpdateForm(documento_est) {
            document.getElementById('updateForm').style.display = 'block';
            document.getElementById('documento_est').value = documento_est;
        }
        function closeUpdateForm() {
            document.getElementById('updateForm').style.display = 'none';
        }
        function updateEstudiante() {
            const documento_est = document.getElementById('documento_est').value;
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;
            const telefono = document.getElementById('telefono').value;
            const email = document.getElementById('email').value;
            const imagen = document.getElementById('imagen').value;

            const data = {
                documento_est: documento_est,
                nombre: nombre,
                apellido: apellido,
                telefono: telefono,
                email: email,
                imagen: imagen
            };

            fetch('../ajax/update_estudiante.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        document.getElementById('updateForm').addEventListener('submit', function(e) {
            e.preventDefault();
            updateEstudiante();
        });
    </script>
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