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
</body>
</html>