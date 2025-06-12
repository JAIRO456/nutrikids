<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/logo-nutrikids2.png" type="image/png">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <main class="container mt-2">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Pedidos</h5>
                        <p class="card-text display-4" id='TotalPedidos'>
                            <i class="bi bi-archive-fill"></i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Entregados</h5>
                        <p class="card-text display-4" id='TotalPedidosCheck'>
                            <i class="bi bi-calendar-check-fill"></i>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">No Entregados</h5>
                        <p class="card-text display-4" id='TotalPedidosX'>
                            <i class="bi bi-calendar-x-fill"></i>
                        </p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Ventas</h5>
                        <p class="card-text display-4" id='TotalVentas'>
                            <i class="bi bi-bar-chart-fill"></i>
                        </p>
                    </div>
                </div>
            </div> -->
        </div>
            

    </main>
</body>
<script>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
<script>
    function updateCounts() {
        fetch('../ajax/get_counts3.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('TotalPedidos').innerHTML = `<i class="bi bi-archive-fill"></i> ${data.TotalPedidos}`;
                document.getElementById('TotalPedidosCheck').innerHTML = `<i class="bi bi-calendar-check-fill"></i> ${data.TotalPedidosCheck}`;
                document.getElementById('TotalPedidosX').innerHTML = `<i class="bi bi-calendar-x-fill"></i> ${data.TotalPedidosX}`;
                // document.getElementById('TotalVentas').innerHTML = `<i class="bi bi-bar-chart-fill"></i> ${data.TotalVentas}`;
            })
            .catch(error => console.error('Error al obtener datos:', error));
    }
    // Cargar los datos al inicio
    document.addEventListener('DOMContentLoaded', function () {
        updateCounts();
    });
</script>
</html>