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
        $dias = isset($_POST['dia']) ? $_POST['dia'] : [];
        $fecha_ini = $_POST['fecha_ini'];
        $fecha_fin = $_POST['fecha_fin'];
        // $monto = $_POST['monto'];
        $metodo_pago = $_POST['metodo_pago'];
        $productos = isset($_POST['productos']) ? json_decode($_POST['productos'], true) : [];

        if (empty($id_menu) || empty($documento_est) || empty($dias) || empty($fecha_ini) || empty($fecha_fin) || empty($metodo_pago)) {
            $mensaje = "Por favor complete todos los campos requeridos.";
        } 
        else if (count($dias) == 0) {
            $mensaje = "Seleccione al menos un día.";
        } 
        else if (count($productos) == 0) {
            $mensaje = "No hay productos seleccionados.";
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
    <link rel="stylesheet" href="../styles/inicio.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="container">
        <h1 class="mb-4">Gestión de Pagos de Menús</h1>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?php echo strpos($mensaje, 'exitosamente') !== false ? 'success' : 'danger'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form id="menuForm" method="POST" action="">
            <div class="card mb-4">
                <div class="card-header">Registrar Nuevo Pago</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="id_menu" class="form-label">Menú</label>
                            <select class="form-select" id="id_menu" name="id_menu" required>
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
                        <div class="col-md-6">
                            <label for="documento_est" class="form-label">Estudiante</label>
                            <select class="form-select" id="documento_est" name="documento_est" required>
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
                    <div class="container card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Selección de Días</h5>
                            <div class="row g-3">
                                <?php
                                $days = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
                                foreach ($days as $day) {
                                    echo "
                                    <div class='col-md-6'>
                                        <div class='form-check'>
                                            <input type='checkbox' class='form-check-input dia' id='dia-$day' name='dia[]' value='$day'>
                                            <label class='form-check-label' for='dia-$day'>" . ucfirst($day) . "</label>
                                        </div>
                                    </div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_ini" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fecha_ini" name="fecha_ini" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" class="form-control" id="monto" name="monto">
                        </div>
                        <div class="col-md-6">
                            <label for="metodo_pago" class="form-label">Método de Pago</label>
                            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
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
                    <button type="submit" class="btn btn-primary">Registrar Pago</button>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Detalles del Menú Seleccionado</div>
                <input type="hidden" name="productos" id="productos">
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="table-pedidos">
                        <thead class="table-dark">
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
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total:</td>
                                <td id="total-pedidos" class="fw-bold"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </main>
</body>
<script>
    let listaProductos = [];
    // Función para obtener los detalles del menú seleccionado
    document.getElementById('id_menu').addEventListener('change', function () {
        const id_menu = this.value;
        listaProductos = [];
        if (id_menu) {
            fetch(`../ajax/get_det_menu.php?id_menu=${id_menu}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('det_menu');
                    tbody.innerHTML = '';
                    let total = 0;
                    data.pedidos.forEach(pedido => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${pedido.nombre_prod}</td>
                            <td>${pedido.cantidad}</td>
                            <td>${pedido.subtotal}</td>
                        `;
                        tbody.appendChild(tr);
                        total += parseFloat(pedido.subtotal);

                        listaProductos.push({
                            id_producto: pedido.id_producto,
                            nombre_prod: pedido.nombre_prod,
                            precio: pedido.precio,
                            cantidad: pedido.cantidad
                        });
                    });
                    document.getElementById('total-pedidos').textContent = total.toFixed(2);
                    document.getElementById('productos').value = JSON.stringify(listaProductos);
                    
                })
                .catch(error => console.error('Error:', error));
        } 
        else {
            const tbody = document.getElementById('det_menu');
            tbody.innerHTML = '<tr><td colspan="3">Seleccione un menú para ver los detalles</td></tr>';
            document.getElementById('total-pedidos').textContent = '';
        }
    });
</script>
</html>