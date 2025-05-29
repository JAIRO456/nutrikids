<?php
<<<<<<< HEAD
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
=======
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
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>INICIO</title>
    <link rel="stylesheet" href="../styles/inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Estudiantes</h2>
                <table class="table table-bordered table-striped" id="table-students">
                    <thead class="table-dark">
                        <tr>
                            <th>Documento</th>
                            <th>Apellidos</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
    <script>
        function getStudents() {
            fetch('../ajax/get_estudiantes.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-students tbody')
                    tbody.innerHTML = '';
            
                    data.forEach(student => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${student.documento_est}</td>
                            <td>${student.apellido}</td>
                            <td>${student.nombre}</td>
                            <td>${student.email}</td>
                            <td>
                                <a class='btn btn-primary' href="estudiantes/update_students.php?id=${student.documento_est}"><i class="bi bi-pencil-square"></i></a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error al obtener los Estudiantes:', error));
        }
        setInterval(function () {
            getStudents();
        }, 3000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
=======
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
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</html>