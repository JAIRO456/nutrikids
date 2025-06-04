<?php
    session_start();
    require_once('conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    include 'menu.html';

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
        .product-card {
            max-width: 800px;
            margin: 0 auto;
        }
        .nutrition-table th, .nutrition-table td {
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <?php if (!empty($producto)): ?>
            <div class="card shadow-sm product-card">
                <div class="row g-0">
                    <?php if (!empty($producto['imagen_prod'])): ?>
                        <div class="col-md-4">
                            <img src="img/products/<?php echo htmlspecialchars($producto['imagen_prod']); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($producto['nombre_prod']); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="card-title mb-3 text-center"><?php echo htmlspecialchars($producto['nombre_prod']); ?></h2>
                            <p class="card-text"><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria']); ?></p>
                            <p class="card-text"><strong>Descripción:</strong> <?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p class="card-text"><strong>Precio:</strong> $<?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?></p>
                            <h4 class="mt-4">Información Nutricional</h4>
                            <table class="table nutrition-table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Calorías</th>
                                        <td><?php echo htmlspecialchars($producto['calorias'] ?? 'N/A'); ?> kcal</td>
                                            <?php if (!empty($producto['calorias']) && $producto['calorias'] > 200): ?>
                                                <span class="badge bg-danger ms-2">Alto en calorías</span>
                                            <?php endif; ?>
                                    </tr>
                                    <tr>
                                        <th scope="row">Proteínas</th>
                                        <td><?php echo htmlspecialchars($producto['proteinas'] ?? 'N/A'); ?> g</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Carbohidratos</th>
                                        <td><?php echo htmlspecialchars($producto['carbohidratos'] ?? 'N/A'); ?> g</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Grasas</th>
                                        <td><?php echo htmlspecialchars($producto['grasas'] ?? 'N/A'); ?> g</td>
                                            <?php if (!empty($producto['grasas']) && $producto['grasas'] > 10): ?>
                                                <span class="badge bg-danger ms-2">Alto en grasas</span>
                                            <?php endif; ?>
                                    </tr>
                                    <tr>
                                        <th scope="row">Azúcares</th>
                                        <td>
                                            <?php echo htmlspecialchars($producto['azucares'] ?? 'N/A'); ?> g
                                            <?php if (!empty($producto['azucares']) && $producto['azucares'] > 10): ?>
                                                <span class="badge bg-danger ms-2">Alto en azúcares</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sodio</th>
                                        <td><?php echo htmlspecialchars($producto['sodio'] ?? 'N/A'); ?> mg</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="javascript:history.back()" class="btn btn-outline-primary mt-3">Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger text-center" role="alert">
                Producto no encontrado.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>