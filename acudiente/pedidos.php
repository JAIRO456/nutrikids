<?php
<<<<<<< HEAD
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
            // obtenemos el valor del día seleccionado y el id del estudiante
            const dia = this.value;
            const urlParams = new URLSearchParams(window.location.search);
            const id_estudiante = urlParams.get('id_estudiante');

            // verificamos si el día y el id del estudiante están definidos
            if (dia && id_estudiante) {
                getPedidos(dia, id_estudiante);
            } 
            else {
                const tbody = document.querySelector('#table-pedidos tbody');
                tbody.innerHTML = '<tr><td colspan="3">Seleccione un día para ver los pedidos</td></tr>';
                document.getElementById('total-pedidos').textContent = '';
            }
        });

        function getPedidos(dia, id_estudiante) {
            fetch(`../ajax/get_horarios.php?id_estudiante=${id_estudiante}&dia=${dia}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-pedidos tbody');
                    tbody.innerHTML = '';
                    let total = 0;

                    if (data.error) {
                        tbody.innerHTML = `<tr><td colspan="3">${data.error}</td></tr>`;
                        document.getElementById('total-pedidos').textContent = '';
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
                    });

                    document.getElementById('total-pedidos').textContent = total.toFixed(2);
                })
                .catch(error => console.error('Error al obtener los pedidos:', error));
        }
    </script>
=======

session_start();
require_once('../conex/conex.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php 

    if (isset($_GET['id'])) {
        $idEstudiante = addslashes($_GET['id']);

        if (isset($_POST['pedidos']) && !empty($_POST['pedidos'])) {
            $idPedido = $_POST['pedidos'];
        
            $sqlPedidos = $con->prepare("SELECT * FROM detalles_menu INNER JOIN estudiantes ON detalles_menu.documento_est = estudiantes.documento_est 
            INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu INNER JOIN producto ON detalles_menu.id_producto = producto.id_producto 
            INNER JOIN pedidos ON detalles_menu.id_pedidos = pedidos.id_pedidos WHERE detalles_menu.documento_est = '$idEstudiante' AND pedidos.id_pedidos = $idPedido");
            $sqlPedidos->execute();
            $p = $sqlPedidos->fetchAll(PDO::FETCH_ASSOC);
        } 
        
        else {
            // Si no se selecciona ningún día, no se muestra productos
            $p = [];
        }
    }
        
?>

<?php
    if (isset($_POST['entregado'])){
        $idPedido = $_POST['pedidos'];

        $sqlUpdateEstudents = $con->prepare("UPDATE estudiantes SET id_estado = 4 WHERE documento_est = '$idEstudiante'");
        $sqlUpdateEstudents->execute();

        $sqlUpdatePedidos = $con->prepare("UPDATE detalles_menu SET id_estado = 4 WHERE documento_est = '$idEstudiante' AND id_pedidos = $idPedido");
        $sqlUpdatePedidos->execute();
    }

    if (isset($_POST['no_entregado'])){
        $idPedido = $_POST['pedidos'];

        $sqlUpdateEstudents = $con->prepare("UPDATE estudiantes SET id_estado = 5 WHERE documento_est = '$idEstudiante'");
        $sqlUpdateEstudents->execute();

        $sqlUpdatePedidos = $con->prepare("UPDATE detalles_menu SET id_estado = 5 WHERE documento_est = '$idEstudiante' AND id_pedidos = $idPedido");
        $sqlUpdatePedidos->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/pedidos.css">
    <title>Document</title>
</head>
<body>
    <main class="container-main">
        <form action="" method="post">
            <h1>HORARIO ESCOLAR</h1>

            <h2 value="">Seleccione el dia</h2>
            <select name="pedidos" id="pedidos" class="pedidos" onchange="this.form.submit()">
                <option value="">---</option>
                    <?php
                        $sqlPedidos = $con -> prepare("SELECT * FROM pedidos");
                        $sqlPedidos -> execute();

                        while ($ped = $sqlPedidos->fetch(PDO::FETCH_ASSOC)) {
                            $selected = isset($_POST['pedidos']) && $_POST['pedidos'] == $ped["id_pedidos"] ? "selected" : "";
                            echo "<option value='" . $ped["id_pedidos"] . "' $selected>" . $ped["dias_sem"] . "</option>";
                        }
                    ?>
            </select>
            <br>
            <br>

            <table class="container-table">
                <tr>
                    <th>PRODUCTOS</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                </tr>

            <?php 
                $total = 0;
            // Si se han encontrado productos, los mostramos
                if (!empty($p)) {
                    foreach ($p as $products) {
            ?>
                    <tr>
                        <td><?php echo $products['nombre_prod']; ?></td>
                        <td><?php echo $products['cantidad']; ?></td>
                        <td><?php echo $precio = $products['cantidad'] * $products['precio']; ?></td> 
                    </tr>

                    <?php $total += $precio; ?>
                    
            <?php } 
            } else {
                echo "<tr><td colspan='3'>No hay productos disponibles para el día seleccionado.</td></tr>";
            }
            ?>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total: <?php echo $total; ?></th>
                </tr>


            </table>
            <br>
            <input type="submit" name="entregado" class="entregado" value="ENTREGADO">
            <input type="submit" name="no_entregado" class="no_entregado" value="NO ENTREGADO">
        </form>
    </main>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</body>
</html>