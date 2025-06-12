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
    <main class="container mt-2">
        <a href="horarios.php" class="btn btn-secondary mb-1">Regresar</a>
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
                <div class="mb-3 text-center">
                    <button type="button" id="btn-entregado" class="btn btn-success" value="3">Entregado</button>
                    <button type="button" id="btn-no-entregado" class="btn btn-danger" value="4">No Entregado</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let id_estado = null;

        document.getElementById('btn-entregado').addEventListener('click', function () {
            id_estado = 3;
            cargarPedidos();
        });
        document.getElementById('btn-no-entregado').addEventListener('click', function () {
            id_estado = 4;
            cargarPedidos();
        });

        document.getElementById('dia').addEventListener('change', function() {
            id_estado = null;
            cargarPedidos();
        });

        function cargarPedidos() {
            const dia = document.getElementById('dia').value;
            const urlParams = new URLSearchParams(window.location.search);
            const id_estudiante = urlParams.get('id_estudiante');
        
            if (dia && id_estudiante) {
                getPedidos(dia, id_estudiante, id_estado);
            } else {
                const tbody = document.querySelector('#table-pedidos tbody');
                tbody.innerHTML = '<tr><td colspan="3">Seleccione un día para ver los pedidos</td></tr>';
                document.getElementById('total-pedidos').textContent = '';
            }
        }

        function getPedidos(dia, id_estudiante, id_estado) {
            let url = `../ajax/get_horarios_vendedor.php?id_estudiante=${id_estudiante}&dia=${dia}`;
            if (id_estado !== null) {
                url += `&id_estado=${id_estado}`;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table-pedidos tbody');
                    tbody.innerHTML = '';
                    let total = 0;
                
                    if (data.error) {
                        tbody.innerHTML = `<tr><td colspan="3" class="text-center text-danger">${data.error}</td></tr>`;
                        document.getElementById('total-pedidos').textContent = '0.00';
                        return;
                    }
                
                    if (!data.pedidos || data.pedidos.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="3" class="text-center">No hay pedidos para mostrar</td></tr>';
                        document.getElementById('total-pedidos').textContent = '0.00';
                        return;
                    }
                
                    data.pedidos.forEach(pedido => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${pedido.nombre_prod}</td>
                            <td class="text-center">${pedido.cantidad}</td>
                            <td class="text-end">$${pedido.subtotal}</td>
                        `;
                        tbody.appendChild(tr);
                        total += parseFloat(pedido.subtotal.replace(/,/g, ''));
                    });
                
                    document.getElementById('total-pedidos').textContent = `$${total.toFixed(2)}`;
                })
                .catch(error => {
                    console.error('Error al obtener los pedidos:', error);
                    const tbody = document.querySelector('#table-pedidos tbody');
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center text-danger">Error al cargar los pedidos</td></tr>';
                    document.getElementById('total-pedidos').textContent = '0.00';
                });
        }
    </script>
</body>
</html>