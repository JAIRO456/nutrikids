<?php

session_start();
require_once('../conex/conex.php');
include "adm_menu.html";
include "header_user.php";
$conex =new Database;
$con = $conex->conectar();

$rol = 4;
$estado = 2;


?>

<?php
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado");
    $sql -> execute();
    $u = $sql -> fetch();
?>

<?php
    if (isset($_POST['submit-button'])){
        $name = $_POST['nombre'];
        $ape = $_POST['apellido'];
        $doc = $_POST['documento'];
        $email = $_POST['email'];
        $tel = $_POST['telefono'];
        $esc = $_POST['escuela'];
        
        $sqlUser = $con -> prepare("SELECT * FROM usuarios WHERE documento = $doc");
        $sqlUser -> execute();
        $add = $sqlUser -> fetchAll(PDO::FETCH_ASSOC);

        if($add){
            echo '<script>alert("El documento ya existe, no se puede repetir")</script>';
            echo '<script>window.location = "agregar.php"</script>';
        }

        else{
            $sqlInsert = $con->prepare("INSERT INTO usuarios (documento, nombre, apellido, email, telefono, id_escuela, id_rol, id_estado) VALUES ('$doc', '$name', '$ape', '$email', '$tel', '$esc', '$rol', '$estado')");
            $sqlInsert->execute();
            echo '<script>alert("Registros Guardados")</script>';
            echo '<script>window.location = "agregar.php"</script>'; 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Vendedor</title>
    <link rel="stylesheet" href="../styles/vendedor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <main class="main-container">
        <section class="form-container">
            <h2>REGISTRO ACUDIENTES</h2>
            <form action="" method="POST" name="form1" id="form1" class="form1">
                <div class="x_grupo" id="x_nombre">
                    <label for="nombre">Nombres</label>
                    <div class="x_input">
                        <input type="text" id="nombre" name="nombre" placeholder="Ingrese sus nombres">
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Nombres inválido</p>
                </div>
                
                <div class="x_grupo" id="x_apellido">
                    <label for="apellido">Apellidos</label>
                    <div class="x_input">
                        <input type="text" id="apellido" name="apellido" placeholder="Ingrese sus nombres">
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Apellidos inválido</p>
                </div>
                
                <div class="x_grupo" id="x_documento">
                    <label for="documento">Documento</label>
                    <div class="x_input">
                        <input type="number" id="documento" name="documento" placeholder="Ingrese sus nombres">
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Documento inválido</p>
                </div>
                
                
                <div class="x_grupo" id="x_email">
                    <label for="email">Correo electrónico</label>
                    <div class="x_input">
                        <input type="varchar" id="email" name="email" placeholder="Ingrese sus nombres">
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Correo electrónico inválido</p>
                </div>
                
                <div class="x_grupo" id="x_telefono">
                    <label for="telefono">Telefono</label>
                    <div class="x_input">
                        <input type="number" id="telefono" name="telefono" placeholder="Ingrese sus nombres">
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Telefono inválido</p>
                </div>
                
                <select name="escuela" class="escuela" id="escuela">
                    <option value="">Seleccione la escuela</option>
                    <?php
                        $sqlSchool = $con -> prepare("SELECT * FROM escuelas");
                        $sqlSchool -> execute();

                        while($c = $sqlSchool -> fetch(PDO::FETCH_ASSOC)){
                            echo "<option value=" . $c["id_escuela"] . ">" . 
                            $c["nombre_escuela"] . "</option>";
                        }
                    ?>
                </select>
                    <div class="form-buttons">
                <button type="button" class="cancel-button" onclick="window.location.href='agregar.php';">CANCELAR</button>
                <button type="submit" name="submit-button" class="submit-button">CREAR CUENTA</button>
            </div>
            </form>
        
        </section>
    </main>
    
   <script src="../validate/validar.js"></script>
</body>
</html>