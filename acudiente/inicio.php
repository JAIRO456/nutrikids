<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../styles/inicio.css"> -->
</head>
<body>
    <main clase="container-main">
        <h2>Información de tus hijos</h2>

        <table class="table" id='table'>
            <thead>
                <tr>
                    <th class="dates">Imagen</th>
                    <th class="dates">Documento</th>
                    <th>Nombre</th>
                    <th>Menu</th>
                    <th class="dates">Estado</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </main>
</body>
<script>
    function getEstudiantes() {
        fetch('../ajax/info_hijos.php')
            .then(response => response.json())
            .then(estudiantes => {
                const tbody = document.querySelector('#table tbody')
                tbody.innerHTML = '';
        
                estudiantes.forEach(estudiante => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${estudiante.imagen_est}</td>
                        <td>${estudiante.documento_est}</td>
                        <td>${estudiante.nombre_est} ${estudiante.apellido_est}</td>
                        <td><a href="pedidos.php?id=${estudiante.documento_est}">menu</a></td>
                        <td>${estudiante.estado}</td>
                        <td><a href="informacion_usuario.php?id=${estudiante.documento_est}"><i class="info bi bi-info-circle-fill"></i></a>
                    `;
                    tbody.appendChild(tr);
                });
            })
        .catch(error => console.error('Error al obtener los estudiantes:', error));
    }

    setInterval(getEstudiantes, 1000);
</script>
</html>