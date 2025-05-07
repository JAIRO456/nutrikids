<?php

session_start();
require_once('../conex/conex.php');
$conex =new Database;
$con = $conex->conectar();

?>

<?php

    $doc2 = $_GET['id2'];
    $sqlMensajes = $con -> prepare("SELECT * FROM mensajes INNER JOIN escuelas ON mensajes.id_escuela = escuelas.id_escuela WHERE id = $doc2");
    $sqlMensajes->execute();
    $mensajes = $sqlMensajes->fetch();

?>



<?php

    if (isset($_POST['enviar'])){
        $id = $_POST['id'];
        $school = $_POST['escuela'];
        $mensaje = $_POST['mensaje'];

        $sqlInsert = $con -> prepare("INSERT INTO mensajes_respondidos (id, id_escuela, mensaje_resp) VALUES ('$id', '$school', '$mensaje')");
        $sqlInsert -> execute();

        $sql = $con -> prepare("UPDATE mensajes SET respondido = 1 WHERE id = $doc2");
        $sql -> execute();
        echo '<script>alert("Mensaje enviado")</script>';
        echo '<script>window.location = "inicio.php"</script>';
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
    <h2>Contenido del mensaje</h2>
    <div class="container-div">
        <p><strong>Nombres:</strong> <?php echo $mensajes['nombre_men']; ?></p>
        <p><strong>Correo:</strong> <?php echo $mensajes['email_men']; ?></p>
        <p><strong>Escuela:</strong> <?php echo $mensajes['nombre_escuela']; ?></p>
        <p><strong>Mensaje:</strong> <?php echo $mensajes['mensaje']; ?></p>
    </div>

    <h2>Responder mensaje</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $mensajes['id']; ?>">
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
        <textarea name="mensaje" placeholder="Ingresa el mensaje"></textarea>
        <input type="submit" name="enviar" value="enviar">
    </form>
</body>
</html>
