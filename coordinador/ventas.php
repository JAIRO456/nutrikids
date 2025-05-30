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
    <title>Document</title>
</head>
<body>
    <body>
    <main class="container mt-4">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <a class="nav-link" href="grafica_ventas.php" class="text-white">
                            <h5 class="card-title">Ventas</h5> 
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <a class="nav-link" href="grafica_productos.php" class="text-white">
                            <h5 class="card-title">Productos</h5> 
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <a class="nav-link" href="grafica_info_nutri.php" class="text-white">
                            <h5 class="card-title">Productos</h5>
                            <i class="bi bi-basket"></i>
                        </a>
                    </div>
                </div>
            </div>         
        </div>
    </main>
</body>
</body>
</html>