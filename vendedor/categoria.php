<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriKids - Vendedor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: black;
            color: white;
            padding: 10px 20px;
        }
        .navbar .logo {
            display: flex;
            align-items: center;
        }
        .navbar .logo img {
            height: 30px;
            margin-right: 10px;
        }
        .navbar .menu {
            display: flex;
            gap: 15px;
        }
        .navbar .menu a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar .menu a:hover {
            text-decoration: underline;
        }
        .navbar .actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .navbar .actions img {
            height: 25px;
            cursor: pointer;
        }
        .content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .card {
            text-align: center;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            transition: transform 0.3s, border-color 0.3s;
            cursor: pointer;
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            border-color: green;
        }
        .card.selected {
            border-color: green;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="logo.png" alt="NutriKids">
            <span>NUTRIKIDS</span>
        </div>
        <div class="menu">
            <a href="inicio.php">Inicio</a>
            <a href="categoria.php">Categorias</a>
            <a href="#">Menus</a>
        </div>
        <div class="actions">
            <span>Vendedor</span>
            <img src="logout-icon.png" alt="Logout" onclick="window.location.href='login.php'">
        </div>
    </div>

    <div class="content">
        <div class="card" onclick="redirectTo('productos/bebidas_frias.php')">
            <img src="../img\categories\bebidas.jpg" alt="Bebidas Frías">
            <h3>Bebidas Frías</h3>
        </div>
        <div class="card" onclick="redirectTo('productos/bebidas_calientes.php')">
            <img src="..\img\categories\cafes.jpg" alt="Bebidas Calientes">
            <h3>Bebidas Calientes</h3>
        </div>
        <div class="card" onclick="redirectTo('productos/postres.php')">
            <img src="..\img\categories\postres.png" alt="Postres">
            <h3>Postres</h3>
        </div>
        <div class="card" onclick="redirectTo('productos/frutas.php')">
            <img src="..\img\categories\Frutas.jpeg" alt="Frutas">
            <h3>Frutas</h3>
        </div>
        <div class="card" onclick="redirectTo('productos/panaderia.php')">
            <img src="..\img\categories\panes.jpg" alt="Panadería">
            <h3>Panadería</h3>
        </div>
        <div class="card" onclick="redirectTo('productos/snacks.php')">
            <img src="..\img\categories\Snacks.jpeg" alt="Snacks">
            <h3>Snacks</h3>
        </div>
    </div>

    <script>
        // Función para redirigir a la página correspondiente
        function redirectTo(page) {
            window.location.href = page;
        }

        // Agregar efecto de selección
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
            });
        });
    </script>
</body>
</html>