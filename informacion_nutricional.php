<?php
    session_start();
    require_once('database/conex.php');
    $conex =new Database;
    $con = $conex->conectar();

    //include 'menu.php';

    $id_producto = isset($_GET['id_producto']) ? intval($_GET['id_producto']) : 0;

    if ($id_producto > 0) {
        // Traer datos del producto, categoría y nutrición
        $sql = $con->prepare("SELECT p.*, c.categoria, n.calorias, n.proteinas, n.carbohidratos, n.grasas, n.azucares, n.sodio
        FROM producto p
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria
        LEFT JOIN informacion_nutricional n ON p.id_producto = n.id_producto
        WHERE p.id_producto = ?");
        $sql->execute([$id_producto]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Especificaciones del Producto</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .product-card {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.5s ease-in;
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
        }

        .product-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
            text-align: center;
            animation: slideDown 0.5s ease-out;
        }

        .product-details {
            margin-bottom: 1.5rem;
        }

        .product-details p {
            margin: 0.5rem 0;
            color: #555;
        }

        .nutrition-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            animation: slideUp 0.5s ease-out;
        }

        .nutrition-table th,
        .nutrition-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .nutrition-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            margin-left: 0.5rem;
            background-color: #dc3545;
            color: white;
            animation: pulse 2s infinite;
        }

        .back-button {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: transparent;
            border: 2px solid #007bff;
            color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .back-button:hover {
            background-color: #007bff;
            color: white;
        }

        .alert {
            padding: 1rem;
            border-radius: 5px;
            text-align: center;
            background-color: #dc3545;
            color: white;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($producto)): ?>
            <div class="product-card">
                <div class="product-grid">
                    <?php if (!empty($producto['imagen_prod'])): ?>
                        <div class="product-image-container">
                            <img src="img/products/<?php echo htmlspecialchars($producto['imagen_prod']); ?>" 
                                 class="product-image" 
                                 alt="<?php echo htmlspecialchars($producto['nombre_prod']); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="product-info">
                        <h2 class="product-title"><?php echo htmlspecialchars($producto['nombre_prod']); ?></h2>
                        <div class="product-details">
                            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria']); ?></p>
                            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p><strong>Precio:</strong> $<?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?></p>
                        </div>
                        <h4>Información Nutricional</h4>
                        <table class="nutrition-table">
                            <tbody>
                                <tr>
                                    <th>Calorías</th>
                                    <td>
                                        <?php echo htmlspecialchars($producto['calorias'] ?? 'N/A'); ?> kcal
                                        <?php if (!empty($producto['calorias']) && $producto['calorias'] > 200): ?>
                                            <span class="badge">Alto en calorías</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Proteínas</th>
                                    <td><?php echo htmlspecialchars($producto['proteinas'] ?? 'N/A'); ?> g</td>
                                </tr>
                                <tr>
                                    <th>Carbohidratos</th>
                                    <td><?php echo htmlspecialchars($producto['carbohidratos'] ?? 'N/A'); ?> g</td>
                                </tr>
                                <tr>
                                    <th>Grasas</th>
                                    <td>
                                        <?php echo htmlspecialchars($producto['grasas'] ?? 'N/A'); ?> g
                                        <?php if (!empty($producto['grasas']) && $producto['grasas'] > 10): ?>
                                            <span class="badge">Alto en grasas</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Azúcares</th>
                                    <td>
                                        <?php echo htmlspecialchars($producto['azucares'] ?? 'N/A'); ?> g
                                        <?php if (!empty($producto['azucares']) && $producto['azucares'] > 10): ?>
                                            <span class="badge">Alto en azúcares</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sodio</th>
                                    <td><?php echo htmlspecialchars($producto['sodio'] ?? 'N/A'); ?> mg</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="javascript:history.back()" class="back-button">Regresar</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert">
                Producto no encontrado.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>