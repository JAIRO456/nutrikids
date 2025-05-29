<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

<<<<<<< HEAD
    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios 
    INNER JOIN detalles_usuarios_escuela 
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    $sqlMenusEstudiantes = $con->prepare("SELECT menus.id_menu, estudiantes.documento_est, estudiantes.nombre, estudiantes.apellido, menus.nombre_menu, estados.estado FROM detalles_pedidos_producto
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN detalles_menu ON menus.id_menu = detalles_menu.id_menu
    INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
    WHERE detalles_estudiantes_escuela.id_escuela = ?");
    $sqlMenusEstudiantes->execute([$u['id_escuela']]);
=======
<<<<<<< HEAD
    $sqlMenusEstudiantes = $con->prepare("SELECT detalles_pedidos_producto.id_det_ped_prod, estudiantes.nombre, menus.nombre_menu, estados.estado FROM detalles_pedidos_producto
    INNER JOIN pedidos ON detalles_pedidos_producto.id_pedido = pedidos.id_pedidos
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    INNER JOIN menus ON detalles_pedidos_producto.id_menu = menus.id_menu
    INNER JOIN producto ON detalles_pedidos_producto.id_producto = producto.id_producto
    INNER JOIN estados ON pedidos.id_estado = estados.id_estado");
=======
    $sqlMenusEstudiantes = $con->prepare("SELECT * FROM estudiantes INNER JOIN estados ON estudiantes.id_estado = estados.id_estado");
>>>>>>> 07e8428420d0f8ce8d201799ed79a099eca68b22
    $sqlMenusEstudiantes->execute();
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57

    $listMenus = [];

    if ($sqlMenusEstudiantes -> rowCount() > 0) {
        while ($menus = $sqlMenusEstudiantes->fetch(PDO::FETCH_ASSOC)) {
            $listMenus[] = $menus;
        }
    }
    
    echo json_encode($listMenus);
?>