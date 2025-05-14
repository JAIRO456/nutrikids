<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login.css">
    <!-- <title></title> -->
</head>
<body>
    <header class="container-header">
        <div class="container-logo-header">
            <a href="index.php"><img class="logo" src="img/logo-nutrikids.png" alt=""></a>
        </div>
    </header>
    
    <main class="container-main">
        <section class="container-section">
            <h1 class="title">NUTRIKIDS</h1>
            <p class="subtitle">"Elige sabiamente para garantizar el bienestar y el futuro de tus hijos, tomando decisiones que les brinden un ambiente seguro, amoroso y lleno de oportunidades para su desarrollo integral."</p>
        </section>

        <section class="container-section2">
            <h1 class="title2">Recuperar Contraseña</h1>
            <form action="PHPMailer-master/config/email_update_password.php" method="post" name="form1" id="form1" class="form1">
                <div class="container-input">
                    <label for="email" class="label">CORREO</label>
                    <input type="email" name="email" id="email" class="email" placeholder="Ingrese su correo" required>
                </div>

                <button type="submit" name="enviar" id="botton">ENVIAR</button>
                <button type="button" href="login.html" class="btn red">REGRESAR</button>
            </form>
        </section>
    </main>

    <footer class="container-footer">
        <p class="container-p">"Mantener una alimentación saludable no solo contribuye a un bienestar inmediato, sino que también juega un papel fundamental en la prevención de enfermedades crónicas a largo plazo, 
            mejorando tu calidad de vida y fortaleciendo el sistema inmunológico para enfrentar los desafíos del futuro. :D"</p>
    </footer>
</body>
    <script src="validate/validar.js"></script>
</html>