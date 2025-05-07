<?php
    session_start();
    require_once('../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    if (!isset($_SESSION['documento'])) {
        echo '<script>alert("No has iniciado sesión")</script>';
        echo '<script>window.location = "../login.html"</script>';
        exit();
    }
    
    $sqlUser = $con->prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado INNER JOIN escuelas ON usuarios.id_escuela = escuelas.id_escuela WHERE usuarios.documento = ?");
    $sqlUser->execute([$_SESSION['documento']]);
    $u = $sqlUser->fetch();

    $sqlCategories = $con->prepare("SELECT * FROM categorias");
    $sqlCategories->execute();
    $c = $sqlCategories->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/productos.css">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <header class="container-header">
        <label for="" class="user"><?php echo $u['nombre']; ?> <?php echo $u['apellido']; ?>, <?php echo $u['rol']; ?>.</label>
        <a href="cuenta.php"><i class="icono bi bi-person-circle"></i></a>
    </header>

    <main class="container-main">
        <section class="container1">
            <?php foreach ($c as $category){ ?>
                <div class="productos">
                    <a href="productos1.php?categoria=<?php echo $category['id_categoria']; ?>"><img src="../img/categories/<?php echo $category['imagen']; ?>" alt=""></a>
                    <h3><?php echo $category['categoria']; ?></h3>
                </div>
            <?php } ?>
        </section>
    </main>
</body>
</html>