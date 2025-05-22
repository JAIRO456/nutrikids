<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $id_categoria = $_GET['id_categoria'];
    $sqlProduts = $con -> prepare("SELECT id_producto, nombre_prod, precio, imagen_prod FROM producto
    WHERE id_categoria = ?");
    $sqlProduts -> execute([$id_categoria]);
    $Produts = $sqlProduts -> fetchALL(PDO::FETCH_ASSOC);
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
    <style>
        .container-products {
            width: 200px;
            height: 200px;
            position: relative;
        }
        .container-name {
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 100%;
            background: none;
            color: white;
            display: none;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
        .container-products:hover .container-name {
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease;
            display: flex;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <main class="container mt-4">
        <?php if (empty($Produts)) { ?>
            <div class="alert alert-info">No hay Productos para esta categoria</div>
        <?php } else { ?>
        <?= include 'carrito.php'; ?>
        <div class="carrito mt-4" id="modal">
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-cart-fill"></i>
            </button>
        </div>
        <div class="row">
            <?php foreach ($Produts as $Produt) { ?>
                <div class="col-md-3 mb-3" id="producto">
                    <div class="container-products card">
                        <img src="../img/products/<?= $Produt['imagen_prod']; ?>" class="card-img-top" alt="<?= $Produt['nombre_prod']; ?>" width="100%" height="100%">
                        <div class="container-name card-body d-flex justify-content-center">
                            <a href="productos.php?id_producto=<?= $Produt['id_producto']; ?>" class="btn">
                                <h5 class="card-title"><?= $Produt['nombre_prod']; ?></h5>
                                <h6 class="card-title"><?= $Produt['precio']; ?></h6>
                            </a>
                        </div>
                        <button type="button" onclick="agregarProducto(<?= $Produt['id_producto']; ?>, '<?= $Produt['nombre_prod']; ?>', '<?= $Produt['precio']; ?>')" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            <?php }} ?>
        </div>
    </main>
</body>
<html>
<script>
    document.getElementById('modal').addEventListener('click', function () {
            actualizarCarrito();
            document.querySelector('.container-modal').style.display = 'block';
    });
    document.getElementById('close').addEventListener('click', function () {
        document.querySelector('.container-modal').style.display = 'none';
    });
</script>
</html>