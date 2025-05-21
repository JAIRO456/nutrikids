<?php
    $doc = $_SESSION['documento'];
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado WHERE usuarios.documento = ?");
    $sql -> execute([$doc]);
    $u = $sql -> fetch();
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="inicio.php"><img src="../img/logo-nutrikids2.png" alt="" width="50px"> NUTRIKIDS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="inicio.php"><i class="bi bi-speedometer2"></i> Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categorias.php"><i class="bi bi-basket"></i> Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-clock"></i> Horarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> Ventas</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <li class="nav-item">
                            <a class="nav-link" href="cuenta.php"><i class="bi bi-person-circle"></i> <?= $u['rol']; ?>, <?= $u['nombre']; ?> <?= $u['apellido']; ?>.</a>
                        </li>
                        <li class="nav-item">   
                            <a class="nav-link" href="../include/logout.php"><i class="bi bi-box-arrow-right"></i> Salir</a>
                        </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html> 