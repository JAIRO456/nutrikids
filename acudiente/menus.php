<?php
    session_start();
    require_once('../conex/conex.php');
    require_once('../include/validate_sesion.php');
    $conex = new Database;
    $con = $conex->conectar();
    
    include 'menu.php';
?>

<?php
    $cantidad = $_GET['cantidad'];
    $student = $_GET['student'];
    $days = $_GET['days'];
    $menu = $_GET['menu'];
    $listProduts = $_GET['productos'];

    $sqlInsertMenu = $con -> prepare("INSERT INTO menus (nombre_menu, precio) VALUES (?, ?)");
    if ($sqlInsertMenu -> execute([$menu])) {
        $idMenu = $con->lastInsertId();
        foreach ($$listProduts as $Produts) {
            $sql = $con->prepare("SELECT precio FROM producto WHERE id_producto = ?");
            $sql->execute([$Produts]);
            $verif = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $_GET['precio'];

            $sqlInsertDetsMenu = $con->prepare("INSERT INTO detalles_menu (cantidad, id_menu, id_producto, id_estado, subtotal) 
            VALUES ($cant, $idMenu, $Produts, 2, $precio)");
            $sqlInsertDetsMenu->execute();
        }
    }
?>