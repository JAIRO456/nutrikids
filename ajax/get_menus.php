<?php
    session_start();
    require_once('../conex/conex.php');
    $conex = new Database;
    $con = $conex->conectar();

    $documento = $_SESSION['documento'];
    $sql = $con->prepare("SELECT * FROM usuarios 
    INNER JOIN detalles_usuarios_escuela 
    INNER JOIN escuelas ON detalles_usuarios_escuela.id_escuela = escuelas.id_escuela
    WHERE usuarios.documento = ?");
    $sql->execute([$documento]);
    $u = $sql->fetch(PDO::FETCH_ASSOC);

    $sqlMenusEstudiantes = $con->prepare("SELECT DISTINCT menus.id_menu, estudiantes.documento_est, estudiantes.nombre, estudiantes.apellido, menus.nombre_menu, estados.estado FROM detalles_menu
    INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu 
    INNER JOIN estados ON detalles_menu.id_estado = estados.id_estado
    INNER JOIN detalles_pedidos_producto ON menus.id_menu = detalles_pedidos_producto.id_menu
    INNER JOIN estudiantes ON detalles_pedidos_producto.documento_est = estudiantes.documento_est
    INNER JOIN detalles_estudiantes_escuela ON estudiantes.documento_est = detalles_estudiantes_escuela.documento_est
    INNER JOIN escuelas ON detalles_estudiantes_escuela.id_escuela = escuelas.id_escuela
    WHERE escuelas.id_escuela = ?");
    $sqlMenusEstudiantes->execute([$u['id_escuela']]);

    $listMenus = [];

    if ($sqlMenusEstudiantes -> rowCount() > 0) {
        while ($menus = $sqlMenusEstudiantes->fetch(PDO::FETCH_ASSOC)) {
            $listMenus[] = $menus;
        }
    }
    
    echo json_encode($listMenus);
?>