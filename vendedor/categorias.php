<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $sqlCategories = $con -> prepare("SELECT * FROM categorias");
    $sqlCategories -> execute();
    $Categories = $sqlCategories -> fetchALL(PDO::FETCH_ASSOC);
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
    <main class="container mt-2">
        <h1 class="mb-4 text-center">Categorías</h1>
        <div class="row">
            <?php foreach ($Categories as $Category) { ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="../img/categories/<?= $Category['imagen']; ?>" class="card-img-top" alt="<?= $Category['categoria']; ?>" width="300" height="200">
                        <div class="card-body d-flex justify-content-center">
                            <a href="productos.php?id_categoria=<?= $Category['id_categoria']; ?>" class="btn btn-primary">
                                <h5 class="card-title"><?= $Category['categoria']; ?></h5>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>