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
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .card button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .card button:hover {
            background-color: #444;
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
            <a href=""></a>
            <img src="logout-icon.png" alt="Logout" onclick="window.location.href='login.php'">
        </div>
    </div>

  
   
    </div>
</body>
</html>