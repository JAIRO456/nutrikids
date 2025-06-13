<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    // require_once('../time.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $sqlInfoNutriconal = $con -> prepare("SELECT SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad) AS total_cal, 
    SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad) AS total_pro, 
    SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad) AS total_car, 
    SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad) AS total_gras, 
    SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad) AS total_azu, 
    SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad) AS total_sod FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto");
    $sqlInfoNutriconal -> execute();
    $InfoNutric = $sqlInfoNutriconal -> fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo-nutrikids2.png" type="image/png">
    <title>Inicio</title>
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
            margin-top: 100px;
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
            background: var(--primary-color);
            color: white;
        }

        .btn-secondary {
            background: var(--secondary-color);
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
            border-collapse: collapse;
            margin: 1rem 0;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
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
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="grid">
            <div class="stat-card">
                <h5>Directores</h5>
                <p class="number" id="TotalUsers">
                    <i class="bi bi-person-fill"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Licencias Activas</h5>
                <p class="number" id="TotalLicencias">
                    <i class="bi bi-file-earmark-check-fill"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Escuelas</h5>
                <p class="number" id="TotalSchools">
                    <i class="bi bi-house-fill"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Productos</h5>
                <p class="number" id="TotalProducts">
                    <i class="bi bi-basket"></i>
                </p>
            </div>
        </div>

        <div class="report-section">
            <h2>Reportes Nutricionales</h2>
            <div class="filter-controls">
                <input type="date" id="fecha_ini" class="input-date">
                <input type="date" id="fecha_fin" class="input-date">
                <button onclick="filtrarGrafica()" class="btn btn-primary">Filtrar</button>
                <button onclick="resetFiltros()" class="btn btn-secondary">Reset</button>
            </div>
            <h4>Distribución de Nutrientes</h4>
            <div style="height:350px;">
                <canvas id="nutrient"></canvas>
            </div>
        </div>
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
        let nutrientChart; // Declara la variable global para el gráfico
     
        function actualizarGrafica(datos) { // Función para inicializar o actualizar el gráfico
            const ctx = document.getElementById('nutrient').getContext('2d');
       
            if (nutrientChart) {
                nutrientChart.destroy(); // Si ya existe un gráfico, lo destruimos antes de crear uno nuevo
            }

            nutrientChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Calorias', 'Proteínas', 'Carbohidratos', 'Grasas', 'Azucares', 'Sodio'],
                    datasets: [{
                        data: [datos.total_cal, datos.total_pro, datos.total_car, datos.total_gras, datos.total_azu, datos.total_sod],
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                    }]
                },
                options: {
                    responsive: true,
                }
            });
        }
 
        function filtrarGrafica() { // Función para filtrar la gráfica
            const fechaIni = document.getElementById('fecha_ini').value;
            const fechaFin = document.getElementById('fecha_fin').value;

            if (fechaIni && fechaFin && new Date(fechaIni) > new Date(fechaFin)) { 
                alert('La fecha de inicio no puede ser mayor a la fecha final'); // Validación básica de fechas
                return;
            }
            
            const params = new URLSearchParams(); // Crear objeto con los parámetros de filtro
            if (fechaIni) params.append('fecha_ini', fechaIni);
            if (fechaFin) params.append('fecha_fin', fechaFin);
    
            fetch(`../ajax/get_nutricion_data.php?${params.toString()}`) // Hacer la petición al servidor
                .then(response => response.json())
                .then(data => {
                    actualizarGrafica(data);
                })
                .catch(error => console.error('Error al filtrar:', error));
        }

        function resetFiltros() { // Función para resetear los filtros
            document.getElementById('fecha_ini').value = '';
            document.getElementById('fecha_fin').value = '';
            filtrarGrafica(); // Esto cargará los datos sin filtros
        }
        
        document.addEventListener('DOMContentLoaded', function() { // Inicializar la gráfica al cargar la página      
            actualizarGrafica({
                total_cal: <?= $InfoNutric['total_cal'] ?? 0 ?>, // Usamos los datos iniciales de PHP
                total_pro: <?= $InfoNutric['total_pro'] ?? 0 ?>,
                total_car: <?= $InfoNutric['total_car'] ?? 0 ?>,
                total_gras: <?= $InfoNutric['total_gras'] ?? 0 ?>,
                total_azu: <?= $InfoNutric['total_azu'] ?? 0 ?>,
                total_sod: <?= $InfoNutric['total_sod'] ?? 0 ?>
            });
        });
    </script>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('TotalUsers').innerHTML = `<i class="bi bi-person-fill"></i> ${data.TotalUsers}`;
                    document.getElementById('TotalLicencias').innerHTML = `<i class="bi bi-file-earmark-check-fill"></i> ${data.TotalLicencias}`;
                    document.getElementById('TotalSchools').innerHTML = `<i class="bi bi-house-fill"></i> ${data.TotalSchools}`;
                    document.getElementById('TotalProducts').innerHTML = `<i class="bi bi-basket"></i> ${data.TotalProducts}`;
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
                                <a class='btn btn-primary' href="directores/update_director.php?id=${user.documento}"><i class="bi bi-pencil-square"></i></a>
                                <a class='btn btn-danger' href="directores/delete_director.php?id=${user.documento}"><i class="bi bi-trash"></i></a>
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
                                <a href="produtos/update_producto.php?id=${product.id_producto}" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                <a href="produtos/delete_producto.php?id=${product.id_producto}" class="btn btn-danger"><i class="bi bi-trash"></i></a>
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
