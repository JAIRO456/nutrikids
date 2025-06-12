<?php
    require_once '../libraries/PHPMailer-master/src/Exception.php';
    require_once '../libraries/PHPMailer-master/src/PHPMailer.php';
    require_once '../libraries/PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    function email_menu_estado($email, $nombre_usu, $apellido_usu, $nombre_est, $apellido_est, $nombre_menu, $id_estado, $con) {

        $documento = $_SESSION['documento'];
        $sqlSchools = $con->prepare("SELECT escuelas.nombre_escuela FROM escuelas
        INNER JOIN detalles_usuarios_escuela ON escuelas.id_escuela = detalles_usuarios_escuela.id_escuela
        WHERE detalles_usuarios_escuela.documento = ?"); 
        $sqlSchools->execute([$documento]);
        $school = $sqlSchools->fetch(PDO::FETCH_ASSOC);

        $fecha_actual = date('d/m/Y');

        $MenuEntregado = '';
        $estado = '';
        
        if ($id_estado == 3) {
            $estado = 'Entregado';
            $MenuEntregado = '<p>El menú fue entregado satisfactoriamente al estudiante durante el horario establecido.</p>';  
        } else {
            $estado = 'No Entregado';
            $MenuEntregado = '<p>Lamentablemente, no fue posible entregar el menú al estudiante durante el horario establecido, debido a que el estudiante no se presentó en el horario establecido.</p>';
        }

        $mail = new PHPMailer(true);
        try { 
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nutrikids.fj@gmail.com';
            $mail->Password = 'bbyn qnjf ehol bqyu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->CharSet = 'UTF-8';
            $mail->Port = 587;

            $mail->setFrom('nutrikids.fj@gmail.com', 'NUTRIKIDS');
            $mail->addAddress($email, "$nombre_usu $apellido_usu");

            $mail->isHTML(true);
            $mail->Subject = "¡Informe sobre la entrega del menú {$nombre_menu}!";
            $mail->Body = "
                <p>Buen día.</p>
                <p>Estimado/a {$nombre_usu} {$apellido_usu},</p>
                <p>Espero que este mensaje te encuentre bien.</p>
                <p>Informamos que el menú {$nombre_menu} al dia de hoy {$fecha_actual} ha sido {$estado} al estudiante {$nombre_est} {$apellido_est}.</p>
                <p>{$MenuEntregado}</p>
                <p>Agradecemos tu atención y comprensión.</p>
                <p>Atentamente,</p>
                <p>El equipo de NUTRIKIDS</p>
                <p>{$school['nombre_escuela']}</p>
                <p>¡Gracias por usar NUTRIKIDS! Estamos emocionados de acompañarte a ti y a tu familia en este viaje hacia una vida más saludable.</p>";
            $mail->send();
            return true;
        } 
        catch (Exception $e) {
            error_log("Error al enviar correo: {$mail->ErrorInfo}");
            return false;
        }
    }
?>