<?php
    require_once '../../libraries/PHPMailer-master/src/Exception.php';
    require_once '../../libraries/PHPMailer-master/src/PHPMailer.php';
    require_once '../../libraries/PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    function email_estado($email, $nombre, $apellido) {
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
            $mail->addAddress($email, "$nombre $apellido");

            $mail->isHTML(true);
            $mail->Subject = "¡Tu cuenta de NUTRIKIDS ya está activa!";
            $mail->Body = "
                <p>Buen día.</p>
                <p>Estimado/a {$nombre} {$apellido},</p>
                <p>¡Bienvenido/a a NUTRIKIDS!</p>
                <p>Nos complace informarte que tu cuenta ha sido activada con éxito. Ya puedes iniciar sesión en la aplicación de NUTRIKIDS y comenzar a explorar nuestras herramientas y recursos diseñados para fomentar hábitos alimenticios saludables en los niños.</p>
                <p>Para comenzar, solo necesitas:</p>
                <p>1. Abrir la aplicación de NUTRIKIDS o visitar <a href='https://nutrikids.com'>nutrikids.com</a>.</p>
                <p>2. Iniciar sesión con tu número de documento y contraseña.</p>
                <p>Si tienes alguna pregunta o necesitas ayuda, nuestro equipo de soporte está a tu disposición.</p>
                <p>Contáctanos en soporte@nutrikids.com.</p>
                <p>¡Gracias por unirte a la comunidad de NUTRIKIDS! Estamos emocionados de acompañarte a ti y a tu familia en este viaje hacia una vida más saludable.</p>
                <p>Atentamente,</p>
                <p>El equipo de NUTRIKIDS</p>
                <p><a href='https://nutrikids.com'>nutrikids.com</a> | soporte@nutrikids.com</p>";
            $mail->send();
            return true;
        } 
        catch (Exception $e) {
            error_log("Error al enviar correo: {$mail->ErrorInfo}");
            return false;
        }
    }
?>