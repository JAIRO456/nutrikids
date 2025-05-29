<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    if (isset($_GET['id'])) {
        $id_pedido = addslashes($_GET['id']);

        if (isset($_POST['dias'])) {
            $idPedido = $_GET['pedidos'];
            $sqlPedidos = $con->prepare("SELECT * FROM detalles_pedidos_producto
            INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
            INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
            INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
            INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
            INNER JOIN estados ON pedidos.id_estado = estados.id_estado WHERE pedidos.id_pedidos = ?");
            $sqlPedidos->execute([$idPedido]);
            $Pedidos = $sqlPedidos->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container mt-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <a class="nav-link" href="vendedor.php" class="text-white">
                            <h5 class="card-title">Vendedor</h5> 
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <a class="nav-link" href="acudientes.php" class="text-white">
                            <h5 class="card-title">Acudientes</h5> 
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <a class="nav-link" href="estudiantes.php" class="text-white">
                            <h5 class="card-title">Estudiantes</h5>
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </div>
                </div>
            </div>        
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>