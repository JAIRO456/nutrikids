<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $p = []; // Inicializar la variable para evitar errores si no hay resultados

    if (!empty($_GET['dia'])) {
        $idPedido = $_GET['dia'];
        try {
            // Consulta SQL para obtener los productos según el día
            $sqlPedidos = $con->prepare("SELECT producto.nombre_prod, detalles_menu.cantidad, detalles_menu.subtotal 
            FROM detalles_pedidos_producto 
            INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu 
            INNER JOIN detalles_menu ON detalles_menu.id_menu = menus.id_menu 
            INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto 
            INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos 
            WHERE pedidos.dia = ?");
            $sqlPedidos->execute([$idPedido]);
            $p = $sqlPedidos->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
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
    <main class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Pedidos</h2>
                <form method="GET" action="">
                    <select name="dia" id="dia" class="form-select mb-3" required>
                        <option value="">Seleccione un Dia</option>
                        <option value="lunes">Lunes</option>
                        <option value="martes">Martes</option>
                        <option value="miercoles">Miercoles</option>
                        <option value="jueves">Jueves</option>
                        <option value="viernes">Viernes</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Ver Productos</button>
                </form>

                <table class="table table-bordered table-striped mt-4">
                    <thead class="table-dark">
                        <tr>
                            <th>Productos</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($p)) : ?>
                            <?php foreach ($p as $menu) : ?>
                                <tr>
                                    <td><?php echo $menu['nombre_prod']; ?></td>
                                    <td><?php echo $menu['cantidad']; ?></td>
                                    <td><?php echo $menu['subtotal']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="5" class="text-center">No hay productos para mostrar.</td></tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total:</strong></td>
                            <td><?php echo array_sum(array_column($p, 'subtotal')); ?></td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </main>>

    </main>
</body>
</html>
