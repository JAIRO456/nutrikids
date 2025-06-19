<?php
    session_start();
    require_once('../database/conex.php');
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding-top: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            place-content: center;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 2rem;
            font-size: 2rem;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: #007bff;
            border-radius: 2px;
        }

        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
        }

        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            border: 2px solid #ddd;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #2c3e50;
            color: white;
            font-weight: 500;
        }

        tr:hover {
            background: #f8f9fa;
            transition: background 0.3s ease;
        }

        tfoot td {
            font-weight: bold;
            background: #f8f9fa;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        button {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        #btn-activo {
            background: #28a745;
            color: white;
        }

        #btn-inactivo {
            background: #dc3545;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        button:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            th, td {
                padding: 0.75rem;
            }

            button {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <h2>Pedidos</h2>
        <form method="GET" action="">
            <select name="dia" id="dia" required>
                <option value="">Seleccione un Día</option>
                <?php
                $listdays = array("lunes", "martes", "miercoles", "jueves", "viernes");
                foreach ($listdays as $day) {
                    echo "<option value='$day'>$day</option>";
                }
                ?>
            </select>
        </form>
        <div class="table-container">
            <table id="table-pedidos">
                <thead>
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
                        <td colspan="2" style="text-align: right;">Total:</td>
                        <td id="total-pedidos"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="button-container">
            <button type="button" id="btn-activo" value="1">Activo</button>
            <button type="button" id="btn-inactivo" value="2">Inactivo</button>
            <button type="button" onclick="window.location.href='horarios.php'" class="btn btn-secondary mb-1">Regresar</button>
        </div>
    </main>

    <script>
        let id_estado = 1;

        document.getElementById('btn-activo').addEventListener('click', function () {
            id_estado = 1;
            cargarPedidos();
        });
        document.getElementById('btn-inactivo').addEventListener('click', function () {
            id_estado = 2;
            cargarPedidos();
        });

        document.getElementById('dia').addEventListener('change', cargarPedidos);

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
            fetch(`../ajax/get_horarios.php?id_estudiante=${id_estudiante}&dia=${dia}&id_estado=${id_estado}`)
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