<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo-nutrikids2.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Recuperar Contraseña</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', Arial, Helvetica, sans-serif;
            width: 100%;
            height: 100%;
            background: #e9f5f5;
        }
        .container-header {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 40px;
            margin-bottom: 10px;
        }
        .container-logo-header a:-webkit-any-link {
            color: -webkit-link;
            cursor: pointer;
            text-decoration: underline;
        }
        .container-logo-header a img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0. 10);
            border: 3px solid #fff;
            background: #fff;
            transition: transform 0.2s;
        }
        .container-logo-header a img:hover {
            transform: scale(1.07) rotate(-6deg);
        }
        .container-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 6px 32px rgba(0, 0, 0, 0. 13);
            padding: 38px 32px 32px 32px;
            max-width: 370px;
            width: 100%;
            margin: 0 auto 30px auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: fadeIn 0.8s;
            border: 1px solid #00b894;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .login-card .title2 {
            color: #77b885;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: 1px;
            text-align: center;
        }
        .login-card .subtitle {
            color: #888;
            font-size: 1rem;
            font-style: italic;
            margin-bottom: 22px;
            text-align: center;
        }
        .form {
            width: 100%;
        }
        .x_grupo {
            margin-bottom: 20px;
            text-align: left;
        }
        .x_grupo label {
            font-weight: 600;
            color: #77b885;
            margin-bottom: 6px;
            display: block;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
        .x_input {
            position: relative;
            width: 100%;
        }
        .x_input input {
            width: 100%;
            height: 44px;
            padding: 0 40px 0 14px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: #f7fafc;
            font-size: 1rem;
            color: #333;
            outline: none;
            transition: border 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .x_input input:focus {
            border-color: #77b885;
            box-shadow: 0 0 0 2px #8dc2bf33;
            background: #f0fdfb;
        }
        .form_estado {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            pointer-events: none;
        }
        .x_typerror {
            display: none;
        }
        .x_typerror-block {
            color: #bb2929;
            font-size: 0.95rem;
            margin-top: 4px;
            display: block;
        }
        .x_grupo-incorrecto .x_input input {
            border: 2px solid #bb2929;
            background: #fff0f0;
        }
        .x_grupo-correcto .x_input input {
            border: 2px solid #1ed12d;
            background: #f0fff0;
        }
        .x_grupo-incorrecto .form_estado {
            color: #bb2929;
        }
        .x_grupo-correcto .form_estado {
            color: #1ed12d;
        }
        .form1-buttons {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }
        button {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s ease;
        }
        button:hover {
            filter: brightness(0.95);
            transform: translateY(-2px) scale(1.03);
        }
        button[type="submit"] {
            background-color: #77b885;
            color: white;
        }
        button[type="submit"]:hover {
            background-color: #5a8b66;
        }
        .btn.red {
            background-color: #d9534f;
            color: white;
        }
        .btn.red:hover {
            background-color: #c9302c;
        }
        @media (max-width: 600px) {
            .container-main {
                padding: 5%;
            }     
            .form1-buttons {
                flex-direction: column;
            }       
            .title2 {
                font-size: 1.5rem;
            }       
            .subtitle {
                font-size: 0.8rem;
            }
        }
    </style>
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
            <p class="subtitle">"Ingresa el  correo electronico asociado a tu cuenta y te enviaremos instrucciones para restablecer tu contraseña."</p>
            <form action="libraries/PHPMailer-master/config/email_update_password.php" name="form" id="form" method="post" class="form">
                <div class="x_grupo" id="x_email">
                    <label for="email">Correo electrónico</label>
                    <div class="x_input">
                        <input type="email" id="email" name="email" placeholder="Ingrese tu correo electrónico" required>
                        <i class="form_estado fa fa-exclamation-circle-fill"></i>
                    </div>
                    <p class="x_typerror">Correo inválido</p>
                </div>

                <div class="form1-buttons">
                    <button type="submit" name="enviar" id="botton">ENVIAR</button>
                    <button type="button" class="btn red" onclick="window.location.href='login.html'">REGRESAR</button>
                </div>
            </form>
            <div style="text-align:center; margin-top: 18px;">
                <a href="login.html" style="color:#77b885; text-decoration:underline; font-size:1rem;">
                    ¿Ya recordaste tu contraseña? Inicia sesión
                </a>
            </div>
        </div>
    </main>
    <script src="validate/validar.js"></script>
</body>
</html>