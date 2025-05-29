<?php
    require_once '../../PHPMailer-master/src/Exception.php';
    require_once '../../PHPMailer-master/src/PHPMailer.php';
    require_once '../../PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname = $_POST['nombre'];
        $correo = $_POST['email'];
        $mensaje = $_POST['mensaje'];

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kantarboles@gmail.com';
            $mail->Password = 'ilda zzrl jyou gjnk';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->CharSet = 'UTF-8';
            $mail->Port = 587;

            $mail->setFrom($correo, 'Mensaje');
            $mail->addAddress('kantarboles@gmail.com', 'NUTRIKIDS');

            $mail->addReplyTo($correo, $fullname);

            $mail->isHTML(true);
            $mail->Subject = "¡Informacion de Nuevo Mensaje de Contacto!";
            $mail->Body = "<p>{$mensaje}</p>";
            $mail->send();
            echo '<script>alert("Correo enviando exitosamente")</script>';
            echo '<script>window.location = "../../contacto.php"</script>';
            exit();
        } 
        catch (Exception $e) {
            echo '<script>alert("Error al enviar correo.")</script>';
            echo '<script>window.location = "../../contacto.php"</script>';
            exit();
        }
    }
?>