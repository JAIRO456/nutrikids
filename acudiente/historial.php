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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pagos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .card-header {
            background: #2c3e50;
            color: white;
            padding: 1rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table th, .table td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .table tr:hover {
            background: #f8f9fa;
            transition: background 0.3s ease;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: scale(1.05);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 800px;
            margin: 2rem auto;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 6px;
            background: #f8f9fa;
        }

        .cart-table {
            margin-top: 1rem;
        }

        .cart-table th {
            background: #2c3e50;
            color: white;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .btn-close:hover {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="card">
            <div class="card-header">Historial de Pagos</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Método de Pago</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagos AS $pago): ?>
                            <tr>
                                <td><?php echo $pago['id_pedidos']; ?></td>
                                <td><?php echo $pago['metodo']; ?></td>
                                <td><?php echo $pago['fecha_ini']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick='info(<?php echo $pago["id_pedidos"]; ?>)'>
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal" id="cartModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Información del Pedido</h2>
                    <button class="btn-close" onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="info-row">
                        <label>Menú:</label>
                        <p></p>
                    </div>
                    <div class="info-row">
                        <label>Estudiante:</label>
                        <p></p>
                    </div>
                    <div class="info-row">
                        <label>Fecha Inicio:</label>
                        <p></p>
                    </div>
                    <div class="info-row">
                        <label>Fecha Fin:</label>
                        <p></p>
                    </div>
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th>Productos</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="table-body"></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total:</td>
                                <td id="total-pedidos"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="vaciarCarrito()">Vaciar Carrito</button>
                    <button type="button" class="btn" onclick="closeModal()">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="checkout()">Pagar</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function closeModal() {
            document.getElementById('cartModal').style.display = 'none';
        }

        function showModal() {
            document.getElementById('cartModal').style.display = 'block';
        }

        function info(id_pedidos) {
            showModal();
            getInfo(id_pedidos);
        }

        function getInfo(id_pedidos) {
            fetch(`../ajax/get_info_pedidos.php?id_pedido=${id_pedidos}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = '';

                data.forEach(product => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <a href="informacion_nutricional.php?id_producto=${product.id_producto}" style="text-decoration:none; color:inherit;">
                                <img src="../img/products/${product.imagen_prod}" alt="${product.nombre_prod}" style="width:50px; height:50px; object-fit:cover;">
                                ${product.nombre_prod}
                            </a>
                        </td>
                        <td>${product.cantidad}</td>
                        <td>${product.precio}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="eliminarProducto(${product.id_producto})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
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