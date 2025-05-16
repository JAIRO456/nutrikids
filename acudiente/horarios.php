<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    // include 'menu.php';

    $doc = $_SESSION['documento'];
    $sqlStudent = $con -> prepare("SELECT estudiantes.nombre, estudiantes.apellido, estudiantes.documento_est, estudiantes.nombre, estudiantes.imagen FROM detalles_estudiantes_escuela INNER JOIN estudiantes ON detalles_estudiantes_escuela.documento_est = estudiantes.documento_est
    INNER JOIN usuarios ON estudiantes.documento = usuarios.documento WHERE usuarios.documento = ?");
    $sqlStudent -> execute([$doc]);
    $Students = $sqlStudent -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Panel Admin</title> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Seleccione al Estudiante</h2>
                <div class="card m-2" style="width: 18rem;">
                    <?php foreach ($Students AS $student) {?>
                        <div class="d-flex flex-column-2 align-items-center">
                            <a href="pedidos.php?id_estudiante=<?= $student['documento_est']; ?>">
                                <img src="../img/users/<?= $student['imagen']; ?>">
                            </a>
                            <h3><?= $student['nombre']; ?><br><?= $student['apellido']; ?></h3>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>