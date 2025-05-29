<<<<<<< HEAD
<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    // Suponiendo que tienes una consulta para obtener las categorías
    $categorias = [];
    $stmt = $con->prepare("SELECT * FROM categorias");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include 'menu.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriKids - Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
=======
<<<<<<< HEAD
<?php
    session_start();
    require_once('../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.php';
?>

=======
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>NutriKids - Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif; 
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; 
<<<<<<< HEAD
        }
        .container-div-footer {
            margin-top: 40px;
        }
        .login-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 30px;
            max-width: 900px;
            margin: 40px auto;
        }
        .category-card {
            margin-bottom: 30px;
        }
        .category-card button {
            background: none;
            border: none;
            padding: 0;
            width: 100%;
            text-align: center;
        }
        .category-card img {
            width: 100%;
            max-width: 180px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            transition: transform 0.2s;
        }
        .category-card button:hover img {
            transform: scale(1.05);
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
        }
        .category-card h3 {
            font-size: 1.2rem;
            color: #4caf50;
            margin-bottom: 0;
        }
        .btn-success {
            background-color: #4caf50;
            border: none;
        }
        .btn-success:hover {
            background-color: #388e3c;
=======
=======
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
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
        }
        .content {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .card {
            text-align: center;
<<<<<<< HEAD
            border: 2px solid #ddd; 
            padding: 10px;
            border-radius: 10px; 
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            cursor: pointer;
            background-color: #fff; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
=======
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            transition: transform 0.3s, border-color 0.3s;
            cursor: pointer;
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
        }
        .card img {
            width: 100%;
            height: auto;
<<<<<<< HEAD
            border-radius: 10px; /* Bordes redondeados para la imagen */
            border: 3px solid #28a745; /* Borde verde alrededor de la imagen */
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            border-color: #28a745; /* Cambiar color del borde al pasar el mouse */
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); /* Sombra más intensa */
        }
        .card:hover img {
            transform: scale(1.1); /* Efecto de zoom en la imagen */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra en la imagen */
        }
        .card h3 {
            margin-top: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #333; /* Color del texto */
        }
        .edit-category-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 2px dashed #ccc;
            padding: 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            background-color: #fff;
        }
        .edit-category-card:hover {
            transform: scale(1.05);
            border-color: #28a745;
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        .edit-category-card i {
            font-size: 50px;
            color: #28a745;
        }
        .edit-category-card span {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
    </style>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="content">
        <div class="card" onclick="redirectTo('productos.php?id_categoria=1')">
            <img src="../img/categories/bebidas.jpg" alt="Bebidas Frías">
            <h3>Bebidas Frías</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=2')">
            <img src="../img/categories/cafes.jpg" alt="Bebidas Calientes">
            <h3>Bebidas Calientes</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=3')">
            <img src="../img/categories/postres.png" alt="Postres">
            <h3>Postres</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=4')">
            <img src="..\img\categories\frutas.png" alt="Frutas">
            <h3>Frutas</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=5')">
            <img src="../img/categories/panes.jpg" alt="Panadería">
            <h3>Panadería</h3>
        </div>
        <div class="card" onclick="redirectTo('productos.php?id_categoria=6')">
            <img src="..\img\categories\snacks-2.webp" alt="Snacks">
            <h3>Snacks</h3>
        </div>
      
        <div class="edit-category-card" onclick="redirectTo('crear_producto.php')">
            <i class="bi bi-pencil-square"></i>
            <span>Crear Productos</span>

        </div>
        <div class="edit-category-card" onclick="redirectTo('Editar_producto.php')">
            <i class="bi bi-pencil-square"></i>
            <span>Editar Productos</span>
    </div>

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
=======
            border-radius: 5px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            border-color: green;
        }
        .card.selected {
            border-color: green;
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
        }
    </style>
</head>
<body>
<<<<<<< HEAD
    <div class="container mt-2 login">
        <h1 class="mb-4 text-center">Categorías</h1>
        <form method="POST" action="productos.php">
            <div class="row">
                <?php foreach ($categorias as $categoria): ?>
                    <div class="col-md-3 category-card">
                        <button type="submit" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>" class="btn btn-link">
                            <img src="../img/categories/<?php echo $categoria['imagen']; ?>" alt="<?php echo $categoria['categoria']; ?>">
                            <h3><?php echo $categoria['categoria']; ?></h3>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
=======
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
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
    </script>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
</body>
</html>