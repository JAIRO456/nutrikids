<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $listPedidos = [];
    $total = 0;
    if (isset($_GET['id_estudiante'])) {
        $id_estudiante = addslashes($_GET['id_estudiante']);
        $sqlPedidos = $con->prepare("SELECT producto.nombre_prod, detalles_pedidos_producto.cantidad, detalles_pedidos_producto.subtotal 
        FROM detalles_pedidos_producto
        INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
        INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu 
        INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto 
        INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
        WHERE estudiantes.documento_est = ?");
        $sqlPedidos->execute([$id_estudiante]);
        while ($row = $sqlPedidos->fetch(PDO::FETCH_ASSOC)) {
            $listPedidos[] = $row;
            $total += floatval($row['subtotal']);
        }
    }
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
                <h2 class="text-center">Horarios</h2>
                <?php foreach ($listPedidos AS $menus) {?>
                    <table class="table table-bordered table-striped mt-4" id="table-pedidos">
                        <thead class="table-dark">
                            <tr>
                                <th>Productos</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                            <tr>
                                <td><?= $menus['nombre_prod']; ?></td>
                                <td><?= $menus['cantidad']; ?></td>
                                <td><?= $menus['subtotal']; ?></td>
                            </tr>
                        </thead>
                    </table>
                <?php } ?>
            </div>
        </div>
    </main>
</body>
</html>