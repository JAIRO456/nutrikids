<?php
require_once('../conex/conex.php');
$conex = new Database;
$con = $conex->conectar();

// Mostrar TODOS los pedidos (para prueba)
$sql = "SELECT p.id_pedidos, p.documento, p.dia, e.estado
        FROM pedidos p
        JOIN estados e ON p.id_estado = e.id_estado
        ORDER BY p.id_pedidos DESC";

$stmt = $con->prepare($sql);
$stmt->execute();
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($pedidos);