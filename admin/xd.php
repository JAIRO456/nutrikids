<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Hamburguesa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="navbar">
        <div class="menu-icon" onclick="toggleMenu()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <ul class="menu" id="menu">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Nosotros</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
    </div> 

    <script>
        function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('active');
}

    </script>
</body>
</html>
