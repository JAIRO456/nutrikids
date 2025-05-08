<?php
    session_start();
    require_once('../../conex/conex.php');
    // include "adm_menu.html";
    // include "header_user.php";
    // include "../time.php";
    $conex =new Database;
    $con = $conex->conectar();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $id_tipo = $_POST['id_tipo'];
        $id_escuela = $_POST['id_escuela'];

        $sqlInsert = $con->prepare("INSERT INTO licencias (fecha_inicio, fecha_fin, id_tipo, id_escuela) VALUES (?, ?, ?, ?)");
        if ($sqlInsert->execute([$fecha_inicio, $fecha_fin, $id_tipo, $id_escuela])) {
            echo '<script>alert("Licencia registrada exitosamente")</script>';
            echo '<script>window.location = "../licencias.php"</script>';
        } 
        else {
            echo '<script>alert("Error al registrar la licencia")</script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Crear Licencia</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_tipo" class="form-label">Tipo de Licencia</label>
                            <select class="form-select" id="id_tipo" name="id_tipo" required>
                                <option value="">Seleccione un tipo de licencia</option>
                                <?php
                                    $sqlTipos = $con->prepare("SELECT * FROM tipo_licencia");
                                    $sqlTipos->execute();
                                    while ($tipo = $sqlTipos->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo['tipo'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_escuela" class="form-label">Escuela</label>
                            <select class="form-select" id="id_escuela" name="id_escuela" required>
                                <option value="">Seleccione una escuela</option>
                                <?php
                                    $sqlEscuelas = $con->prepare("SELECT * FROM escuelas");
                                    $sqlEscuelas->execute();
                                    while ($escuela = $sqlEscuelas->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $escuela['id_escuela'] . '">' . $escuela['nombre_escuela'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Registrar Licencia</button>
                        <a href="../licencias.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</body>
</html>