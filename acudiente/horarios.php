<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $doc = $_SESSION['documento'];
    $sqlStudent = $con -> prepare("SELECT estudiantes.nombre, estudiantes.apellido, estudiantes.documento_est, estudiantes.imagen FROM detalles_estudiantes_escuela INNER JOIN estudiantes ON detalles_estudiantes_escuela.documento_est = estudiantes.documento_est
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
        <h2 class="text-center">Seleccione al Estudiante</h2>
        <?php if (empty($Students)) { ?>
            <div class="alert alert-info">No hay estudiantes asociados a este usuario.</div>
        <?php } else { ?>
        <div class="row">
            <?php foreach ($Students as $student) { ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="../img/users/<?php echo $student['imagen']; ?>" class="card-img-top" alt="Imagen del Estudiante" width="300" height="200">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $student['nombre'] . ' ' . $student['apellido']; ?></h5>
                        <p class="card-text">Documento: <?php echo $student['documento_est']; ?></p>
                        <a href="pedidos.php?id_estudiante=<?php echo $student['documento_est']; ?>" class="btn btn-primary">Ver Pedidos</a>
                    </div>
                </div>
            </div>
            <?php }} ?>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>