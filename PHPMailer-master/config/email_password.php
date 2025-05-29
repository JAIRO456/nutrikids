<?php
    require_once '../../PHPMailer-master/src/Exception.php';
    require_once '../../PHPMailer-master/src/PHPMailer.php';
    require_once '../../PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    function email_password($email, $nombre, $apellido, $documento, $password_code) {
        $password_desencriptado = $password_code;
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
            $mail->Subject = "¡Bienvenido/a a NUTRIKIDS! Tu cuenta ha sido creada";
            $mail->Body = "
                <p>Buen día.</p>
                <p>¡Bienvenido/a a NUTRIKIDS!</p>
                <p>Estimado/a {$nombre} {$apellido},</p>
                <p>Nos complace informarte que tu cuenta ha sido creada con éxito. A continuación, encontrarás los detalles para iniciar sesión en nuestra aplicación:</p>
                <p><strong>Usuario:</strong> {$documento}</p><br>
                <p><strong>Contraseña:</strong> {$password_desencriptado}</p><br>
                <p>Para comenzar, haz clic en el siguiente enlace e inicia sesión:</p>
                <p><a href='http://localhost/project/nutrikids/login.html'>Iniciar sesión en NUTRIKIDS</a></p>
                <p>Si tienes alguna pregunta o necesitas asistencia, nuestro equipo de soporte está disponible en soporte@nutrikids.com.</p>
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