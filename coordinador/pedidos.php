<?php
    session_start();
    require_once('../conex/conex.php');
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
        else {
            $p = [];
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
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Pedidos</h2>
                    <select class="form-select" id="select-dias" name="dias" onchange="this.form.submit()">
                        <option value="">Seleccione un pedido</option>
                        <?php
                            $sqlDias = $con -> prepare("SELECT * FROM pedidos");
                            $sqlDias -> execute();
                        
                            foreach ($sqlDias as $dia): ?>
                            <option value="<?= $dia['id_pedidos']; ?>"><?= $dia['dia']; ?></option>
                        <?php endforeach; ?>
                    </select>         
                </div>
                <div class="col-md-12">
                    <h2 class="text-center">Menu</h2>
                    <table class="table table-bordered table-striped" id="table-menus">
                        <thead class="table-dark">
                            <tr>
                                <th>PRODUCTOS</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            if (!empty($p)) {
                                foreach ($Pedidos as $products) {
                        ?>
                                <tr>
                                    <td><?= $products['nombre_prod']; ?></td>
                                    <td><?= $products['cantidad']; ?></td>
                                    <td><?= $precio = $products['cantidad'] * $products['precio']; ?></td> 
                                </tr>
                                
                                
                                
                        <?php } 
                        } 
                        else {
                            echo "<tr><td colspan='3'>No hay productos disponibles para el día seleccionado.</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
</html>