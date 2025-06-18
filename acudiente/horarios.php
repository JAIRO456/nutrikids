<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $doc = $_SESSION['documento'];
    $sqlStudent = $con -> prepare("SELECT estudiantes.nombre, estudiantes.apellido, estudiantes.documento_est, estudiantes.imagen FROM estudiantes 
    INNER JOIN usuarios ON estudiantes.documento = usuarios.documento WHERE usuarios.documento = ?");
    $sqlStudent -> execute([$doc]);
    $Students = $sqlStudent -> fetchAll(PDO::FETCH_ASSOC);

    if (count($Students) === 1) {
        $student = $Students[0];
        echo "<script>window.location.href = 'pedidos.php?id_estudiante=" . $student['documento_est'] . "';</script>";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f3f4f6;
            padding-top: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .text-center {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
        }

        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            background-color: #e3f2fd;
            color: #0d47a1;
            border: 1px solid #bbdefb;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -0.5rem;
        }

        .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: #333;
        }

        .card-text {
            color: #666;
            margin-bottom: 1rem;
        }

        .btn-primary {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <main class="container">
        <h2 class="text-center">Seleccione al Estudiante</h2>
        <?php if (empty($Students)) { ?>
            <div class="alert">No hay estudiantes asociados a este usuario.</div>
        <?php } else { ?>
        <div class="row">
            <?php foreach ($Students as $student) { ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/users/<?php echo $student['imagen']; ?>" class="card-img-top" alt="Imagen del Estudiante">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $student['nombre'] . ' ' . $student['apellido']; ?></h5>
                        <p class="card-text">Documento: <?php echo $student['documento_est']; ?></p>
                        <a href="pedidos.php?id_estudiante=<?php echo $student['documento_est']; ?>" class="btn-primary">Ver Pedidos</a>
                    </div>
                </div>  
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </main>
</body>
</html>