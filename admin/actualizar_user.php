<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    $doc = $_GET['id'];
    $sqlUser = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado WHERE documento = $doc");
    $sqlUser -> execute();
    $u = $sqlUser -> fetch();
?>

<?php

    if (isset($_POST['Actualizar'])){
        $doc1 = $_POST['doc1'];
        // $nom1 = $_POST['name1'];;
        // $ape1 = $_POST['ape1'];
        // $email1 = $_POST['email1'];
        // $tel1 = $_POST['tel1'];
        // $img1 = $_POST[''];
        $rol1 = $_POST['id_rol'];
        $est1 = $_POST['id_est'];

        $update = $con -> prepare("UPDATE usuarios SET id_rol = '$rol1', id_estado = $est1 WHERE documento = '$doc1'");
        $update -> execute();
        echo '<script>alert("Usuario Actualizado")</script>';
        echo '<script>window.location = "roles.php"</script>';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/actualizar.css">
    <title>Document</title>
</head>
<body>
    <form class="container-form" action="" method="post" enctype="">
        <h1>Actualizar datos:</h1>
        <table class="container-table"> 
            <tbody class="container-tbody">
            <tr class="container-tr">    
                <th>Document</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
            <tr class="container-tr">
                <td><input type="number" name="doc1" readonly value="<?php echo $u["documento"];?>"></td>
                <td><input type="text" name="name1" readonly value="<?php echo $u["nombre"];?>"></td>
                <td><input type="text" name="ape1" readonly value="<?php echo $u["apellido"];?>"></td>
                <td><input type="varchar" name="email1" readonly value="<?php echo $u["email"];?>"></td>
                <td><input type="number" name="tel1" readonly value="<?php echo $u["telefono"];?>"></td>
                <td>
                    <select name="id_rol" id="id_rol">
                        <option value="<?php echo $u["id_rol"];?>"><?php echo $u["rol"];?></option>
                        <?php
                            $sqlRol = $con -> prepare("SELECT * FROM roles");
                            $sqlRol -> execute();

                            while($rol = $sqlRol -> fetch(PDO::FETCH_ASSOC)){
                                echo "<option value =" . $rol["id_rol"] . ">" . 
                                $rol["rol"] . "</option>";
                            }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="id_est" id="id_est">
                        <option value="<?php echo $u["id_estado"];?>"><?php echo $u["estado"];?></option>
                        <?php
                            $sqlEstado = $con -> prepare("SELECT * FROM estados WHERE id_estado < 3");
                            $sqlEstado -> execute();

                            while($est = $sqlEstado -> fetch(PDO::FETCH_ASSOC)){
                                echo "<option value =" . $est["id_estado"] . ">" . 
                                $est["estado"] . "</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <input type="submit" class="actualizar" value="Actualizar" name="Actualizar">
    </form>
    
</body>
</html>