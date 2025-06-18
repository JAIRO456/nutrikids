<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    // require_once('../time.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $sqlInfoNutriconal = $con -> prepare("SELECT 
    producto.nombre_prod,
    SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad) AS total_cal, 
    SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad) AS total_pro, 
    SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad) AS total_car, 
    SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad) AS total_gras, 
    SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad) AS total_azu, 
    SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad) AS total_sod 
    FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    WHERE pedidos.fecha_ini = CURDATE() AND pedidos.fecha_fin = CURDATE() AND pedidos.id_estado = 6
    GROUP BY producto.nombre_prod");
    $sqlInfoNutriconal -> execute();
    $InfoNutric = $sqlInfoNutriconal -> fetchAll(PDO::FETCH_ASSOC);

    $productos = [];
    $calorias = [];
    $proteinas = [];
    $carbohidratos = [];
    $grasas = [];
    $azucares = [];
    $sodios = [];

    foreach ($InfoNutric as $producto) {
        $productos[] = $producto['nombre_prod'];
        $calorias[] = $producto['total_cal'];
        $proteinas[] = $producto['total_pro'];
        $carbohidratos[] = $producto['total_car'];
        $grasas[] = $producto['total_gras'];
        $azucares[] = $producto['total_azu'];
        $sodios[] = $producto['total_sod'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo-nutrikids2.png" type="image/png">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        table {
            background: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            transition: transform var(--transition-speed);
            overflow: hidden;
        }

        .report-section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: var(--card-shadow);
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .input-date {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color var(--transition-speed);
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            /* border-collapse: collapse; */
            margin: 1rem 0;
            border: 1px solid #ddd;
        }

        h4 {
            text-align: center;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #2c3e50;
            font-weight: bold;
            color: white;
            text-align: center;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 100px;
            }
            .grid {
                grid-template-columns: 1fr;
            }

            .filter-controls {
                flex-direction: column;
                align-items: center;
            }

            .input-date {
                width: 100%;
            }

            .chart-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 150px;
            }

            .chart-container canvas {
                width: 100% !important;
                height: 100% !important;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="grid">
            <div class="stat-card">
                <h5>Directores</h5>
                <p class="number" id="TotalUsers">
                    <i class="fa-solid fa-user"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Licencias Activas</h5>
                <p class="number" id="TotalLicencias">
                    <i class="fa-solid fa-file-contract"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Escuelas</h5>
                <p class="number" id="TotalSchools">
                    <i class="fa-solid fa-school"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Productos</h5>
                <p class="number" id="TotalProducts">
                    <i class="fa-solid fa-basket-shopping"></i>
                </p>
            </div>
        </div>

        <div class="report-section">
            <h2>Reportes Nutricionales</h2>
            <h4>Distribución de Nutrientes</h4>
            <div class="chart-container" style="height:350px; width: 100%; place-items: center;">
                <canvas id="nutrient"></canvas>
            </div>
            <div class="productos-list mt-4">
                <h4>Lista de Productos y sus Valores Nutricionales</h4>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Calorías</th>
                                <th>Proteínas</th>
                                <th>Carbohidratos</th>
                                <th>Grasas</th>
                                <th>Azúcares</th>
                                <th>Sodio</th>
                            </tr>
                        </thead>
                        <tbody id="productos-tabla">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="report-section-licencias">
            <h4>Licencias por expirar</h4>
            <div class="table-container">
                <?php
                    $hoy = date('Y-m-d');
                    $treinta_dias = date('Y-m-d', strtotime('+30 days'));
                    $sqlDias = $con->query("SELECT licencias.id_licencia, licencias.fecha_fin, escuelas.nombre_escuela FROM licencias
                    INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
                    INNER JOIN estados ON licencias.id_estado = estados.id_estado
                    WHERE estados.id_estado = 1 
                    AND licencias.fecha_fin BETWEEN '$hoy' AND '$treinta_dias'
                    ORDER BY licencias.fecha_fin ASC");
                    $licencias = $sqlDias->fetchAll(PDO::FETCH_ASSOC);
        
                    if (count($licencias) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Escuela</th>
                                    <th>Fecha Expiración</th>
                                    <th>Días Restantes</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($licencias as $licencia): 
                                    $dias_restantes = (new DateTime($licencia['fecha_fin']))->diff(new DateTime($hoy))->days;
                                ?>
                                <tr>
                                    <td><?= $licencia['nombre_escuela']; ?></td>
                                    <td><?= date('d/m/Y', strtotime($licencia['fecha_fin'])) ?></td>
                                    <td><?= $dias_restantes ?></td>
                                    <td>
                                        <a href="licencias/update_licencia.php?id=<?= $licencia['id_licencia'] ?>" class="btn btn-primary">Renovar</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert">No hay licencias por expirar en los próximos 30 días.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="report-section">
            <h4>Directores Recientes</h4>
            <div class="table-container">
                <table id="table-users">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="report-section">
            <h4>Productos Recientes</h4>
            <div class="table-container">
                <table id="table-products">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </main>
</body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let nutrientChart;
     
        function actualizarGrafica(datos) {
            const ctx = document.getElementById('nutrient').getContext('2d');
       
            if (nutrientChart) {
                nutrientChart.destroy();
            }

            // Calcular totales para el gráfico
            const totales = {
                calorias: datos.reduce((sum, item) => sum + parseFloat(item.total_cal), 0),
                proteinas: datos.reduce((sum, item) => sum + parseFloat(item.total_pro), 0),
                carbohidratos: datos.reduce((sum, item) => sum + parseFloat(item.total_car), 0),
                grasas: datos.reduce((sum, item) => sum + parseFloat(item.total_gras), 0),
                azucares: datos.reduce((sum, item) => sum + parseFloat(item.total_azu), 0),
                sodio: datos.reduce((sum, item) => sum + parseFloat(item.total_sod), 0)
            };

            nutrientChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Calorías', 'Proteínas', 'Carbohidratos', 'Grasas', 'Azúcares', 'Sodio'],
                    datasets: [{
                        label: 'Valores Totales',
                        data: [
                            totales.calorias,
                            totales.proteinas,
                            totales.carbohidratos,
                            totales.grasas,
                            totales.azucares,
                            totales.sodio
                        ],
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
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

            // Actualizar la tabla de productos
            const tbody = document.getElementById('productos-tabla');
            tbody.innerHTML = '';
            
            datos.forEach(producto => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${producto.nombre_prod}</td>
                    <td>${parseFloat(producto.total_cal).toFixed(2)}</td>
                    <td>${parseFloat(producto.total_pro).toFixed(2)}</td>
                    <td>${parseFloat(producto.total_car).toFixed(2)}</td>
                    <td>${parseFloat(producto.total_gras).toFixed(2)}</td>
                    <td>${parseFloat(producto.total_azu).toFixed(2)}</td>
                    <td>${parseFloat(producto.total_sod).toFixed(2)}</td>
                `;
                tbody.appendChild(tr);
            });
        }
 
        function filtrarGrafica() {
            const fechaIni = document.getElementById('fecha_ini').value;
            const fechaFin = document.getElementById('fecha_fin').value;

            if (fechaIni && fechaFin && new Date(fechaIni) > new Date(fechaFin)) {
                alert('La fecha de inicio no puede ser mayor a la fecha final');
                return;
            }
            
            const params = new URLSearchParams();
            if (fechaIni) params.append('fecha_ini', fechaIni);
            if (fechaFin) params.append('fecha_fin', fechaFin);
    
            fetch(`../ajax/get_nutricion_data.php?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    actualizarGrafica(data);
                })
                .catch(error => console.error('Error al filtrar:', error));
        }

        function resetFiltros() {
            document.getElementById('fecha_ini').value = '';
            document.getElementById('fecha_fin').value = '';
            filtrarGrafica();
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            actualizarGrafica(<?= json_encode($InfoNutric) ?>);
        });
    </script>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('TotalUsers').innerHTML = `<i class="fa-solid fa-user"></i> ${data.TotalUsers}`;
                    document.getElementById('TotalLicencias').innerHTML = `<i class="fa-solid fa-file-contract"></i> ${data.TotalLicencias}`;
                    document.getElementById('TotalSchools').innerHTML = `<i class="fa-solid fa-school"></i> ${data.TotalSchools}`;
                    document.getElementById('TotalProducts').innerHTML = `<i class="fa-solid fa-basket-shopping"></i> ${data.TotalProducts}`;
                })
                .catch(error => console.error('Error al obtener datos:', error));
        }

        function getUsers() {
            fetch('../ajax/get_users_limit.php')
                .then(response => response.json())
                .then(users => {
                    const tbody = document.querySelector('#table-users tbody')
                    tbody.innerHTML = '';
            
                    users.forEach(user => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${user.documento}</td>
                            <td>${user.nombre} ${user.apellido}</td>
                            <td class="d-none d-sm-table-cell">${user.email}</td>
                            <td>
                                <a class='btn btn-primary' href="directores/update_director.php?id=${user.documento}"><i class="fa-solid fa-pencil"></i></a>
                                <a class='btn btn-danger' href="directores/delete_director.php?id=${user.documento}"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los usuarios:', error));
        }

        function getProducts() {
            fetch('../ajax/get_products_limit.php')
                .then(response => response.json())
                .then(products => {
                    const tbody = document.querySelector('#table-products tbody')
                    tbody.innerHTML = '';
            
                    products.forEach(product => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${product.id_producto}</td>
                            <td>${product.nombre_prod}</td>
                            <td>${product.categoria}</td>
                            <td>
                                <a href="produtos/update_producto.php?id=${product.id_producto}" class="btn btn-primary"><i class="fa-solid fa-pencil"></i></a>
                                <a href="produtos/delete_producto.php?id=${product.id_producto}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los productos:', error));
        }
        // Cargar los datos al inicio
        document.addEventListener('DOMContentLoaded', function () {
            updateCounts();
            getUsers();
            getProducts();
        });
    </script>
</body>
</html>
