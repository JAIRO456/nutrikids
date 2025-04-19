<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUTRIKIDS</title>
    <link rel="stylesheet" href="../styles/adm_menu.css">
</head>
<body>
    <div class="contenedor">
        <div class="menu">
            <img class="nutrikids-logo" src="../img/logo-nutrikids.png" alt="">
        </div>

        <div class="menu-icon" onclick="Menu()">
            <i class="menu-icons bi bi-list"></i>
        </div>
        
        <ul class="opciones" id="menu">
            <li><a href="/admin/inicio">Inicio</a></li>
            <li><a href="/admin/roles">Roles</a></li>
            <li><a href="/admin/menus">Menús</a></li>
            <li><a href="/admin/productos">Productos</a></li>
            <li><a href="/admin/agregar">Agregar</a></li>
            <li><a href="/admin/ventas">Ventas</a></li>
        </ul>
    </div>
    <script>
        function Menu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>

