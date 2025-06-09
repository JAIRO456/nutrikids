<?php
session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

$documento = $_SESSION['documento'];
$dia = $_GET['dia'] ?? '';
$busqueda = $_GET['busqueda'] ?? '';

// Obtener escuela del usuario
$sql = $con->prepare("SELECT * FROM usuarios 
INNER JOIN detalles_usuarios_escuela 
INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
WHERE usuarios.documento = ?");
$sql->execute([$documento]);
$u = $sql->fetch(PDO::FETCH_ASSOC);

// Consulta principal con filtros
$query = "SELECT 
    detalles_menu.id_det_menu, 
    estudiantes.documento_est, 
    estudiantes.nombre, 
    estudiantes.apellido, 
    menus.nombre_menu, 
    pedidos.dia, 
    estados.estado
FROM detalles_pedidos_producto
INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
INNER JOIN detalles_menu ON menus.id_menu = detalles_menu.id_menu
INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
WHERE detalles_estudiantes_escuela.id_escuela = ?";

$params = [$u['id_escuela']];

if ($dia) {
    $query .= " AND FIND_IN_SET(?, pedidos.dia)";
    $params[] = $dia;
}
if ($busqueda) {
    $query .= " AND (estudiantes.nombre LIKE ? OR estudiantes.apellido LIKE ? OR estudiantes.documento_est LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
}

$sqlMenusEstudiantes = $con->prepare($query);
$sqlMenusEstudiantes->execute($params);

$listMenus = [];

if ($sqlMenusEstudiantes -> rowCount() > 0) {
    while ($menus = $sqlMenusEstudiantes->fetch(PDO::FETCH_ASSOC)) {
        $listMenus[] = $menus;
    }
}

echo json_encode($listMenus);
?>