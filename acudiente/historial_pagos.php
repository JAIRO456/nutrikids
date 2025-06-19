<?php
    session_start();
    require_once('../database/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    $documento = $_SESSION['documento'];
    $sqlHistory = $con -> prepare('SELECT DISTINCT menus.id_menu, pedidos.total_pedido, metodos_pago.metodo, pedidos.fecha_ini, pedidos.id_pedidos, pedidos.dia, pedidos.archivo FROM pedidos
    INNER JOIN detalles_pedidos_producto ON pedidos.id_pedidos = detalles_pedidos_producto.id_pedido
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
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
            padding-top: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
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
            overflow-x: auto;
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
            /* white-space: nowrap; */
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

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                overflow-x: auto;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .table th, .table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
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
                            <th>Día(s)</th>
                            <th>Total</th>
                            <th>Método de Pago</th>
                            <th>Fecha</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagos AS $pago): ?>
                            <tr>
                                <td><?php echo $pago['id_pedidos']; ?></td>
                                <td><?php echo $pago['dia']; ?></td>
                                <td><?php echo $pago['total_pedido']; ?></td>
                                <td><?php echo $pago['metodo']; ?></td>
                                <td><?php echo $pago['fecha_ini']; ?></td>
                                <td><button onclick="window.open('../PDF/<?php echo $pago['archivo']; ?>')" class="btn btn-primary">Ver Factura</button></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>