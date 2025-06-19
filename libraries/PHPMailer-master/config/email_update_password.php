<?php
    session_start();
    require_once('../../../database/conex.php');
    $conex =new Database;
    $con = $conex->conectar();
    
    require_once '../../../libraries/PHPMailer-master/src/Exception.php';
    require_once '../../../libraries/PHPMailer-master/src/PHPMailer.php';
    require_once '../../../libraries/PHPMailer-master/src/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $correo = $_POST['email'];
        
        $sqlUsuario = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
        $sqlUsuario->execute([$correo]);
        $usuario = $sqlUsuario->fetch(PDO::FETCH_ASSOC);

        function generatePassword() {
            $minusculas = 'abcdefghijklmnopqrstuvwxyz';
            $mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numeros = '0123456789';
            $especiales = '#_-+';
            // $especiales = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    
            $todosCaracteres = $minusculas . $mayusculas . $numeros . $especiales;
    
            $contrasena = $minusculas[rand(0, strlen($minusculas) - 1)];
            $contrasena .= $mayusculas[rand(0, strlen($mayusculas) - 1)];
            $contrasena .= $numeros[rand(0, strlen($numeros) - 1)];
            $contrasena .= $especiales[rand(0, strlen($especiales) - 1)];
    
            for ($i = strlen($contrasena); $i < 8; $i++) {
                $contrasena .= $todosCaracteres[rand(0, strlen($todosCaracteres) - 1)];
            }
    
            return $contrasena;
        }

        if ($usuario) {
            $new_password = generatePassword();
            $nombre = $usuario['nombre'];
            $apellido = $usuario['apellido'];
            
            $sqlUpdatePassword = $con->prepare("UPDATE usuarios SET password = ? WHERE documento = ?");
            $sqlUpdatePassword->execute([password_hash($new_password, PASSWORD_DEFAULT), $usuario['documento']]);
            
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
                    <p><a href='https://nutrikidsfj.com'>nutrikidsfj.com | soporte@nutrikids.com</a></p>";
                $mail->send();
                // echo '<script>alert("Se ha enviado un correo con la nueva contraseña")</script>';
                // echo '<script>window.location = "../../../login.html"</script>';
                echo "
                    <style>
                        .modal {
                            display: none;
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0, 0, 0, 0.5);
                            justify-content: center;
                            align-items: center;
                        }
                        .modal-content {
                            background: white;
                            padding: 20px;
                            border-radius: 8px;
                            text-align: center;
                            width: 300px;
                        }
                        button {
                            padding: 10px 20px;
                            background: #007bff;
                            color: white;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                        }
                        button:hover {
                            background: #0056b3;
                        }
                    </style>
                    <div id='validateSesionModal' class='modal'>
                        <div class='modal-content'>
                            <p id='Message'></p>
                            <button onclick='closeModal()'>Cerrar</button>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showModal('Se ha enviado un correo con la nueva contraseña.');
                            setTimeout(() => {
                                window.location = '../../../login.html';
                            }, 3000);
                        });
                    
                        const validateSesionModal = document.getElementById('validateSesionModal');
                        const message = document.getElementById('Message');
                    
                        function showModal(msg) {
                            message.textContent = msg;
                            validateSesionModal.style.display = 'flex';
                        }
                        function closeModal() {
                            validateSesionModal.style.display = 'none';
                        }
                    </script>";
            } 
            catch (Exception $e) {
                error_log("Error al enviar correo: {$mail->ErrorInfo}");
                return false;
            }
        }
        else {
            echo '<script>alert("El correo no está registrado en el sistema")</script>';
            echo '<script>window.location = "../../recuperar_contraseña.php"</script>';
        }
    }
    else {
        echo '<script>alert("Método no permitido")</script>';
        echo '<script>window.location = "../../recuperar_contraseña.php"</script>';
    }
?>