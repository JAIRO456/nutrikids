<?php

require_once('conex/conex.php');
$conex =new Database;
$con = $conex->conectar();
session_start();

$rol = 1;
$estado = 1;
?>


<?php
    if (isset($_POST['submit-button'])){
        $name = $_POST['doc'];
        $ape = $_POST['doc1'];
        $doc = $_POST['doc2'];
        $email = $_POST['doc3'];
        $tel = $_POST['doc4'];
        $tel2 = $_POST['doc5'];
        $esc = $_POST['doc6'];

        $contrasena_hash = password_hash($tel2, PASSWORD_DEFAULT);
        
        $sqlInsert = $con->prepare("INSERT INTO usuarios (documento, nombre, apellido, email, telefono, password, id_escuela, id_rol, id_estado) VALUES ('$doc', '$name', '$ape', '$email', '$tel', '$contrasena_hash', '$esc', '$rol', '$estado')");
            $sqlInsert->execute();
            echo '<script>alert("Registro Guardado")</script>';
            echo '<script>window.location = "agregar.php"</script>';
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>no</h1>
    <form action="" method="post">
        <input type="number" name="doc">
        <input type="text" name="doc1">
        <input type="text" name="doc2">
        <input type="varchar" name="doc3">
        <input type="number" name="doc4">
        <input type="varchar" name="doc5">
        <input type="number" name="doc6">

        <button type="submit" name="submit-button">gdfd</button>
    </form>
</body>
</html>