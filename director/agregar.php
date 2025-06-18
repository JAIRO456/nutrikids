<?php
    session_start();
    require_once('../database/conex.php');
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
    <title>Agregar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #6c757d;
            --background-color: #f3f4f6;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: var(--background-color);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 75px;
            padding: 1rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .card {
            background: var(--primary-color);
            color: white;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            transition: transform var(--transition-speed);
            overflow: hidden;
            text-align: center;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            display: block;
        }

        .nav-link:hover {
            color: white;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 100px;
            }
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="grid">
            <div class="card">
                <div class="card-body">
                    <a class="nav-link" href="usuarios/crear_vendedores.php">
                        <h5 class="card-title">Vendedor</h5>
                        <i class="fa-solid fa-user"></i>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <a class="nav-link" href="usuarios/crear_acudientes.php">
                        <h5 class="card-title">Acudientes</h5>
                        <i class="fa-solid fa-user"></i>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <a class="nav-link" href="estudiantes/crear_estudiantes.php">
                        <h5 class="card-title">Estudiantes</h5>
                        <i class="fa-solid fa-user"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>