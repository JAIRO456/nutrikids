<?php
    session_start();
    require_once('../../conex/conex.php');
<<<<<<< HEAD
    require_once('../../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include '../menu.php';

=======
    // include "adm_menu.html";
    // include "header_user.php";
    // include "../time.php";
    $conex =new Database;
    $con = $conex->conectar();

>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    $id_licencia = $_GET['id'];
    $sqlLicencia = $con -> prepare("SELECT * FROM licencias 
    INNER JOIN tipo_licencia ON licencias.id_tipo = tipo_licencia.id_tipo 
    INNER JOIN escuelas ON licencias.id_escuela = escuelas.id_escuela
    WHERE id_licencia = ?");
    $sqlLicencia -> execute([$id_licencia]);
    $licencia = $sqlLicencia -> fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $id_tipo = $_POST['id_tipo'];
        $id_escuela = $_POST['id_escuela'];

        $sqlUpdate = $con->prepare("UPDATE licencias SET fecha_inicio = ?, fecha_fin = ?, id_tipo = ?, id_escuela = ? WHERE id_licencia = ?");
        if ($sqlUpdate->execute([$fecha_inicio, $fecha_fin, $id_tipo, $id_escuela, $id_licencia])) {
            echo '<script>alert("Licencia actualizada exitosamente")</script>';
            echo '<script>window.location = "../licencias.php"</script>';
        } 
        else {
            echo '<script>alert("Error al actualizar la licencia")</script>';
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<<<<<<< HEAD
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Actualizar Licencia</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $licencia['fecha_inicio']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $licencia['fecha_fin']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="id_tipo" class="form-label">Tipo de Licencia</label>
                            <select class="form-select" id="id_tipo" name="id_tipo">
                                <?php
                                    $sqlTipos = $con->prepare("SELECT * FROM tipo_licencia");
                                    $sqlTipos->execute();
                                    while ($tipo = $sqlTipos->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $tipo['id_tipo'] . '"' . ($tipo['id_tipo'] == $licencia['id_tipo'] ? ' selected' : '') . '>' . $tipo['tipo'] . '</option>';
                                    }
<<<<<<< HEAD
                                    ?>
=======
                                ?>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_escuela" class="form-label">Escuela</label>
                            <select class="form-select" id="id_escuela" name="id_escuela">
                                <?php
                                    $sqlEscuelas = $con->prepare("SELECT * FROM escuelas");
                                    $sqlEscuelas->execute();
                                    while ($escuela = $sqlEscuelas->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $escuela['id_escuela'] . '"' . ($escuela['id_escuela'] == $licencia['id_escuela'] ? ' selected' : '') .
                                        '>' . $escuela['nombre_escuela'] . '</option>';
                                    }   
                                ?>
                            </select>
                        </div>
<<<<<<< HEAD
                        <div class="mb-3">
                            <label for="id_licencia" class="form-label">Code</label><br>
                            <svg id="barcode-<?= $licencia['id_licencia']; ?>"></svg>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger">Actualizar Licencia</button>
=======
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Actualizar Licencia</button>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
                            <a href="../licencias.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<<<<<<< HEAD
<script>
    JsBarcode("#barcode-<?= $licencia['id_licencia']; ?>", "<?= $licencia['id_licencia']; ?>", {
        format: "CODE128",
        width: 2,
        height: 40,
        displayValue: true
    });
</script>
=======
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</html>