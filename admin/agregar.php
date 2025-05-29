<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <title>Agregar</title>
    <link rel="stylesheet" href="../styles/agregar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
        <main class="main-content">
            <section class="create-account">
                <h1>CREAR CUENTA PARA:</h1>
                <nav class="options">
                    <a href="vendedor.php" class="option"> 
                        <i class="icono2 bi bi-person-circle"></i> 
                        <h2>VENDEDOR</h2>
                    </a>
                    <a href="acudiente.php" class="option"> 
                        <i class="icono2 bi bi-person-circle"></i> 
                        <h2>ACUDIENTE</h2>
                    </a>
                    <a href="estudiante.php" class="option"> 
                        <i class="icono2 bi bi-person-circle"></i> 
                        <h2>ESTUDIANTE</h2>
                    </a>
                </nav>
            </section>
        </main>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9U7pcFgL29UpmO6HfoEZ5rZ9zxL5FZKsw19eUyyglgKjHODUhlPqGe8C+ekc3E10" crossorigin="anonymous"></script>
    </body>
    </html>
