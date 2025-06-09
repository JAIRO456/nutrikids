<?php
    session_start();
    require_once '../conex/conex.php';
    require_once '../include/validate_sesion.php';
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    $sqlInfoNutriconal = $con->prepare("SELECT SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad) AS total_cal, 
    SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad) AS total_pro, 
    SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad) AS total_car, 
    SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad) AS total_gras, 
    SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad) AS total_azu, 
    SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad) AS total_sod FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN detalles_menu ON detalles_menu.id_menu = menus.id_menu
    INNER JOIN usuarios ON pedidos.documento = usuarios.documento
    INNER JOIN detalles_usuarios_escuela ON usuarios.documento = detalles_usuarios_escuela.documento
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE detalles_menu.id_estado = 3 AND escuelas.id_escuela = ?");
    $sqlInfoNutriconal->execute([$u['id_escuela']]);
    $resultado = $sqlInfoNutriconal->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <main class="container mt-2" style='background-color: #f3f4f6;'>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text display-4" id='TotalUsers'>
                            <i class="bi bi-person-fill"></i> 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Estudiantes</h5>
                        <p class="card-text display-4" id='TotalEstudiantes'>
                            <i class="bi bi-person-fill"></i> 
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger shadow">
                    <div class="card-body">
                        <h5 class="card-title">Ventas</h5>
                        <p class="card-text display-4" id='TotalVentas'>
                            <i class="bi bi-bar-chart"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white p-3 rounded shadow mb-2">
            <div class="justify-content-center align-items-center mb-2">
                <h2 class="text-center font-semibold mb-2">Reportes Nutricionales</h2>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <input type="date" id="fecha_ini" class="form-control" style="width: 300px;">
                    <input type="date" id="fecha_fin" class="form-control" style="width: 300px;">
                    <button onclick="filtrarGrafica()" class="btn btn-danger">Filtrar</button>
                    <button onclick="resetFiltros()" class="btn btn-secondary">Reset</button>
                </div>
                <div class="col-12 mt-2">
                    <h4 class="text-center font-semibold mt-2">Distribución de Nutrientes</h4>
                    <div style="height:350px;" class="d-flex justify-content-center">
                        <canvas id="nutrient" class="mt-2 text-center"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow mt-4">
            <div class="card-header">
                <h4 class='text-center'>Usuarios Recientes</h4>
            </div>
            <div class="card-body">
                <table class="table" id="table-users">
                    <thead class="text-center">
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th class="d-none d-sm-table-cell">Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="text-center"></tbody>
                </table>
            </div>
        </div>
        <div class="card shadow mt-4">
            <div class="card-header">
                <h4 class='text-center'>Estudiantes Recientes</h4>
            </div>
            <div class="card-body">
                <table class="table" id="table-students">
                    <thead class="text-center">
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th class="d-none d-sm-table-cell">Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="text-center"></tbody>
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
    
            fetch(`../ajax/get_nutricion_schools_data.php?${params.toString()}`) // Hacer la petición al servidor
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
                total_cal: <?= $resultado['total_cal'] ?? 0 ?>, // Usamos los datos         iniciales de PHP
                total_pro: <?= $resultado['total_pro'] ?? 0 ?>,
                total_car: <?= $resultado['total_car'] ?? 0 ?>,
                total_gras: <?= $resultado['total_gras'] ?? 0 ?>,
                total_azu: <?= $resultado['total_azu'] ?? 0 ?>,
                total_sod: <?= $resultado['total_sod'] ?? 0 ?>
            });
        });
    </script>
    <script>
        function updateCounts() {
            fetch('../ajax/get_counts2.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('TotalUsers').innerHTML = `<i class="bi bi-person-fill"></i> ${data.TotalUsers}`;
                    document.getElementById('TotalEstudiantes').innerHTML = `<i class="bi bi-house-fill"></i> ${data.TotalEstudiantes}`;
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
                            <td>${user.nombre}</td>
                            <td>${user.apellido}</td>
                            <td>${user.email}</td>
                            <td>
                                <a class='btn btn-primary' href='usuarios/update_users.php?id=${user.documento}'><i class='bi bi-pencil-square'></i></a>
                                <a class='btn btn-danger' href='usuarios/delete_users.php?id=${user.documento}'><i class='bi bi-trash'></i></a>
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
                            <td>${student.nombre}</td>
                            <td>${student.apellido}</td>
                            <td>${student.email}</td>
                            <td>
                                <a class='btn btn-primary' href="estudiantes/update_estudiantes.php?id=${student.documento_est}"><i class="bi bi-pencil-square"></i></a>
                                <a class='btn btn-danger' href="estudiantes/delete_estudiantes.php?id=${student.documento_est}"><i class="bi bi-trash"></i></a>
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
