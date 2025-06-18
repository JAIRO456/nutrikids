<?php
    session_start();
    require_once '../database/conex.php';
    require_once '../include/validate_sesion.php';
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $hoy = date('Y-m-d');
    $documento = $_SESSION['documento'];

    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    $sqlInfoNutriconal = $con->prepare("SELECT 
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
    WHERE DATE(pedidos.fecha_ini) = CURDATE() AND DATE(pedidos.fecha_fin) = CURDATE()
    GROUP BY producto.nombre_prod");
    $sqlInfoNutriconal->execute();
    $productos = $sqlInfoNutriconal->fetchAll(PDO::FETCH_ASSOC);

    $nombresProductos = [];
    $calorias = [];
    $proteinas = [];
    $carbohidratos = [];
    $grasas = [];
    $azucares = [];
    $sodios = [];
    
    foreach ($productos as $producto) {
        $nombresProductos[] = $producto['nombre_prod'];
        $calorias[] = $producto['total_cal'];
        $proteinas[] = $producto['total_pro'];
        $carbohidratos[] = $producto['total_car'];
        $grasas[] = $producto['total_gras'];
        $azucares[] = $producto['total_azu'];
        $sodios[] = $producto['total_sod'];
    }

    /* INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN detalles_menu ON detalles_menu.id_menu = menus.id_menu
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE detalles_menu.id_estado = 3 AND escuelas.id_escuela = ? */
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
            <h4>Distribución de Nutrientes</h4>
            <div style="height:350px;">
                <canvas id="nutriChart"></canvas>
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
        const productos = <?php echo json_encode($nombresProductos); ?>;
        const calorias = <?php echo json_encode($calorias); ?>;
        const proteinas = <?php echo json_encode($proteinas); ?>;
        const carbohidratos = <?php echo json_encode($carbohidratos); ?>;
        const grasas = <?php echo json_encode($grasas); ?>;
        const azucares = <?php echo json_encode($azucares); ?>;
        const sodios = <?php echo json_encode($sodios); ?>;

        const ctx = document.getElementById('nutriChart').getContext('2d'); // Configuración del gráfico
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productos,
                datasets: [
                    {
                        label: 'Calorías',
                        data: calorias,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Proteínas (g)',
                        data: proteinas,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Carbohidratos (g)',
                        data: carbohidratos,
                        backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Grasas (g)',
                        data: grasas,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Azucares (g)',
                        data: azucares,
                        backgroundColor: 'rgba(113, 248, 165, 0.7)',
                        borderColor: 'rgb(83, 206, 124)',
                        borderWidth: 1
                    },{
                        label: 'Sodios (g)',
                        data: sodios,
                        backgroundColor: 'rgba(241, 183, 34, 0.7)',
                        borderColor: 'rgb(250, 185, 20)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: false, // Para barras agrupadas
                        title: {
                            display: true,
                            text: 'Productos'
                        }
                    },
                    y: {
                        stacked: false, // Para barras agrupadas
                        title: {
                            display: true,
                            text: 'Cantidad'
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Información Nutricional por Producto (Hoy)'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
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
