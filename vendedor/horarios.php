<?php
session_start();
require_once('../conex/conex.php');
require_once('../include/validate_sesion.php');
$conex = new Database;
$con = $conex->conectar();

include 'menu.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <main class="container-main">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Menus</h2>
                    <table class="table table-bordered table-striped" id="table-menus">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Documento</th>
                                <th>Día</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div id="pagination" class="mt-3"></div>
                </div>
            </div>
        </div>
    </main>
</body>
<script>
    let pedidosData = [];
    let currentPage = 1;
    const rowsPerPage = 5;
    
    function renderTable(page = 1) {
        const tbody = document.querySelector('#table-menus tbody');
        tbody.innerHTML = '';
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageData = pedidosData.slice(start, end);
    
        pageData.forEach(pedido => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${pedido.id_pedidos}</td>
                <td>${pedido.documento}</td>
                <td>${pedido.dia}</td>
                <td id="estado-${pedido.id_pedidos}">${pedido.estado}</td>
                <td>
                    <button class='btn btn-success btn-sm' onclick="actualizarEstado(${pedido.id_pedidos}, 3)">
                        <i class="bi bi-check-circle"></i> Entregado
                    </button>
                    <button class='btn btn-warning btn-sm' onclick="actualizarEstado(${pedido.id_pedidos}, 4)">
                        <i class="bi bi-hourglass-split"></i> Pendiente
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    
        renderPagination();
    }
    
    function renderPagination() {
        let pagination = document.getElementById('pagination');
        pagination.innerHTML = '';
    
        const totalPages = Math.ceil(pedidosData.length / rowsPerPage);
        if (totalPages <= 1) return;
    
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.className = 'btn btn-secondary btn-sm mx-1';
            btn.textContent = i;
            if (i === currentPage) btn.classList.add('active');
            btn.onclick = () => {
                currentPage = i;
                renderTable(currentPage);
            };
            pagination.appendChild(btn);
        }
    }
    
    function getMenus() {
        fetch('../ajax/get_pedidos_entrega.php')
            .then(response => response.json())
            .then(data => {
                pedidosData = data;
                currentPage = 1;
                renderTable(currentPage);
            })
            .catch(error => console.error('Error al obtener los pedidos:', error));
    }
    
    function actualizarEstado(id_pedidos, nuevoEstado) {
        fetch('../ajax/actualizar_estado.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_pedidos: id_pedidos, id_estado: nuevoEstado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                getMenus(); // Refresca la tabla
            } else {
                alert('No se pudo actualizar el estado');
            }
        })
        .catch(error => alert('Error al actualizar el estado'));
    }
    
    getMenus();
    setInterval(getMenus, 3000);
</script>
</html>