<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<?php 

    if (isset($_GET['id'])) {
        $idEstudiante = addslashes($_GET['id']);

        if (isset($_POST['pedidos']) && !empty($_POST['pedidos'])) {
            $idPedido = $_POST['pedidos'];
        
            $sqlPedidos = $con->prepare("SELECT * FROM detalles_menu INNER JOIN estudiantes ON detalles_menu.documento_est = estudiantes.documento_est 
            INNER JOIN menus ON detalles_menu.id_menu = menus.id_menu INNER JOIN producto ON detalles_menu.id_producto = producto.id_producto 
            INNER JOIN pedidos ON detalles_menu.id_pedidos = pedidos.id_pedidos WHERE detalles_menu.documento_est = '$idEstudiante' AND pedidos.id_pedidos = $idPedido");
            $sqlPedidos->execute();
            $p = $sqlPedidos->fetchAll(PDO::FETCH_ASSOC);
        } 
        
        else {
            // Si no se selecciona ningún día, no se muestra productos
            $p = [];
        }
    }
        
?>

<?php
    if (isset($_POST['entregado'])){
        $idPedido = $_POST['pedidos'];

        $sqlUpdateEstudents = $con->prepare("UPDATE estudiantes SET id_estado = 4 WHERE documento_est = '$idEstudiante'");
        $sqlUpdateEstudents->execute();

        $sqlUpdatePedidos = $con->prepare("UPDATE detalles_menu SET id_estado = 4 WHERE documento_est = '$idEstudiante' AND id_pedidos = $idPedido");
        $sqlUpdatePedidos->execute();
    }

    if (isset($_POST['no_entregado'])){
        $idPedido = $_POST['pedidos'];

        $sqlUpdateEstudents = $con->prepare("UPDATE estudiantes SET id_estado = 5 WHERE documento_est = '$idEstudiante'");
        $sqlUpdateEstudents->execute();

        $sqlUpdatePedidos = $con->prepare("UPDATE detalles_menu SET id_estado = 5 WHERE documento_est = '$idEstudiante' AND id_pedidos = $idPedido");
        $sqlUpdatePedidos->execute();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/pedidos.css">
    <title>Document</title>
</head>
<body>
    <main class="container-main">
        <form action="" method="post">
            <h1>HORARIO ESCOLAR</h1>

            <h2 value="">Seleccione el dia</h2>
            <select name="pedidos" id="pedidos" class="pedidos" onchange="this.form.submit()">
                <option value="">---</option>
                    <?php
                        $sqlPedidos = $con -> prepare("SELECT * FROM pedidos");
                        $sqlPedidos -> execute();

                        while ($ped = $sqlPedidos->fetch(PDO::FETCH_ASSOC)) {
                            $selected = isset($_POST['pedidos']) && $_POST['pedidos'] == $ped["id_pedidos"] ? "selected" : "";
                            echo "<option value='" . $ped["id_pedidos"] . "' $selected>" . $ped["dias_sem"] . "</option>";
                        }
                    ?>
            </select>
            <br>
            <br>

            <table class="container-table">
                <tr>
                    <th>PRODUCTOS</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                </tr>

            <?php 
                $total = 0;
                if (!empty($p)) {
                    foreach ($p as $products) {
            ?>
                    <tr>
                        <td><?php echo $products['nombre_prod']; ?></td>
                        <td><?php echo $products['cantidad']; ?></td>
                        <td><?php echo $precio = $products['cantidad'] * $products['precio']; ?></td> 
                    </tr>

                    <?php $total += $precio; ?>
                    
            <?php } 
            } else {
                echo "<tr><td colspan='3'>No hay productos disponibles para el día seleccionado.</td></tr>";
            }
            ?>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total: <?php echo $total; ?></th>
                </tr>


            </table>
            <br>
            <input type="submit" name="entregado" class="entregado" value="ENTREGADO">
            <input type="submit" name="no_entregado" class="no_entregado" value="NO ENTREGADO">
        </form>
    </main>
</body>
</html>