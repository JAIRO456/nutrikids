<<<<<<< HEAD
=======
<?php

session_start();
require_once('conex/conex.php');
include "menu.html";
$conex =new Database;
$con = $conex->conectar();

?>

<?php
    $sqlMensajes = $con -> prepare("SELECT * FROM mensajes_respondidos INNER JOIN escuelas ON mensajes_respondidos.id_escuela = escuelas.id_escuela
    INNER JOIN mensajes ON mensajes_respondidos.id = mensajes.id WHERE respondido = 1 ORDER BY fecha_men DESC");
    $sqlMensajes->execute();
    $mensajes = $sqlMensajes->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
    if (isset($_POST['enviar'])){
        $name = $_POST['nombre'];
        $email = $_POST['email'];
        $tel = $_POST['telefono'];
        $esc = $_POST['escuela'];
        $men = $_POST['mensaje'];

        $sqlInsert = $con->prepare("INSERT INTO mensajes (nombre_men, email_men, telefono_men, mensaje, id_escuela) VALUES ('$name', '$email', '$tel', '$men', '$esc')");
        $sqlInsert->execute();
        echo '<script>alert("Mensaje enviado")</script>';
        echo '<script>window.location = "contacto.php"</script>';
    }
?>

>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>NUTRIKIDS</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center mb-3">Contacto</h2>
                <div class=''>
                    <p>"Estamos aquí para ayudarte en todo lo que necesites. No dudes en ponerte en contacto con nosotros; nuestro equipo está comprometido a ofrecerte la mejor atención posible, 
                    con un enfoque personalizado y soluciones rápidas. Tu satisfacción es nuestra prioridad, y estamos listos para asistirte en cada paso."</p>
                    <p>Utiliza las siguientes vías de contacto, o rellena el formulario.</p>
                </div>
                <form action='PHPMailer-master/config/email_contacto.php' class="container-form" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <ul>
                                <li><strong>Vía E-mail:</strong> nutrikids@example.com</li>
                                <li><strong>Nuestras redes sociales:</strong> @nutrikids</li>
                                <li><strong>Por teléfono:</strong> 91-234-567</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Escribe tu nombre primer nombre y primer apellido" required>
                            <input type="email" class="form-control" name="email" placeholder="Escribe tu e-mail" required>
                            <textarea class="form-control" name="mensaje" placeholder="Escribe tu mensaje" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-danger">Enviar Mensaje</button>
                    </div>
                </form>
            </div>
        </div>
=======
    <link rel="stylesheet" href="styles/index_contacto.css">
    <title>NUTRIKIDS</title>
</head>
<body>
    <main class="container-main">
        <section class="container-section">
            <div class="container-div">
                <h1>Contacto</h1> 
                <p>"Estamos aquí para ayudarte en todo lo que necesites. No dudes en ponerte en contacto con nosotros; nuestro equipo está comprometido a ofrecerte la mejor atención posible, 
                    con un enfoque personalizado y soluciones rápidas. Tu satisfacción es nuestra prioridad, y estamos listos para asistirte en cada paso."</p>
                <p>Utiliza las siguientes vías de contacto, o rellena el formulario.</p>
            </div>

            <div class="container-div2">
                <div class="contacto">
                    <ul>
                        <li><strong>Vía E-mail:</strong> nutrikids@example.com</li>
                        <li><strong>Nuestras redes sociales:</strong> @nutrikids</li>
                        <li><strong>Por teléfono:</strong> 91-234-567</li>
                    </ul>
                </div>

                <form class="container-form" method="post">
                    <input type="text" name="nombre" placeholder="Escribe tu nombre primer nombre y primer apellido" required>
                    <input type="email" name="email" placeholder="Escribe tu e-mail" required>
                    <input type="tel" name="telefono" placeholder="Escribe tu teléfono (Opcional)">
                    <select name="escuela" class="escuela" id="escuela">
                        <option value="">---</option>
                        <?php
                            $sqlSchool = $con -> prepare("SELECT * FROM escuelas");
                            $sqlSchool -> execute();

                            while($c = $sqlSchool -> fetch(PDO::FETCH_ASSOC)){
                                echo "<option value=" . $c["id_escuela"] . ">" . 
                                $c["nombre_escuela"] . "</option>";
                            }
                        ?>
                    </select>
                    <textarea class="mensaje" name="mensaje" placeholder="Escribe tu mensaje" required></textarea>
                    <button type="submit" name="enviar" class="enviar">Enviar Mensaje</button>
                </form>
            </div>
        </section>
>>>>>>> 445ed401a5f306f3c2b0b9e88e67d6a8e6bd8c57
    </main>

    <?php include "footer.html"; ?>
</body>
</html>