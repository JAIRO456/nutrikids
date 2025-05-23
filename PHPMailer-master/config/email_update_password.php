<?php
    session_start();
    require_once('../../conex/conex.php');
    $conex =new Database;
    $con = $conex->conectar();
    
    require_once '../../PHPMailer-master/src/Exception.php';
    require_once '../../PHPMailer-master/src/PHPMailer.php';
    require_once '../../PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    if (isset($_POST['enviar'])) {
        $correo = $_POST['email'];
        
        $sqlUsuario = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
        $sqlUsuario->execute([$correo]);
        $usuario = $sqlUsuario->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $new_password = rand(1000, 9999);
            $nombre = $usuario['nombre'];
            $apellido = $usuario['apellido'];
            
            $sqlUpdatePassword = $con->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
            $sqlUpdatePassword->execute([password_hash($new_password, PASSWORD_DEFAULT), $correo]);
            
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

                $mail->setFrom('kantarboles@gmail.com', 'NUTRIKIDS');
                $mail->addAddress($correo, "$nombre $apellido");

                $mail->isHTML(true);
                $mail->Subject = "Recuperación de contraseña NUTRIKIDS";
                $mail->Body = "
                    <p>Buen día.</p>
                    <p>Estimado/a {$nombre} {$apellido},</p>
                    <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta de NUTRIKIDS.</p>
                    <p>Tu nueva contraseña es: <strong>{$new_password}</strong></p>
                    <p>Por favor, inicia sesión con esta nueva contraseña.</p>
                    <p>¡Gracias por ser parte de NUTRIKIDS! Estamos aquí para ayudarte a fomentar hábitos saludables.</p>
                    <p>Atentamente,</p>
                    <p>El equipo de NUTRIKIDS</p>
                    <p><a href='https://nutrikids.com'>nutrikids.com | soporte@nutrikids.com</a></p>";
                $mail->send();
                echo '<script>alert("Se ha enviado un correo con la nueva contraseña")</script>';
                echo '<script>window.location = "../../login.html"</script>';
            } 
            catch (Exception $e) {
                error_log("Error al enviar correo: {$mail->ErrorInfo}");
                return false;
            }
        }
    }
    else {
        echo '<script>alert("El correo no está registrado en el sistema")</script>';
        echo '<script>window.location = "../../recuperar_contraseña.php"</script>';
    }
?>