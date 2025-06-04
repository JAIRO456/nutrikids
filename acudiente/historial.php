<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $documento = $_SESSION['documento'];
    $sqlHistory = $con -> prepare('SELECT * FROM pedidos
    INNER JOIN metodos_pago ON pedidos.id_met_pago = metodos_pago.id_met_pago
    INNER JOIN estados ON pedidos.id_estado = estados.id_estado
    WHERE pedidos.documento = ?');
    $sqlHistory -> execute([$documento]);
    $pagos = $sqlHistory -> fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-2">
        <div class="card">
            <div class="card-header text-center">Historial de Pagos</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <!-- <th>Menú</th>
                            <th>Monto</th> -->
                            <th>Método de Pago</th>
                            <th>Fecha</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php foreach ($pagos AS $pago): ?>
                            <tr>
                                <td><?php echo $pago['id_pedidos']; ?></td>
                                
                                <!-- <td><?php // echo number_format($pago['monto'], 2); ?></td> -->
                                <td><?php echo $pago['metodo']; ?></td>
                                <td><?php echo $pago['fecha_ini']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger cart-button" id='info' data-bs-toggle="modal" data-bs-target="#cartModal" onclick='info(<?php echo $pago["id_pedidos"]; ?>)'>
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartModalLabel">Informacion del Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <label>Menu:</label>
                            <p></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label>Estudiante:</label>
                            <p></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label>Fecha Inicio:</label>
                            <p></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label>Fecha Fin:</label>
                            <p></p>
                        </div>
                        <div class="table-responsive">
                            <table class="table cart-table">
                                <thead class='text-center'>
                                    <tr>
                                        <th>Productos</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body" class='text-center'>

                                </tbody>
                                <tfoot class='text-center'>
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold">Total:</td>
                                        <td id="total-pedidos" class="fw-bold"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" onclick="vaciarCarrito()">Vaciar Carrito</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="checkout()">Pagar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
    <script>
        document.getElementById('info').addEventListener('click', function (e) {
            getInfo();
        });

        function getInfo(id_pedidos) {
            fetch('../ajax/get_info_pedidos.php?id_pedido=id_pedidos')
            .then(response => response.json())
            .then(data => {
                const div = document.getElementById('produts');
                const menu = document.getElementById('produts');
                div.innerHTML = '';

                data.forEach(product => {
                    const row = document.createElement('div');
                    row.innerHTML = `
                        <a href="informacion_nutricional.php?id_producto=${product.id_producto}" style="text-decoration:none; color:inherit;">
                            <img src="../img/products/${product.imagen_prod}" alt="${product.nombre_prod}">
                            <h3>${product.nombre_prod}</h3>
                            <p>${product.precio}</p>
                        </a>
                        <button type="button" onclick="agregarProducto(${product.id_producto}, '${product.nombre_prod}', '${product.precio}')" class="btn btn-primary">Agregar</button>
                    `;
                    div.appendChild(row);
                });
            })
            .catch(error => console.error('Error al obtener los produtos:', error));
        }
    </script>
</html>
<td><?php // echo $pago['menu']; ?></td>