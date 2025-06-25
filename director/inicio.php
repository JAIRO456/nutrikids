<?php
    session_start();
    require_once '../database/conex.php';
    require_once '../include/validate_sesion.php';
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $documento = $_SESSION['documento'];

    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);
    $id_escuela = $u['id_escuela'];

    $sqlInfoNutriconal = $con -> prepare("SELECT 
    SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad) AS total_cal, 
    SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad) AS total_pro, 
    SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad) AS total_car, 
    SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad) AS total_gras, 
    SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad) AS total_azu, 
    SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad) AS total_sod 
    FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN detalles_menu ON menus.id_menu = detalles_menu.id_menu
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE pedidos.fecha_ini = CURDATE() AND pedidos.fecha_fin = CURDATE() AND pedidos.id_estado = 6 AND escuelas.id_escuela = ? AND detalles_menu.id_estado = 3");
    $sqlInfoNutriconal -> execute([$id_escuela]);
    $InfoNutric = $sqlInfoNutriconal -> fetchAll(PDO::FETCH_ASSOC);
    
    // Inicializar valores por defecto
    $total_calorias = 0;
    $total_proteinas = 0;
    $total_carbohidratos = 0;
    $total_grasas = 0;
    $total_azucares = 0;
    $total_sodio = 0;

    // Si hay datos, tomar el primer registro (ya que son SUMs)
    if (!empty($InfoNutric)) {
        $total_calorias = $InfoNutric[0]['total_cal'] ?? 0;
        $total_proteinas = $InfoNutric[0]['total_pro'] ?? 0;
        $total_carbohidratos = $InfoNutric[0]['total_car'] ?? 0;
        $total_grasas = $InfoNutric[0]['total_gras'] ?? 0;
        $total_azucares = $InfoNutric[0]['total_azu'] ?? 0;
        $total_sodio = $InfoNutric[0]['total_sod'] ?? 0;
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

        .report-section {
            margin-bottom: 30px;
            background-color: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .report-section h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .report-section h4 {
            color: #666;
            margin-bottom: 20px;
        }
        .chart-container {
            height: 400px;
            width: 100%;
            margin: 20px 0;
        }
        .filtros {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .filtros label {
            margin-right: 10px;
            font-weight: bold;
        }
        .filtros input {
            padding: 5px 10px;
            margin-right: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        .filtros button {
            padding: 5px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
        }
        .filtros button:hover {
            background-color: #0056b3;
        }
        .no-data {
            text-align: center;
            padding: 50px;
            color: #666;
            font-style: italic;
        }
        .debug-info {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 12px;
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
            margin: 1rem 0;
            border: 1px solid #ddd;
            background: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
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
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="grid">
            <div class="stat-card">
                <h5>Usuarios</h5>
                <p class="number" id="TotalUsers">
                    <i class="fa-solid fa-user"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Estudiantes</h5>
                <p class="number" id="TotalEstudiantes">
                    <i class="fa-solid fa-user"></i>
                </p>
            </div>
            <div class="stat-card">
                <h5>Ventas</h5>
                <p class="number" id="TotalVentas">
                    <i class="fa-solid fa-chart-bar"></i>
                </p>
            </div>
        </div>

        <div class="report-section">
            <h2>Reportes Nutricionales</h2>       
            <div class="debug-info">
                <strong>Debug:</strong> Fecha actual: <?php echo date('Y-m-d'); ?> | 
                Datos encontrados: <?php echo count($InfoNutric); ?> registros
            </div>          
            <div class="filtros">
                <label for="fecha_ini">Fecha Inicio:</label>
                <input type="date" id="fecha_ini" name="fecha_ini">
                <label for="fecha_fin">Fecha Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin">
                <button onclick="filtrarGrafica()">Filtrar</button>
                <button onclick="resetFiltros()">Resetear</button>
            </div>
            <div class="chart-container">
                <canvas id="nutrient"></canvas>
            </div>
            <div id="no-data-message" class="no-data" style="display: none;">
                No hay datos nutricionales disponibles para el período seleccionado.
            </div>
        </div>

        <div class="report-section">
            <h4>Usuarios Recientes</h4>
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
            <h4>Estudiantes Recientes</h4>
            <div class="table-container">
                <table id="table-students">
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
    </main>
</body>
    <script>
        // Variables globales
        const id_escuela = <?php echo json_encode($id_escuela); ?>;
        let nutrientChart;

        // --- DATOS INICIALES ---
        const datosIniciales = {
            calorias: <?php echo json_encode($total_calorias); ?>,
            proteinas: <?php echo json_encode($total_proteinas); ?>,
            carbohidratos: <?php echo json_encode($total_carbohidratos); ?>,
            grasas: <?php echo json_encode($total_grasas); ?>,
            azucares: <?php echo json_encode($total_azucares); ?>,
            sodio: <?php echo json_encode($total_sodio); ?>
        };
        
        console.log('Datos iniciales:', datosIniciales);
     
        function actualizarGrafica(datos) {
            const ctx = document.getElementById('nutrient').getContext('2d');
            const noDataMessage = document.getElementById('no-data-message');

            if (nutrientChart) {
                nutrientChart.destroy();
            }

            // Verificar si hay datos
            const valores = [
                datos.calorias || 0, datos.proteinas || 0, datos.carbohidratos || 0,
                datos.grasas || 0, datos.azucares || 0, datos.sodio || 0
            ];

            console.log('Valores para la gráfica:', valores);

            const tieneDatos = valores.some(valor => valor > 0);
            if (!tieneDatos) {
                noDataMessage.style.display = 'block';
                return;
            }

            noDataMessage.style.display = 'none';

            nutrientChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Calorías', 'Proteínas', 'Carbohidratos', 'Grasas', 'Azúcares', 'Sodio'],
                    datasets: [{
                        label: 'Valores Totales',
                        data: valores,
                        backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
            });
        }

        function filtrarGrafica() {
            const fechaIni = document.getElementById('fecha_ini').value;
            const fechaFin = document.getElementById('fecha_fin').value;

            if (fechaIni && fechaFin && new Date(fechaIni) > new Date(fechaFin)) {
                alert('La fecha de inicio no puede ser mayor a la fecha final');
                return;
            }
            const params = new URLSearchParams({ id_escuela });
            if (fechaIni) params.append('fecha_ini', fechaIni);
            if (fechaFin) params.append('fecha_fin', fechaFin);
            fetch(`../ajax/get_nutricion_data.php?${params.toString()}`)
                .then(response => response.json())
                .then(data => actualizarGrafica(data))
                .catch(error => console.error('Error al filtrar nutrición:', error));
        }

        function resetFiltros() {
            document.getElementById('fecha_ini').value = '';
            document.getElementById('fecha_fin').value = '';
            actualizarGrafica(datosIniciales);
        }
    </script>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts2.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('TotalUsers').innerHTML = `<i class="fa-solid fa-user"></i> ${data.TotalUsers}`;
                    document.getElementById('TotalEstudiantes').innerHTML = `<i class="fa-solid fa-user"></i> ${data.TotalEstudiantes}`;
                })
                .catch(error => console.error('Error al obtener datos:', error));
        }

        function getUsers() {
            fetch('../ajax/get_users2.php')
                .then(response => response.json())
                .then(users => {
                    const tbody = document.querySelector('#table-users tbody')
                    tbody.innerHTML = '';
            
                    users.forEach(user => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${user.documento}</td>
                            <td>${user.nombre} ${user.apellido}</td>
                            <td>${user.email}</td>
                            <td>
                                <a class='btn btn-primary' href='usuarios/update_users.php?id=${user.documento}'><i class='fa-solid fa-pencil'></i></a>
                                <a class='btn btn-danger' href='usuarios/delete_users.php?id=${user.documento}'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los usuarios:', error));
        }

        function getStudents() {
            fetch('../ajax/get_student2.php')
                .then(response => response.json())
                .then(users => {
                    const tbody = document.querySelector('#table-students tbody')
                    tbody.innerHTML = '';
            
                    users.forEach(student => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${student.documento_est}</td>
                            <td>${student.nombre} ${student.apellido}</td>
                            <td>${student.email}</td>
                            <td>
                                <a class='btn btn-primary' href="estudiantes/update_estudiantes.php?id=${student.documento_est}"><i class="fa-solid fa-pencil"></i></a>
                                <a class='btn btn-danger' href="estudiantes/delete_estudiantes.php?id=${student.documento_est}"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
            .catch(error => console.error('Error al obtener los estudiantes:', error));
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateCounts();
            getUsers();
            getStudents();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>
