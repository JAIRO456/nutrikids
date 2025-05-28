<?php
session_start();
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

    $data = json_decode(file_get_contents('php://input'), true);
    $idProducto = $data['id_producto'];

    if (!isset($_GET['productos'])) {
        $_GET['productos'] = [];
    }

    if (!in_array($idProducto, $_GET['productos'])) {
        $_GET['productos'][] = $idProducto;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Producto ya agregado']);
    }

?>
