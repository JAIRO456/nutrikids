<?php include 'menu.html'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/logo-nutrikids2.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>NUTRIKIDS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container-contacto {
            margin: 0;
            padding: 10%;
            padding-top: 8%; 
            font-family: Arial, sans-serif;
            max-width: 100%;
            align-items: center;
            justify-content: center;
        }
        .container-contacto h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #00b894;
            text-align: center;
        }
        .container-contacto p {
            font-size: 1.2rem;
            color: #555;;
        }
        .container-p {
            width: 100%;
            height: 100%;
            padding: 20px;
            margin-bottom: 30px;
        }
        .container-card {
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
            border-radius: 10px;
            border: 1px solid #00b894;
            padding: 20px;
            margin-bottom: 30px;
        }
        .row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .card {
            width: 50%;
            height: 100%;
            padding: 20px;
            margin-bottom: 20px;
        }
        .card ul {
            list-style: none;
            padding: 0;
        }
        .card ul li {
            padding: 5%;
        }
        .card ul li i {
            color: #77b885;
            margin-right: 10px;
        }
        .card ul li a {
            color: #77b885;
        }
        .container-form {
            width: 50%;
            height: 100%;
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
        .x_input input, .x_input textarea {
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
        .x_input textarea {
            max-width: 100%;
            min-width: 100%;
            width: 100%;
            max-height: 100px;
            min-height: 100px;
            height: 100%;
        }
        .x_input input:focus, .x_input textarea:focus {
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
            background-color: #d9534f;
            color: white;
        }
        button[type="submit"]:hover {
            background-color: #c9302c;
        }
        .container-map {
            width: 100%;
            height: 420px;
        }
        .map {
            width: 100%;
            height: 100%;
        }
        .map iframe {
            width: 100%;
            height: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <main class="container-contacto">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2>Contacto</h2>
                <div class="container-p">
                    <p>
                        "Estamos aquí para ayudarte en todo lo que necesites. No dudes en ponerte en contacto con nosotros; nuestro equipo está comprometido a ofrecerte la mejor atención posible, 
                        con un enfoque personalizado y soluciones rápidas. Tu satisfacción es nuestra prioridad, y estamos listos para asistirte en cada paso."
                    </p>
                    <p>Utiliza las siguientes vías de contacto, o rellena el formulario.</p>
                </div>
                <div class="container-card">
                    <div class="row">
                        <div class="card">
                            <ul class="list-unstyled">
                                <li>
                                    <i class="fa fa-envelope me-2"></i>
                                    <strong>Vía E-mail:</strong> 
                                    <a href="mailto:nutrikids.fj@gmail.com" class="text-decoration-none" target="_blank">
                                        nutrikids.fj@gmail.com
                                    </a>
                                    </li>
                                <li>
                                    <i class="fa fa-instagram me-2"></i>
                                    <strong>Instagram:</strong>
                                    <a href="https://instagram.com/nutrikids.fj" class="text-decoration-none" target="_blank">
                                        @nutrikids.fj
                                    </a>
                                    </li>
                                <li>
                                    <i class="fa fa-facebook me-2"></i>
                                    <strong>Facebook:</strong>
                                    <a href="https://facebook.com/NutrikidsFJ" class="text-decoration-none" target="_blank">
                                        Nutrikids FJ
                                    </a>
                                    </li>
                                <li>
                                    <i class="fa fa-phone me-2"></i>
                                    <strong>Por teléfono:</strong>
                                    <a href="https://wa.me/573244845451?text=Hola%20quiero%20más%20información" target="_blank" style="text-decoration:none;">
                                        3244845451 <i class="fa fa-whatsapp text-success"></i>
                                    </a>
                                        /
                                    <a href="https://wa.me/573138492816?text=Hola%20quiero%20más%20información" target="_blank" style="text-decoration:none;">
                                        3138492816 <i class="fa fa-whatsapp text-success"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                            <!-- Formulario -->
                        <div class="container-form">
                            <form action='libraries/PHPMailer-master/config/email_contacto.php' method="post" id="form">
                                <div class="x_grupo">
                                    <label for="nombre">Nombre y Apellido</label>
                                        <div class="x_input">
                                            <input type="varchar" id="nombre" name="nombre" placeholder="Escribe tu primernombre y primer apellido" required>
                                            <i class="form_estado fa fa-exclamation-circle"></i>
                                        </div>
                                    <p class="x_typerror">Nombre inválido o Apellido inválido, debe ser un texto, ejemplo: Juan Perez.</p>
                                </div>
                                <div class="x_grupo">
                                    <label for="email">E-mail</label>
                                    <div class="x_input">
                                        <input type="email" id="email" name="email" placeholder="Escribe tu e-mail" required>
                                        <i class="form_estado fa fa-exclamation-circle"></i>
                                    </div>
                                    <p class="x_typerror">E-mail inválido, debe ser un correo electrónico, ejemplo: juan@gmail.com.</p>
                                </div>
                                <div class="x_grupo">
                                    <label for="mensaje">Mensaje</label>
                                    <div class="x_input">
                                        <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje" required></textarea>
                                        <i class="form_estado fa fa-exclamation-circle"></i>
                                    </div>
                                    <p class="x_typerror">Mensaje inválido, debe ser un texto, ejemplo: Hola, me gustaría más información sobre el producto, etc.</p>
                                </div>
                                <div class="form1-buttons">
                                    <button type="submit" name="enviar" id="botton">ENVIAR</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mapa de Google Maps -->
            <div class="container-map">
                <h5 class="mb-3">Ubicación</h5>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3975.690379575584!2d-75.1497437!3d4.4020729!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e38daac36ef33ef%3A0xc4167c4b60b14a15!2sSENA%20Centro%20de%20Industria%20y%20de%20la%20Construcci%C3%B3n!5e0!3m2!1ses!2sco!4v1717000000000!5m2!1ses!2sco" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </main>
    <?php // include "footer.html"; ?>
    <script src="validate/validar.js"></script>
</body>
</html>