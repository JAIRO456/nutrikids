<?php
    session_start();
    require_once('../conex/conex.php');
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
    <title>NutriKids - Vendedor</title>
</head>
<body>
  
    <!-- <div class="navbar">
        <div class="logo">
            <img src="logo.png" alt="NutriKids">
            <span>NUTRIKIDS</span>
            </div>
        <div class="menu">
            <a href="inicio.php">Inicio</a>
            <a href="categoria.php">Categorias</a>
            <a href="menu.php">Menus</a>
        </div>
        <div class="actions">
            <span>Vendedor</span>
            <a href=""></a>
            <img src="logout-icon.png" alt="Logout" onclick="window.location.href='login.php'">
        </div>
    </div> -->

  
   
    </div>
</body>
</html>