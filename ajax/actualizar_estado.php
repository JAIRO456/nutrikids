<?php
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();
    
    $data = json_decode(file_get_contents('php://input'), true);
    $id_pedidos = $data['id_pedidos'];
    $id_estado = $data['id_estado'];
    
    $stmt = $con->prepare("UPDATE pedidos SET id_estado = ? WHERE id_pedidos = ?");
    $success = $stmt->execute([$id_estado, $id_pedidos]);
    
    echo json_encode(['success' => $success]);
?>