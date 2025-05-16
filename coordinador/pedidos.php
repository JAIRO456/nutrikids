<?php
session_start();
require_once('../conex/conex.php');
require_once('../include/validate_sesion.php');
$conex = new Database;
$con = $conex->conectar();

include 'menu.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <main class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Pedidos</h2>
                <form method="GET" action="">
                    <select name="dia" id="dia" class="form-select mb-3" required>
                        <option value="">Seleccione un Día</option>
                        <option value="lunes">Lunes</option>
                        <option value="martes">Martes</option>
                        <option value="miercoles">Miércoles</option>
                        <option value="jueves">Jueves</option>
                        <option value="viernes">Viernes</option>
                    </select>
                </form>

                <table class="table table-bordered table-striped mt-4" id="table-pedidos">
                    <thead class="table-dark">
                        <tr>
                            <th>Productos</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="3">Seleccione un día para ver los pedidos</td></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Total:</td>
                            <td id="total-pedidos" class="fw-bold"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('dia').addEventListener('change', function () {
            const dia = this.value;
            if (dia) {
                getPedidos(dia);
            } 
            else {
                const tbody = document.querySelector('#table-pedidos tbody');
                tbody.innerHTML = '<tr><td colspan="3">Seleccione un día para ver los pedidos</td></tr>';
                document.getElementById('total-pedidos').textContent = '';
            }
        });

        function getPedidos(dia) {
            fetch(`../ajax/get_pedidos.php?dia=${encodeURIComponent(dia)}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-pedidos tbody');
                    const totalCell = document.getElementById('total-pedidos');
                    tbody.innerHTML = '';
                    totalCell.textContent = '';

                    if (data.error) {
                        tbody.innerHTML = `<tr><td colspan="3">${data.error}</td></tr>`;
                    } 
                    else if (data.pedidos.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="3">No hay pedidos para este día</td></tr>';
                    } 
                    else {
                        data.pedidos.forEach(pedido => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${pedido.nombre_prod}</td>
                                <td>${pedido.cantidad}</td>
                                <td>${pedido.subtotal}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                        totalCell.textContent = `$${data.total}`;
                    }
                })
                .catch(error => {
                    console.error('Error al obtener el Pedido:', error);
                    const tbody = document.querySelector('#table-pedidos tbody');
                    tbody.innerHTML = '<tr><td colspan="3">Error al cargar los pedidos. Inténtelo de nuevo.</td></tr>';
                    document.getElementById('total-pedidos').textContent = '';
                });
        }
    </script>
</body>
</html>

try {
        $listHorarios = [];
        $total = 0;
        $sqlHorarios = $con->prepare("SELECT producto.nombre_prod, detalles_pedidos_producto.cantidad, detalles_pedidos_producto.subtotal
        FROM detalles_pedidos_producto
        INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
        INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
        INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
        INNER JOIN detalles_estudiantes_escuela ON pedidos.id_detalle_estudiante = detalles_estudiantes_escuela.id_detalle_estudiante
        WHERE detalles_estudiantes_escuela.documento_est = ?");
        $sqlHorarios->execute([$id_estudiante]);
        while ($row = $sqlHorarios->fetch(PDO::FETCH_ASSOC)) {
            $listHorarios[] = $row;
            $total += floatval($row['subtotal']);
        }
        echo json_encode([
            'horarios' => $listHorarios,
            'total' => number_format($total, 2, '.', '')
        ]);
    } 
    catch (PDOException $e) {
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        exit;
    }