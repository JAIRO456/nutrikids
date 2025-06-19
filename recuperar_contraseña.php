<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="icon" href="img/logo-nutrikids2.png" type="image/png">
    <title>Recuperar Contraseña</title>
</head>
<body onload="document.form.email.focus()">
    <header class="container-header">
        <div class="container-logo-header">
            <a href="index.php"><img class="logo" src="img/logo-nutrikids2.png" alt="Logo Nutrikids"></a>
        </div>
    </header>
    <main class="container-main">
        <div class="login-card">
            <h1 class="title2">Recuperar Contraseña</h1>
            <p class="subtitle">Ingresa el número de documento asociado a tu cuenta y te enviaremos instrucciones para restablecer tu contraseña.</p>
            <form action="libraries/PHPMailer-master/config/email_update_password.php" name="form" id="form" method="post" class="form">
                <div class="x_grupo" id="x_email">
                    <label for="email">Correo electrónico</label>
                    <div class="x_input">
                        <input type="email" id="email" name="email" placeholder="Ingrese su correo Gmail" required>
                        <i class="form_estado bi bi-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Correo inválido</p>
                </div>

                <div class="form-buttons">
                    <button type="submit">ENVIAR</button>
                    <button type="button" class="btn red" onclick="window.location.href='login'">CANCELAR</button>
                </div>
            </form>
            <div style="text-align:center; margin-top: 18px;">
                <button type="button" class="btn green" onclick="window.location.href='login'">
                    ¿Ya recordaste tu contraseña? Inicia sesión
                </button>
            </div>
        </div>
    </main>
    <script src="validate/validar.js"></script>
</body>