<?php
    session_start();
    require_once('../../conex/conex.php');
    require_once('../../include/validate_sesion.php');
    $conex = new Database();
    $con = $conex->conectar();

    require_once '../PHPMailer-master/src/Exception.php';
    require_once '../PHPMailer-master/src/PHPMailer.php';
    require_once '../PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    header('Content-Type: application/json'); // Set JSON response header

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
        $correo = $input['email'] ?? '';
        $nombre = $input['nombre'] ?? '';
        $apellido = $input['apellido'] ?? '';

        if (empty($correo) || empty($nombre) || empty($apellido)) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $sql = $con->prepare("SELECT nombre, apellido FROM usuarios WHERE email = ?");
        $sql->execute([$correo]);
        $username = $sql->fetch(PDO::FETCH_ASSOC);

        if ($username) {
            try {
                $mail = new PHPMailer(true);
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Disable in production
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'kantarboles@gmail.com';
                $mail->Password = 'ilda zzrl jyou gjnk';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('kantarboles@gmail.com', 'NUTRIKIDS');
                $mail->addAddress($correo);
                $mail->isHTML(true);
                $mail->Subject = "¡Tu cuenta de NUTRIKIDS ya está activa!";
                $mail->Body = "
                    <p>Buen día,</p>
                    <p>Estimado/a {$username['nombre']} {$username['apellido']},</p>
                    <p>¡Bienvenido/a a NutriKids! Nos complace informarte que tu cuenta ha sido activada con éxito. Ya puedes iniciar sesión en la aplicación de NutriKids y comenzar a explorar nuestras herramientas y recursos diseñados para fomentar hábitos alimenticios saludables en los niños.</p>
                    <p>Para comenzar, solo necesitas:</p>
                    <p>1. Abrir la aplicación de NutriKids o visitar <a href='https://nutrikids.com'>nutrikids.com</a>.</p>
                    <p>2. Iniciar sesión con tu número de documento y contraseña.</p>
                    <p>Si tienes alguna pregunta o necesitas ayuda, nuestro equipo de soporte está a tu disposición.</p>
                    <p>Contáctanos en soporte@nutrikids.com.</p>
                    <p>¡Gracias por unirte a la comunidad de NutriKids! Estamos emocionados de acompañarte a ti y a tu familia en este viaje hacia una vida más saludable.</p>
                    <p>Atentamente,</p>
                    <p>El equipo de NutriKids</p>
                    <p><a href='https://nutrikids.com'>nutrikids.com</a> | soporte@nutrikids.com</p>";

                $mail->send();
                echo json_encode(['success' => true]);
                exit;
            } 
            catch (Exception $e) {
                echo json_encode(['success' => false, 'error' => 'El correo no se ha podido enviar: ' . $mail->ErrorInfo]);
                exit;
            }
        } 
        else {
            echo json_encode(['success' => false, 'error' => 'El usuario no se encuentra registrado']);
            exit;
        }
    } 
    else {
        echo json_encode(['success' => false, 'error' => 'Acceso no autorizado']);
        exit;
    }
?>