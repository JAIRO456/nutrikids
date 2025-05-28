<?php
session_start();
require_once('../conex/conex.php');
require_once('../include/validate_sesion.php');
$conex = new Database;
$con = $conex->conectar();

$id_producto = isset($_GET['id_producto']) ? intval($_GET['id_producto']) : 0;

if ($id_producto > 0) {
    // Traer datos del producto, categoría y nutrición
    $sql = $con->prepare("
        SELECT p.*, c.categoria, n.calorias, n.proteinas, n.carbohidratos, n.grasas, n.azucares, n.sodio
        FROM producto p
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria
        LEFT JOIN informacion_nutricional n ON p.id_producto = n.id_producto
        WHERE p.id_producto = :id_producto
    ");
    $sql->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $sql->execute();
    $producto = $sql->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Especificaciones del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <?php if (!empty($producto)): ?>
        <h2><?php echo htmlspecialchars($producto['nombre_prod']); ?></h2>
        <p><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria']); ?></p>
        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($producto['descripcion']); ?></p>
        <p><strong>Precio:</strong> $<?php echo htmlspecialchars($producto['precio']); ?></p>
        <?php if (!empty($producto['imagen'])): ?>
            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" class="img-fluid mb-3" style="max-width:300px;">
        <?php endif; ?>
        <h4>Información Nutricional</h4>
        <ul>
            <li><strong>Calorías:</strong> <?php echo htmlspecialchars($producto['calorias']); ?></li>
            <li><strong>Proteínas:</strong> <?php echo htmlspecialchars($producto['proteinas']); ?> g</li>
            <li><strong>Carbohidratos:</strong> <?php echo htmlspecialchars($producto['carbohidratos']); ?> g</li>
            <li><strong>Grasas:</strong> <?php echo htmlspecialchars($producto['grasas']); ?> g</li>
            <li><strong>Azúcares:</strong> <?php echo htmlspecialchars($producto['azucares']); ?> g
                <?php if ($producto['azucares'] > 10): ?>
                    <span class="badge bg-danger">Alto en azúcares</span>
                <?php endif; ?>
            </li>
            <li><strong>Sodio:</strong> <?php echo htmlspecialchars($producto['sodio']); ?> mg</li>
        </ul>
        <a href="javascript:history.back()" class="btn btn-secondary">Regresar</a>
    <?php else: ?>
        <div class="alert alert-danger">Producto no encontrado.</div>
    <?php endif; ?>
</div>
</body>
</html>