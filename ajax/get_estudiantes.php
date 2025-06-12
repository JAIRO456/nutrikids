<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sqlStudents = $con -> prepare("SELECT SUM(informacion_nutricional.calorias * detalles_pedidos_producto.cantidad) AS total_cal, 
    SUM(informacion_nutricional.proteinas * detalles_pedidos_producto.cantidad) AS total_pro, 
    SUM(informacion_nutricional.carbohidratos * detalles_pedidos_producto.cantidad) AS total_car, 
    SUM(informacion_nutricional.grasas * detalles_pedidos_producto.cantidad) AS total_gras, 
    SUM(informacion_nutricional.azucares * detalles_pedidos_producto.cantidad) AS total_azu, 
    SUM(informacion_nutricional.sodio * detalles_pedidos_producto.cantidad) AS total_sod FROM informacion_nutricional 
    INNER JOIN producto ON informacion_nutricional.id_producto = producto.id_producto
    INNER JOIN detalles_pedidos_producto ON producto.id_producto = detalles_pedidos_producto.id_producto
    WHERE detalles_pedidos_producto.documento_est");
    $sqlStudents -> execute([$documento]);

    $listStudents = [];

    if ($sqlStudents -> rowCount() > 0) {
        while ($Students = $sqlStudents -> fetch(PDO::FETCH_ASSOC)) {
            $listStudents[] = $Students;
        }
    }
    
    echo json_encode($listStudents);
?>