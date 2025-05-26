<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento = $_SESSION['documento'];
        $dias = isset($_POST['dia']) ? $_POST['dia'] : [];
        $total_pedido = $_POST['total_pedido'];
        $metodo_pago = $_POST['id_met_pago'];
        $fecha_ini = $_POST['fecha_ini'];
        $fecha_fin = $_POST['fecha_fin'];

        $sqlInsertPedidos = $con->prepare("INSERT INTO pedidos (dia, documento, total_pedido, id_met_pago, fecha_ini, fecha_fin, id_estado)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
        $sqlInsertPedidos->execute([$dias, $documento, $total_pedido, $metodo_pago, $fecha_ini, $fecha_fin, 1]);

        if ($stmt->execute()) {
            $mensaje = "Pago registrado exitosamente";
        } 
        else {
            $mensaje = "Error al registrar el pago";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link rel="stylesheet" href="../styles/inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-4">
        <div class="card">
            <div class="card-header">Historial de Pagos</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Menú</th>
                            <th>Monto</th>
                            <th>Método de Pago</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pago = $pagos->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $pago['id']; ?></td>
                                <td><?php echo $pago['menu']; ?></td>
                                <td><?php echo number_format($pago['monto'], 2); ?></td>
                                <td><?php echo $pago['metodo_pago']; ?></td>
                                <td><?php echo $pago['fecha']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>