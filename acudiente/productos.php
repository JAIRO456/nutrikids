<?php
    session_start();
    require_once('../conex/conex.php');
<<<<<<< HEAD
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
=======
    $conex =new Database;
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

    $sqlCategories = $con->prepare("SELECT * FROM categorias");
    $sqlCategories->execute();
    $c = $sqlCategories->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/productos.css">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <header class="container-header">
        <label for="" class="user"><?php echo $u['nombre']; ?> <?php echo $u['apellido']; ?>, <?php echo $u['rol']; ?>.</label>
        <a href="cuenta.php"><i class="icono bi bi-person-circle"></i></a>
    </header>

    <main class="container-main">
        <section class="container1">
            <?php foreach ($c as $category){ ?>
                <div class="productos">
                    <a href="productos1.php?categoria=<?php echo $category['id_categoria']; ?>"><img src="../img/categories/<?php echo $category['imagen']; ?>" alt=""></a>
                    <h3><?php echo $category['categoria']; ?></h3>
                </div>
            <?php } ?>
        </section>
    </main>
</body>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</html>