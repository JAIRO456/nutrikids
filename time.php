<?php

require_once('conex/conex.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php

$inactividad_max = 300; 

// Verificar si ya existe una marca de tiempo de actividad
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();  // Marca de tiempo de la última actividad
}

// Calcular el tiempo de inactividad
$inactividad = time() - $_SESSION['last_activity'];

// Si la inactividad supera el tiempo máximo, el usuario se considera inactivo
if ($inactividad > $inactividad_max) {
    echo "<img src='img/users/user.png' class='imagen' alt=''>";
} else {
    echo "<img src='img/users/user2.png' class='imagen' alt='' width='50'>";
}

// Actualizamos la última actividad con la hora actual
$_SESSION['last_activity'] = time();

<<<<<<< HEAD
?>

$p = []; // Inicializar la variable para evitar errores si no hay resultados

    if (!empty($_GET['dia'])) {
        $idPedido = $_GET['dia'];
        try {
            // Consulta SQL para obtener los productos según el día
            $sqlPedidos = $con->prepare("SELECT producto.nombre_prod, detalles_menu.cantidad, detalles_menu.subtotal 
            FROM detalles_pedidos_producto 
            INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu 
            INNER JOIN detalles_menu ON detalles_menu.id_menu = menus.id_menu 
            INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto 
            INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos 
            WHERE pedidos.dia = ?");
            $sqlPedidos->execute([$idPedido]);
            $p = $sqlPedidos->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }



<?php if (!empty($p)) : ?>
                            <?php foreach ($p as $menu) : ?>
                                <tr>
                                    <td><?php echo $menu['nombre_prod']; ?></td>
                                    <td><?php echo $menu['cantidad']; ?></td>
                                    <td><?php echo $menu['subtotal']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="5" class="text-center">No hay productos para mostrar.</td></tr>
                        <?php endif; ?>


<tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total:</strong></td>
                            <td><?php echo array_sum(array_column($p, 'subtotal')); ?></td>
                        </tr>
                    </tfoot>
=======
?>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
