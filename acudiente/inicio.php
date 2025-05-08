<?php
session_start(); // Asegúrate de iniciar la sesión
require_once('../conex/conex.php');

$conex = new database;
$con = $conex->conectar();

if (!isset($_SESSION['documento'])) {
    echo '<script>alert("No has iniciado sesión")</script>';
    echo '<script>window.location = "../login.html"</script>';
    exit();
}

    $sqlUser = $con->prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado INNER JOIN escuelas ON usuarios.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sqlUser->execute([$_SESSION['documento']]);
    $u = $sqlUser->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/inicio.css">
</head>
<body>
    <header class="container-header">
        <label for="" class="user"><?php echo $u['nombre']; ?> <?php echo $u['apellido']; ?>, <?php echo $u['rol']; ?>.</label>
        <a href="cuenta.php"><i class="icono bi bi-person-circle"></i></a>
    </header>

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