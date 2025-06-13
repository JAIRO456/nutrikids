<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $documento = $_SESSION['documento'];
        $id_menu = $_POST['id_menu'];
        $documento_est = $_POST['documento_est'];
        $dias = !empty($_POST['dias']) ? json_decode($_POST['dias'], true) : [];
        $fecha_ini = $_POST['fecha_ini'];
        $fecha_fin = $_POST['fecha_fin'];
        // $monto = $_POST['monto'];
        $metodo_pago = $_POST['metodo_pago'];
        $productos = $productos = !empty($_POST['productos']) ? json_decode($_POST['productos'], true) : [];

        if (empty($id_menu) || empty($documento_est) || empty($dias) || empty($fecha_ini) || empty($fecha_fin) || empty($metodo_pago)) {
            echo "<script>alert('Por favor complete todos los campos requeridos.');</script>";
            echo "<script>location.href='pagos.php';</script>";
        } 
        else if (count($productos) == 0) {
            echo "<script>alert('No hay productos seleccionados.');</script>";
            echo "<script>location.href='pagos.php';</script>";
        }
        else {
            try {
                // Obtener el precio del menú
                $sqlMenu = $con->prepare("SELECT precio FROM menus WHERE id_menu = ?");
                $sqlMenu->execute([$id_menu]);
                $menu = $sqlMenu->fetch(PDO::FETCH_ASSOC);
                // Insertar en la tabla pagos
                $sqlInsertPedidos = $con->prepare("INSERT INTO pedidos (dia, documento, total_pedido, id_met_pago, fecha_ini, fecha_fin, id_estado)
                VALUES (?, ?, ?, ?, ?, ?, ?)");
                if ($sqlInsertPedidos->execute([implode(',', $dias), $documento, $menu['precio'], $metodo_pago, $fecha_ini, $fecha_fin, 1])) {
                    $id_pedido = $con->lastInsertId();
                    foreach ($productos as $producto) {
                        $id_producto = intval($producto['id_producto']);
                        $cantidad = intval($producto['cantidad']);
                        $precio = floatval($producto['precio']);
                        $subtotal = $precio * $cantidad;

                        $sql = $con->prepare("SELECT precio FROM producto WHERE id_producto = ?");
                        $sql->execute([$id_producto]);
                        $verif = $sql->fetch(PDO::FETCH_ASSOC);

                        if ($verif) {
                            $sqlInsertDetsMenu = $con->prepare("INSERT INTO detalles_pedidos_producto (id_pedido, documento_est, id_menu, id_producto, cantidad, subtotal)
                            VALUES (?, ?, ?, ?, ?, ?)");
                            $sqlInsertDetsMenu->execute([$id_pedido, $documento_est, $id_menu, $id_producto, $cantidad, $subtotal]);
                            echo "<script>alert('Pedido registrado exitosamente');</script>";
                            echo "<script>location.href='pagos.php';</script>";
                        } 
                        else {
                            throw new Exception("Product with ID $id_producto not found.");
                        }
                    }
                } 
                else {
                    throw new Exception("Error al registrar el pago");
                }
            } 
            catch (Exception $e) {
                $mensaje = "Error al registrar el pago: " . $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
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
            margin-top: 80px;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
            font-size: 2.5em;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: #2c3e50;
            color: white;
            padding: 15px 20px;
            font-size: 1.2em;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-col {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }

        select, input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        select:focus, input:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        tr:hover {
            background: #f5f5f5;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .total-row {
            font-weight: bold;
            background: #f8f9fa;
        }

        .error-message {
            color: #e74c3c;
            padding: 10px;
            background: #fde8e8;
            border-radius: 5px;
            margin: 10px 0;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
    <main class="container">
        <h1>Gestión de Pagos de Menús</h1>
        <form id="menuForm" method="POST" action="">
            <div class="card">
                <div class="card-header">Registrar Nuevo Pago</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-col">
                            <label for="id_menu">Menú</label>
                            <select id="id_menu" name="id_menu" required>
                                <option value="">Seleccione un menú</option>
                                <?php
                                    $documento = $_SESSION['documento'];
                                    $sqlMenus = $con->prepare("SELECT id_menu, nombre_menu FROM menus 
                                    INNER JOIN usuarios ON menus.documento = usuarios.documento
                                    WHERE usuarios.documento = ? ORDER BY menus.nombre_menu ASC");
                                    $sqlMenus->execute([$documento]);
                                    while ($row = $sqlMenus->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id_menu']}'>{$row['nombre_menu']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-col">
                            <label for="documento_est">Estudiante</label>
                            <select id="documento_est" name="documento_est" required>
                                <option value="">Seleccione un estudiante</option>
                                <?php
                                    $documento = $_SESSION['documento'];
                                    $sqlEstudiantes = $con->prepare("SELECT estudiantes.documento_est, estudiantes.nombre, estudiantes.apellido FROM estudiantes
                                    INNER JOIN usuarios ON estudiantes.documento = usuarios.documento
                                    WHERE usuarios.documento = ? ORDER BY estudiantes.nombre ASC");
                                    $sqlEstudiantes->execute([$documento]);
                                    while ($row = $sqlEstudiantes->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['documento_est']}'>{$row['nombre']} {$row['apellido']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="fecha_ini">Fecha Inicio</label>
                            <input type="date" id="fecha_ini" name="fecha_ini" required>
                        </div>
                        <div class="form-col">
                            <label for="fecha_fin">Fecha Fin</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="monto">Monto</label>
                            <input type="number" step="0.01" id="monto" name="monto">
                        </div>
                        <div class="form-col">
                            <label for="metodo_pago">Método de Pago</label>
                            <select id="metodo_pago" name="metodo_pago" required>
                                <option value="">Seleccione un método de pago</option>
                                <?php
                                    $sqlMetodos = $con->prepare("SELECT * FROM metodos_pago ORDER BY metodo ASC");
                                    $sqlMetodos->execute();
                                    while ($row = $sqlMetodos->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['id_met_pago']}'>{$row['metodo']}</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit">Registrar Pago</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Detalles del Menú Seleccionado</div>
                <input type="hidden" name="productos" id="productos">
                <input type="hidden" name="dias" id="dias">
                <div class="card-body">
                    <table id="table-pedidos">
                        <thead>
                            <tr>
                                <th>Productos</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="det_menu">
                            <tr>
                                <td colspan="3">Seleccione un menú para ver los detalles</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="2" style="text-align: right;">Total:</td>
                                <td id="total-pedidos"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </main>
</body>
<script>
    let selectedProducts = [];
    let selectedDays = [];

    window.addEventListener('DOMContentLoaded', function() {
        const diasGuardados = localStorage.getItem('selectedDays');
        if (diasGuardados) {
            document.getElementById('dias').value = diasGuardados;
        }
    });

    document.getElementById('id_menu').addEventListener('change', function() {
        const id_menu = this.value;
        const diasInput = document.getElementById('dias').value;
        let dias = [];
        try {
            dias = JSON.parse(diasInput);
        } catch (e) {
            dias = [];
        }
        const diasString = dias.join(',');

        selectedProducts = [];
        
        if (id_menu) {
            fetch(`../ajax/get_det_menu.php?id_menu=${encodeURIComponent(id_menu)}&dias=${encodeURIComponent(diasString)}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('det_menu');
                    tbody.innerHTML = '';
                    let total = 0;

                    if (data.error) {
                        tbody.innerHTML = `<tr><td colspan="3">${data.error}</td></tr>`;
                        return;
                    }

                    data.pedidos.forEach(pedido => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${pedido.nombre_prod}</td>
                            <td>${pedido.cantidad}</td>
                            <td>${pedido.subtotal}</td>
                        `;
                        tbody.appendChild(tr);
                        total += parseFloat(pedido.subtotal);

                        selectedProducts.push({
                            id_producto: pedido.id_producto,
                            nombre_prod: pedido.nombre_prod,
                            precio: parseFloat(pedido.precio),
                            cantidad: parseInt(pedido.cantidad)
                        });
                    });

                    document.getElementById('total-pedidos').textContent = total.toFixed(2);
                    document.getElementById('productos').value = JSON.stringify(selectedProducts);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('det_menu').innerHTML = '<tr><td colspan="3">Error al cargar los detalles</td></tr>';
                });
        } else {
            document.getElementById('det_menu').innerHTML = '<tr><td colspan="3">Seleccione un menú para ver los detalles</td></tr>';
            document.getElementById('total-pedidos').textContent = '';
            document.getElementById('productos').value = '';
            document.getElementById('dias').value = '';
        }
    });
</script>
</html>