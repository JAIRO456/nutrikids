<?php
    session_start();
    require_once('database/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    include 'menu.html';

    $sqlCategories = $con -> prepare("SELECT * FROM categorias");
    $sqlCategories -> execute();
    $Categories = $sqlCategories -> fetchALL(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <style>
        .categoria-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .categoria-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .categoria-card:hover {
            transform: scale(1.05);
        }

        .categoria-imagen {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .categoria-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .categoria-card:hover .categoria-overlay {
            opacity: 1;
        }

        .categoria-nombre {
            color: white;
            font-size: 1.5rem;
            text-align: center;
            padding: 10px;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .categoria-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .categoria-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <?php if (empty($Categories)) { ?>
            <div class="alert alert-info">No hay Categorias disponibles</div>
        <?php } else { ?>
            <div class="categoria-container">
                <?php foreach ($Categories as $Category) { ?>
                    <div class="categoria-card">
                        <a onclick="window.location.href='productos?id_categoria=<?= $Category['id_categoria']; ?>'">
                            <img src="../img/categories/<?= $Category['imagen']; ?>" 
                                 class="categoria-imagen" 
                                 alt="<?= $Category['categoria']; ?>">
                            <div class="categoria-overlay">
                                <h5 class="categoria-nombre"><?= $Category['categoria']; ?></h5>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </main>
</body>
</html>