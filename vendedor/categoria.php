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
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif; 
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; 
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
        }
    </style>
</head>
<body>
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
</body>
</html>